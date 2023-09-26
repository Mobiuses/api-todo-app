<?php

declare(strict_types=1);

namespace App\Modules\Api\Tasks\Requests;

use App\Modules\Core\ORM\Enums\TaskPriorityEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class TaskCreateUpdateRequest extends FormRequest
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
            'title'       => 'string|required|min:1|max:255',
            'description' => 'string|required|max:100000',
            'priority'    => ['string', Rule::in(TaskPriorityEnum::values())],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        dd($this->request->all());
        $response = new Response([
            'status' => 'error',
            'messages' => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }
}
