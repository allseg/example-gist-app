<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GistRequest extends FormRequest
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
            'description' => 'required|string',
            'public' => 'required|boolean',
            'files' => 'required|array|min:1',
            'files.*' => 'sometimes|nullable',
            'files.*.filename' => 'sometimes|string',
            'files.*.content' => 'sometimes|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'description.required' => 'Description is required',
            'files.required' => 'Must contain at least one file',
            'files.*.content.string' => 'Content is required',
            'files.*.filename.string' => 'Filename is required',
        ];
    }
}
