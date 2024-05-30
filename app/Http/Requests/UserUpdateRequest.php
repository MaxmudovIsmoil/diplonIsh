<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|max:9|min:9',
            'status' => 'required',
            'photo' => 'sometimes',
            'username'=> ['required', Rule::unique('users', 'username')->ignore($this->user)],
//            'username' => 'required|min:3|unique:users,username,'.$this->id,
            'password' => 'sometimes',
            'instances.*' => 'required'
        ];
    }

}
