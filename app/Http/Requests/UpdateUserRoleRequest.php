<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateUserRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Must be authorized to update the user logic (handled by Policy usually, but checked here too)
        return Gate::allows('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role' => ['required', 'string', 'exists:roles,name', function ($attribute, $value, $fail) {
                // Privilege Escalation Prevention
                // A user cannot assign a role that is 'higher' than their own.
                // In this system: super-admin > admin > validator > pengusul
                
                $currentUser = $this->user();
                
                // If current user is super-admin, they can assign anything (Gate::before covers this usually, but let's be explicit)
                if ($currentUser->hasRole('super-admin')) {
                    return;
                }

                // Logic for other roles if they were allowed to manage users
                if ($value === 'super-admin') {
                    $fail('You cannot assign the Super Admin role.');
                }
            }],
        ];
    }
}
