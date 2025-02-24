<?php

namespace App\Livewire\User;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ConfigureUser extends Component
{
    /**
     * Usuario al cual realizar la configuración.
     */
    public User $user;

    /**
     * Roles a asignar al usuario.
     */
    #[Validate('required|array|min:0')]
    public array $roles = [];

    /**
     * Catalogo de los roles existentes en el sistema.
     */
    public array $availableRoles;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->roles = $user->roles->pluck('name')->toArray();
        $this->availableRoles = $this->getAvailableRoles();
    }

    public function render()
    {
        return view('livewire.user.configure-user');
    }

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

    public function save()
    {
        Gate::authorize('assignRoles', $this->user);
        $this->validate();

        $this->user->syncRoles($this->roles);
        $this->user->save();

        return redirect()->route('user.show', $this->user)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('Saved user settings')
            ]
        ]);
    }
}
