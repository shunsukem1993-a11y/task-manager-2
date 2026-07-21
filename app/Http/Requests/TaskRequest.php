<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        return [
            'category_id' => ['required', 'exists:categories,id',],
            'title' => ['required','string','max:255',Rule::unique('tasks', 'title')->ignore($this->task),],
            'description' => ['nullable','string',],
            'priority' => ['required','integer','in:1,2,3',],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'カテゴリーを選択してください。',
            'category_id.exists' => '選択したカテゴリーが存在しません。',
            'title.required' => 'タイトルは必須です。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'description.max' => '説明は1000文字以内で入力してください。',
            'priority.required' => '優先度を選択してください。',
            'priority.in' => '優先度は「低・中・高」から選択してください。',
        ];
    }
}
