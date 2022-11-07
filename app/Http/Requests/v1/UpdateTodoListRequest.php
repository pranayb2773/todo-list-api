<?php

namespace App\Http\Requests\v1;

use App\Enums\TodoListPriorities;
use App\Enums\TodoListStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateTodoListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'min:3', 'max:255', Rule::unique('todo_lists', 'subject')->ignoreModel($this->todo_list)],
            'description' => ['nullable'],
            'due_date' => ['required', 'date_format:Y-m-d'],
            'status' => ['nullable', 'int', new Enum(TodoListStatus::class)],
            'priority' => ['nullable', 'int', new Enum(TodoListPriorities::class)],
            //'user_id' => ['required', 'int', Rule::exists('users', 'id')->where('id', $this->user_id), 'in:'.$this->user->id],
            'tags' => ['nullable', 'array', Rule::exists('tags', 'id')->whereIn('id', $this->tags)]
        ];
    }
}
