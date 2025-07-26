<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date|after_or_equal:today',
            'assigned_to' => 'nullable|exists:users,id',
            'dependencies' => 'nullable|array',
            'dependencies.*' => 'exists:tasks,id',
        ];
        //create or update
        if ($this->isMethod('POST')) {
            $rules['status'] = 'nullable|in:pending,in_progress';
        } else {
            $rules['status'] = 'nullable|in:pending,in_progress,completed,canceled';
        }

        return $rules;
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->has('dependencies') && $this->route('task')) {
                $taskId = $this->route('task')->id;
                if (in_array($taskId, $this->input('dependencies', []))) {
                    $validator->errors()->add('dependencies', 'A task cannot depend on itself.');
                }
            }
        });
    }
}
