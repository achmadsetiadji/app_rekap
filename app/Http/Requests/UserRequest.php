<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @var int|string
     */
    protected $role;

    /**
     * Constructor.
     * 
     */
    public function __construct()
    {
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /** @var int|string|null $userId */
        $userId = $this->route('user');

        $rules = [
            'name'         => 'required|string',
            'email'        => "required|unique:users,email,$userId",
            'password'     => 'nullable|min:6',
            'role'         => 'required|exists:roles,name',
        ];

        return $rules;
    }
}
