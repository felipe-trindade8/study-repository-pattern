<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\Services\Contracts\PaymentMethodServiceContract;
use App\Services\Contracts\ValidateCardServiceContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PaymentMethodController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentMethodServiceContract $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * @return JsonReponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->paymentService->getAllPaymentMethods()
        ]);
    }

    /**
     * @param PaymentMethodRequest $request
     *
     * @return JsonReponse
     */
    public function store(PaymentMethodRequest $request, ValidateCardServiceContract $validateCardService): JsonResponse
    {
        $paymentData = $request->validated();
        if (! $validateCardService->validate($paymentData)) {
            return response()->json(['message' => 'Invalid credit card'], Response::HTTP_BAD_REQUEST);
        }
        try {
            $paymentMethod = $this->paymentService->createPaymentMethod($paymentData);
        } catch (Exception $e) {
            report($e);
            return response()->json(['message' => 'Invalid credit card'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(
            [
                'data' => $paymentMethod
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @param int $id
     *
     * @return JsonReponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json([
            'data' => $this->paymentService->getPaymentMethodsById($id)
        ]);
    }

    /**
     * @param int $id
     * @param PaymentMethodRequest $request
     *
     * @return JsonReponse
     */
    public function update(int $id, PaymentMethodRequest $request, ValidateCardServiceContract $validateCardService): JsonResponse
    {
        $paymentData = $request->validated();
        if (! $validateCardService->validate($paymentData)) {
            return response()->json(['message' => 'Invalid credit card'], Response::HTTP_BAD_REQUEST);
        }
        try {
            $this->paymentService->updatePaymentMethod($id, $paymentData);
            $paymentMethod = $this->paymentService->getPaymentMethodsById($id);
            return response()->json(['data' => $paymentMethod]);
        } catch (Exception $e) {
            report($e);
            return response()->json(['message' => 'Invalid credit card'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['data' => $paymentMethod]);
    }

    /**
     * @param int $id
     *
     * @return JsonReponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->paymentService->deletePaymentMethod($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
