<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return \Auth::user()->can('store', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'. $this->id,
            'profile_id' => 'required|numeric|exists:profiles,id',
        ];

        if (!$this->has('id')) {
            $rules['password'] = 'required|min:8|confirmed|regex:/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/';
        } else {
            $rules['password'] = 'nullable|min:8|confirmed|regex:/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'profile_id' => 'Grupo de Acesso',
        ];
    }
}
