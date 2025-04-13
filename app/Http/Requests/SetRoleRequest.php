<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetRoleRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /** @var int|string|null $roleId */
        $roleId = $this->route('id');

        return [
            'role' => "required|unique:roles,name,$roleId"
        ];
    }
}
