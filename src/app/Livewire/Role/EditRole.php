<?php

namespace App\Livewire\Role;

use App\Livewire\Forms\RoleForm;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class EditRole extends Component
{
    /**
     * Form para la edición del rol.
     */
    public RoleForm $roleForm;

    /**
     * Asigna datos del rol.
     *
     */
    public function mount(Role $role)
    {
        $this->roleForm->roleModel = $role;
        $this->roleForm->role = $role->getAttributes();
    }

    public function render()
    {
        return view('livewire.role.edit-role');
    }

    /**
     * Asigna datos del rol.
     */
    public function updateRole()
    {
        Gate::authorize('update', $this->roleForm->roleModel);

        return redirect()->route('role.show', $this->roleForm->update())->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The role has been successfully updated.')
            ]
        ]);
    }
}
