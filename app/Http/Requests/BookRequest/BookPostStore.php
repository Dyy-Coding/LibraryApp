<?php

namespace App\Http\Requests\BookRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BookPostStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on authorization logic
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'author_id'         => 'required|exists:authors,id',
            'title'             => 'required|string|max:255',
            'isbn'              => 'required|string|unique:books,isbn|max:20',
            'publication_year'  => 'required|digits:4|integer|min:1000|max:' . now()->year,
            'genre'             => 'required|string|max:100',
            'available_copies'  => 'required|integer|min:0',
        ];
    }

    /**
     * Custom error messages for validation failures.
     */
    public function messages(): array
    {
        return [
            'author_id.required'        => 'Author is required.',
            'author_id.exists'          => 'Selected author does not exist.',
            'title.required'            => 'Title is required.',
            'title.string'              => 'Title must be a string.',
            'title.max'                 => 'Title must not exceed 255 characters.',
            'isbn.required'             => 'ISBN is required.',
            'isbn.string'               => 'ISBN must be a string.',
            'isbn.unique'               => 'ISBN must be unique.',
            'isbn.max'                  => 'ISBN must not exceed 20 characters.',
            'publication_year.required' => 'Publication year is required.',
            'publication_year.digits'   => 'Publication year must be 4 digits.',
            'publication_year.integer'  => 'Publication year must be an integer.',
            'publication_year.min'      => 'Publication year is too early.',
            'publication_year.max'      => 'Publication year cannot be in the future.',
            'genre.required'            => 'Genre is required.',
            'genre.string'              => 'Genre must be a string.',
            'genre.max'                 => 'Genre must not exceed 100 characters.',
            'available_copies.required' => 'Available copies are required.',
            'available_copies.integer'  => 'Available copies must be a number.',
            'available_copies.min'      => 'Available copies cannot be negative.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => trim($this->title),
            'isbn' => trim($this->isbn),
            'genre' => trim($this->genre),
        ]);
    }
}
