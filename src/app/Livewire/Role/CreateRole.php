<?php

namespace App\Livewire\Role;

use App\Livewire\Forms\RoleForm;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateRole extends Component
{
    /**
     * Form para la creación del rol.
     */
    public RoleForm $roleForm;

        /**
     * Asigna datos del rol.
     *
     */
    public function mount()
    {
        $this->roleForm->role = [
            'name' => null,
            'guard_name' => 'web',
        ];
    }

    public function render()
    {
        return view('livewire.role.create-role');
    }

    /**
     * Asigna datos del rol.
     */
    public function storeRole()
    {
        Gate::authorize('create', Role::class);

        return redirect()->route('role.show', $this->roleForm->store())->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The role has been successfully stored.')
            ]
        ]);
    }
}
