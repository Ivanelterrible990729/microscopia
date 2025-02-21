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
    public RoleForm $form;

    /**
     * Modelo del rol a actualizar.
     */
    public Role $role;

    /**
     * Asigna datos del rol.
     *
     */
    public function mount(Role $role)
    {
        $this->role = $role;
        $this->form->fill($role->getAttributes());
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
        Gate::authorize('update', $this->role);

        return redirect()->route('role.show', $this->form->update($this->role))->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The role has been successfully updated.')
            ]
        ]);
    }
}
