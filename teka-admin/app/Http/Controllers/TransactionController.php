<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class TransactionController extends Controller
{
    public function createTransaction(TransactionRequest $request): JsonResponse
    {
        // Get the authenticated user's ID
        $userId = Auth::user()->_id;

        // Validate the request data
        $validatedData = $request->validated();

        try {
            // Create a new transaction with the authenticated user's ID
            $transaction = Transaction::create(array_merge($validatedData, ['user_id' => $userId]));

            // Return a JSON response with the newly created transaction data
            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data' => $transaction
            ], 201);
        } catch (\Exception $e) {
            // Handle errors if transaction creation fails
            return response()->json([
                'success' => false,
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
