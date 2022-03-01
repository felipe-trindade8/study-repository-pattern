<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Services\Contracts\CartServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(Request $request, CartServiceContract $cartService): JsonResponse
    {
        $cartData = CartResource::collection($cartService->getCart())->toArray($request);
        return response()->json($cartData, 200);
    }
}
