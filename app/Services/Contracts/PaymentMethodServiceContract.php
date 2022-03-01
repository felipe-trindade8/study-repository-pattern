<?php

namespace App\Services\Contracts;

use App\Models\PaymentMethod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PaymentMethodServiceContract
{
    /**
     * @param array $data
     *
     * @return PaymentMethod
     */
    public function createPaymentMethod(array $data): PaymentMethod;

    /**
     * @param int $paymentId
     * @param array $data
     *
     * @return bool
     */
    public function updatePaymentMethod(int $paymentId, array $data): bool;

    /**
     * @param int $paymentId
     *
     * @return void
     */
    public function deletePaymentMethod($paymentMethodId): void;

    /**
     * @return LengthAwarePaginator
     */
    public function getAllPaymentMethods(): LengthAwarePaginator;

    /**
     * @param int $id
     *
     * @return PaymentMethod
     */
    public function getPaymentMethodsById(int $id): PaymentMethod;
}
