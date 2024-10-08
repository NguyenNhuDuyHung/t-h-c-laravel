<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGenerateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:generates,name,' . $this->id. '',
            'schema' => 'required',
            'module_type' => 'gt:0',
            'module' => 'required',
            'path' => 'required',
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Bạn chưa nhập tên model',
            'name.unique' => 'Tên module đã tồn tại',
            'schema.required' => 'Bạn chưa nhập schema',
            'module_type.gt' => 'Bạn chưa chọn loại module',
            'module.required' => ' Bạn chưa nhập tên module',
            'path.required' => ' Bạn chưa nhập đường dẫn',
            'path.unique' => 'Đường dẫn đã tồn tại'
        ];
    }
}