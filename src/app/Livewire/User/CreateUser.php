<?php

namespace App\Livewire\User;

use App\Actions\Fortify\CreateNewUser;
use Livewire\Component;

class CreateUser extends Component
{
    public array $user;

    public function render()
    {
        return view('livewire.user.create-user');
    }

    public function mount()
    {
        $this->user = [
            'prefijo' => null,
            'name' => null,
            'cargo' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
        ];

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

        $this->user['password'] = $this->user['password_confirmation'] = $randomPassword;
    }

    public function storeUser()
    {
        $userCreater = new CreateNewUser();
        $user = $userCreater->create($this->user);

        return redirect()->route('user.show', $user)->with([
            'alert' => [
                'variant' => 'soft-primary',
                'icon' => 'check-circle',
                'message' => __('The user has been successfully stored.')
            ]
        ]);
    }
}
