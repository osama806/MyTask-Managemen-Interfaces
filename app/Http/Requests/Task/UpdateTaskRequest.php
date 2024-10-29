<?php

namespace App\Http\Requests\Task;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
{
    use ResponseTrait;
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
            'title' => 'nullable|string|min:2|max:100|unique:tasks,title',
            'description' => 'nullable|string|max:256',
            'status' => 'nullable|string|in:pending,completed',
            'due_date' => 'nullable|date|date_format:Y-m-d',
        ];
    }

    /**
     * Get message that errors explanation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException($this->getResponse('errors', $validator->errors(), 422));
    }

    /**
     * Get custom attributes for validator errors.
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title' => 'Task title',
            'description' => 'Task description',
            'status' => 'Task status',
            'due_date' => 'Due date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute has already been taken',
            'numeric' => 'The :attribute must be a number.',
            'min' => 'The :attribute field must be at least 1.',
            'max' => 'The :attribute field must not be greater than 10.',
            'date' => 'Please provide a valid date for the :attribute.',
            'exists' => 'The selected user does not exist',
            'date_format' => 'The :attribute must be in the format of "yyyy-dd-mm" (e.g., 2024-12-25)',
        ];
    }
}
