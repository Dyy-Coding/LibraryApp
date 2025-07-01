<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest\BookPostStore;
use App\Models\BookModel;
use Illuminate\Support\Facades\Log;
use Exception;

class BookApiController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index()
    {
        try {
            $books = BookModel::orderBy("created_at","desc")->paginate(5);
            // we can create dynamic paginate as parameter
            return response()->json([
                'success' => true,
                'message' => 'Books retrieved successfully.',
                'data' => $books
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching books: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve books.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(BookPostStore $request)
    {
        try {
            $book = BookModel::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Book created successfully.',
                'data' => $book
            ], 201);
        } catch (Exception $e) {
            Log::error('Error creating book: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create book.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified book.
     */
    public function show($id)
    {
        try {
            $book = BookModel::with('author')->find($id);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Book found.',
                'data' => $book
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching book: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve book.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified book in storage.
     */
    public function update(BookPostStore $request, $id)
    {
        try {
            $book = BookModel::find($id);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found.'
                ], 404);
            }

            $book->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Book updated successfully.',
                'data' => $book
            ]);
        } catch (Exception $e) {
            Log::error('Error updating book: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update book.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy($id)
    {
        try {
            $book = BookModel::find($id);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found.'
                ], 404);
            }

            $book->delete();

            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully.'
            ]);
        } catch (Exception $e) {
            Log::error('Error deleting book: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete book.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
