<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Requests;

use App\Models\Task;
use App\Modules\Core\ORM\Enums\TaskPriorityEnum;
use App\Modules\Core\ORM\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class TaskFilterRequest extends FormRequest
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
            'title'           => 'nullable|string|min:1|max:255',
            'description'     => 'nullable|string|max:100000',
            'priority_before' => ['required_with:priority_after', 'nullable', 'numeric', Rule::in(TaskPriorityEnum::values())],
            'priority_after'  => ['required_with:priority_before', 'nullable', 'numeric', Rule::in(TaskPriorityEnum::values()), 'lte:priority_before'],
            'status'          => ['nullable', 'string', Rule::in(TaskStatusEnum::values())],
            'sort_by.0'         => ['nullable', 'string', Rule::in(Task::SORT_AVAILABLE_BY)],
            'sort_by.1'         => 'nullable|string|in:asc,desc',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'status'   => 'error',
            'messages' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}
