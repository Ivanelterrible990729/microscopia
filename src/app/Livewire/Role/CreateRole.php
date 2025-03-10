<?php

namespace App\Livewire\Role;

use App\Livewire\Forms\RoleForm;
use App\Services\RoleService;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateRole extends Component
{
    /**
     * Form para la creación del rol.
     */
    public RoleForm $form;

    public function render()
    {
        return view('livewire.role.create-role');
    }

    /**
     * Asigna datos del rol.
     */
    public function storeRole(RoleService $roleService)
    {
        Gate::authorize('create', Role::class);
        $this->validate();

        return redirect()->route('role.show', $roleService->createRole($this->form->all()))->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The role has been successfully stored.')
            ]
        ]);
    }
}
