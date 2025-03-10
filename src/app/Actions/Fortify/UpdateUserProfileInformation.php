<?php

namespace App\Actions\Fortify;

use App\Contracts\Services\ActivityInterface;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function __construct(protected ActivityInterface $activityService) {}

    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:' . config('max-file-size.profile_photos')],
            'cargo' => ['nullable', 'string', 'max:255'],
            'prefijo' => ['nullable', 'string', 'max:255'],
        ])->validateWithBag('updateProfileInformation');

        $this->activityService->setOldProperties([
            'id' => $user->id,
            'prefijo' => $user->prefijo,
            'name' => $user->name,
            'cargo' => $user->cargo,
            'email' => $user->email,
            'profile_photo_path' => $user->profile_photo_path,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'deleted_at' => $user->deleted_at,
        ]);

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'cargo' => $input['cargo'],
                'prefijo' => $input['prefijo'],
            ])->save();
        }

        $this->activityService->logActivity(
            logName: __('Users'),
            performedOn: $user,
            properties: [
                'id' => $user->id,
                'prefijo' => $user->prefijo,
                'name' => $user->name,
                'cargo' => $user->cargo,
                'email' => $user->email,
                'profile_photo_path' => $user->profile_photo_path,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'deleted_at' => $user->deleted_at,
            ],
            description: __('User updated.')
        );
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
