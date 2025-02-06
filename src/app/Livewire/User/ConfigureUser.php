<?php

namespace App\Livewire\User;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Collection;
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
     * Catalogo de los roles existentes en el sistema.
     */
    public array $availableRoles;

    /**
     * Funcion que carga los roles en el componente.
     */
    public function getAvailableRoles(): array
    {
        $query = Role::query();

        if (!request()->user()->hasRole(RoleEnum::Desarrollador)) {
            $query = $query->where('name', '!=', RoleEnum::Desarrollador);
        }

        return $query->get()->map(function($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
            ];
        })->toArray();
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $user->load('roles');

        $this->state['user_id'] = $user['id'];
        $this->state['roles'] = $user->roles->pluck('id')->toArray();
        $this->availableRoles = $this->getAvailableRoles();
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
        $user->syncRoles(Role::whereIn('id', $this->state['roles'])->pluck('id'));
        $user->save();

        return redirect()->route('user.show', $this->state['user_id'])->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('Saved user settings')
            ]
        ]);
    }
}
