<?php

namespace App\Actions\Fortify;

use App\Contracts\Services\ActivityInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function __construct(protected ActivityInterface $activityService) {}

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'cargo' => ['nullable', 'string', 'max:255'],
            'prefijo' => ['nullable', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'cargo' => $input['cargo'],
            'prefijo' => $input['prefijo'],
            'password' => Hash::make($input['password']),
        ]);

        $this->activityService->logActivity(
            logName: __('Users'),
            performedOn: $user,
            properties: [
                'id' => $user->id,
                'prefijo' => $user->prefijo,
                'name' => $user->name,
                'cargo' => $user->cargo,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'deleted_at' => $user->deleted_at,
            ],
            description: __('User created.')
        );

        return $user;
    }
}
