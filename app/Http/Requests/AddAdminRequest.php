<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|alpha',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|string|numeric|max:10|min:10|unique:users',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function messages(): array
    {
        return  [
            'name.required' => 'The Name is required',
            'name.string' => 'Something wrong with the name',
            'name.max' => 'The name is too long',
            'name.alpha' => 'The name must have only latin letters',
            'email.required' => 'The email is required',
            'email.email' => 'The email is invalid',
            'email.max' => 'The email is too long',
            'email.unique' => 'The email is already exist',
            'phone.required' => 'The phone is required',
            'phone.string' => 'Something wrong with the password',
            'phone.max' => 'The Phone must be 10 digigts',
            'phone.min' => 'The Phone must be 10 digigts',
            'password.required' => 'The Password is required',
            'password.string' => 'Something wrong with the password',
            'password.min' => 'The Password must be 8 char or more',
        ];
    }
}
