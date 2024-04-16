<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserService
{

    const VALIDATION_RULES = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
    ];
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    /**
     * @param Request $request
     * @return void
     *
     * @throws ValidationException
     */
    public function createUser(Request $request): void
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        // set a dummy password
        $validated['password'] = Hash::make(Str::random(16));

        User::create($validated);
    }

    public function updateUser(Request $request, User $user): void
    {
        $updateValidationRules = [
            'name' => self::VALIDATION_RULES['name'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user),
            ],
        ];
        $validated = $request->validate($updateValidationRules);

        $user->update($validated);
    }

    public function removeUser(User $user): void
    {
        $user->delete();
    }
}
