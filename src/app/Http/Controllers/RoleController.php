<?php

namespace App\Http\Controllers;

use App\Services\Role\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Role::class);

        return view('role.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        Gate::authorize('view', $role);

        return view('role.show', compact('role'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleService $roleService, Role $role)
    {
        Gate::authorize('delete', $role);

        $roleService->deleteRole($role);

        return redirect(route('role.index'))->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The role has been successfully removed.')
            ]
        ]);
    }
}
