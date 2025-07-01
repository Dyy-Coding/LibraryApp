<?php

namespace App\Http\Controllers\Api\Author;  // Adjust namespace based on your folder structure


use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest\AuthorPostStore;
use App\Models\AuthorModel;              // Import your model
use Illuminate\Support\Facades\Log;     // For logging errors
use Illuminate\Database\QueryException;
use Exception;

class AuthorApiController extends Controller
{
    /**
     * Display a listing of authors.
     */
    public function index()
    {

    
        try {
            // $authors = AuthorModel::orderBy("created_at","desc")->paginate(5);
            // we can create dynamic paginate as parameter
            $authors = AuthorModel::with(['books' => function ($query) {
                    $query->orderBy('author_id', 'desc'); // You probably meant book ID or a relevant column
                }])
                ->orderBy('created_at', 'desc')
                ->paginate(5);

            return response()->json([
                'success' => true,
                'message' => 'Get Data authors successful.',
                'data' => $authors
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching authors: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to get authors.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created author in storage.
     */
    public function store(AuthorPostStore $request)
    {
        try {
            $author = AuthorModel::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Author created successfully.',
                'data' => $author
            ], 201);
        } catch (Exception $e) {
            Log::error('Error creating author: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create author.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified author.
     */
    public function show($id)
    {
        try {
            $author = AuthorModel::with(['books' => function($query) {
                $query->orderBy('id', 'desc'); // Change 'id' to the relevant column for your needs
            }])->find($id);

            if (!$author) {
                return response()->json([
                    'success' => false,
                    'message' => 'Author not found.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Author found.',
                'data' => $author
            ]);
        } catch (Exception $e) {
            Log::error('Error finding author: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to find author.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified author in storage.
     */
    public function update(AuthorPostStore $request, $id)
    {
        try {
            $author = AuthorModel::find($id);

            if (!$author) {
                return response()->json([
                    'success' => false,
                    'message' => 'Author not found.'
                ], 404);
            }

            $author->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Author updated successfully.',
                'data' => $author
            ]);
        } catch (Exception $e) {
            Log::error('Error updating author: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update author.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified author from storage.
     */
    public function destroy($id)
    {
        try {
            $author = AuthorModel::find($id);

            if (!$author) {
                return response()->json([
                    'success' => false,
                    'message' => 'Author not found.'
                ], 404);
            }

            try {
                $author->delete();
            } catch (QueryException $qe) {
                // Handle foreign key constraint violation (MySQL error code 23000)
                if ($qe->getCode() == '23000') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete author because related records exist. Please delete related data first.'
                    ], 409); // Conflict
                }
                throw $qe; // rethrow if not handled
            }

            return response()->json([
                'success' => true,
                'message' => 'Author deleted successfully.'
            ]);
        } catch (Exception $e) {
            Log::error('Error deleting author: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete author.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
