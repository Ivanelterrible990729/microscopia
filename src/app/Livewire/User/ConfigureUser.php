<?php

namespace App\Livewire\User;

use App\Enums\Permissions\UserPermission;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ConfigureUser extends Component
{
    public $user;

    /**
     * Roles a asignar al usuario.
     */
    public array $state = [
        'user_id' => null,
        'roles' => [],
    ];

    /**
     * Catálogo de los permisos existentes en el sistema agroupados por su prefijo.
     */
    #[Computed]
    public function availableRoles()
    {
        return Role::all()->map(function($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
            ];
        });
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $user->load('roles');

        $this->state['user_id'] = $user['id'];
        $this->state['roles'] = $user->roles->map(function($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.user.configure-user');
    }

    public function save()
    {
        if (request()->user()->cannot('assignRoles', $this->user)) {
            $this->addError('autorization', __('You do not have permissions to perform this action.'));
            return;
        }

        $user = User::findOrFail($this->state['user_id']);
        $user->syncRoles(array_column($this->state['roles'], 'name'));
        $user->save();

        $this->toast(title: __('Success'), message: __('Saved user settings'))->success();
    }
}
