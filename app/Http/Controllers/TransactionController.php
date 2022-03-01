<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Jobs\Products\DecreaseProductQuantityJob;
use App\Services\Contracts\CartServiceContract;
use App\Services\Contracts\ProductServiceContract;
use App\Services\Contracts\TransactionServiceContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionServiceContract $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @return JsonReponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json([
                'data' => TransactionResource::collection($this->transactionService->getAllTransactions())
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error ocurred'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param int $userId
     *
     * @return JsonReponse
     */
    public function userTransactions(int $userId): JsonResponse
    {
        try {
            return response()->json([
                'data' => TransactionResource::collection($this->transactionService->getTransactionsByUserId($userId))
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error ocurred'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param TransactionRequest $request
     *
     * @return JsonReponse
     */
    public function store(TransactionRequest $request, CartServiceContract $cartService, ProductServiceContract $productService): JsonResponse
    {
        $transactionData = $request->validated();
        try {
            $cartAmount = $cartService->getCartAmount();
            if (! $cartAmount || ! cache()->has('cart')) {
                return response()->json(['message' => 'Cart amount invalid'], Response::HTTP_BAD_REQUEST);
            }
            $transactionData['total_amount'] = $cartAmount;
            $transaction = $this->transactionService->createTransaction($transactionData);

            if (! $transaction) {
                throw new Exception('Error trying to create the transaction.');
                return false;
            }

            dispatch((new DecreaseProductQuantityJob(cache('cart'), $productService))->onQueue('decrease_products'));
            $cartService->clearCart();

            return response()->json(
                [
                    'data' => $transaction
                ],
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            return response()->json(['message' => 'An error ocurred'], Response::HTTP_BAD_REQUEST);
        }
    }
}
