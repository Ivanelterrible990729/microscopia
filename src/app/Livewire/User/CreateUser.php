<?php

namespace App\Livewire\User;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateUser extends Component
{
    /**
     * Formulario de usuarios
     */
    public string|null $prefijo = null;
    public string|null $name = null;
    public string|null $cargo = null;
    public string|null $email = null;
    public string|null $password = null;
    public string|null $password_confirmation = null;

    public function render()
    {
        return view('livewire.user.create-user');
    }

    public function mount()
    {
        $this->generateRandomPassword();
    }

    public function generateRandomPassword($length = 8): void
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomPassword = '';

        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
        }

        $this->password = $this->password_confirmation = $randomPassword;
    }

    public function storeUser()
    {
        Gate::authorize('create', User::class);

        $userCreater = new CreateNewUser();
        $user = $userCreater->create($this->all());

        return redirect()->route('user.show', $user)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The user has been successfully stored.')
            ]
        ]);
    }
}
