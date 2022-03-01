<?php

namespace App\Repositories\PaymentMethod;

use App\Models\PaymentMethod;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaymentMethodRepositoryEloquent implements PaymentMethodRepositoryContract
{

    protected $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllPaymentMethods(): LengthAwarePaginator
    {
        return $this->paymentMethod->paginate();
    }

    /**
     * @param int $id
     *
     * @return PaymentMethod
     */
    public function getPaymentMethodsById(int $id): PaymentMethod
    {
        return $this->paymentMethod->whereId($id)->first();
    }

    /**
     * @param array $data
     *
     * @return PaymentMethod
     */
    public function createPaymentMethod(array $data): PaymentMethod
    {
        return $this->paymentMethod->create($data);
    }

    /**
     * @param int $paymentId
     * @param array $data
     *
     * @return bool
     */
    public function updatePaymentMethod(int $paymentId, array $data): bool
    {
        return $this->paymentMethod->whereId($paymentId)->update($data);
    }

    /**
     * @param int $paymentId
     *
     * @return void
     */
    public function deletePaymentMethod($paymentMethodId): void
    {
        $this->paymentMethod->destroy($paymentMethodId);
    }
}
