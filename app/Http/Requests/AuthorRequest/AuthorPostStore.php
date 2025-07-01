<?php

namespace App\Http\Requests\AuthorRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AuthorPostStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * You can add authorization logic here if needed.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Change to your auth logic if needed
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors(),
            ], 422) // 422 Unprocessable Entity is more standard for validation errors
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'bio'         => 'nullable|string|max:1000',
            'nationality' => 'required|string|max:100',
        ];
    }

    /**
     * Custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'        => 'Author name is required.',
            'name.string'          => 'Author name must be a string.',
            'name.max'             => 'Author name must not exceed 255 characters.',
            'bio.string'           => 'Bio must be a string.',
            'bio.max'              => 'Bio must not exceed 1000 characters.',
            'nationality.required' => 'Nationality is required.',
            'nationality.string'   => 'Nationality must be a string.',
            'nationality.max'      => 'Nationality must not exceed 100 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     * This can be used to sanitize or modify input before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name),
            'bio'  => $this->bio ? trim($this->bio) : null,
            'nationality' => trim($this->nationality),
        ]);
    }
}
