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
        $userId = Auth::user()->_id;

        $validatedData = $request->validated();

        try {
            $transaction = Transaction::create(array_merge($validatedData, ['user_id' => $userId]));

            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data' => $transaction
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateTransaction(TransactionRequest $request): JsonResponse
    {
        $userId = Auth::user()->_id;
        $validatedData = $request->validated();
        try {
            $transaction = Transaction::where('user_id', $userId)->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Transaction updated successfully',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update transaction',
                'error' => $e->getMessage()
            ], 500);
        };
    }
}
