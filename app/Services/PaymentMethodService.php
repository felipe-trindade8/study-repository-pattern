<?php

namespace App\Services;

use App\Models\PaymentMethod;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryContract;
use App\Services\Contracts\PaymentMethodServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaymentMethodService implements PaymentMethodServiceContract
{

    protected $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryContract $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * @param array $data
     *
     * @return PaymentMethod
     */
    public function createPaymentMethod(array $data): PaymentMethod
    {
        return $this->paymentMethodRepository->createPaymentMethod($data);
    }

    /**
     * @param int $paymentId
     * @param array $data
     *
     * @return bool
     */
    public function updatePaymentMethod(int $paymentId, array $data): bool
    {
        return $this->paymentMethodRepository->updatePaymentMethod($paymentId, $data);
    }

    /**
     * @param int $paymentId
     *
     * @return void
     */
    public function deletePaymentMethod($paymentMethodId): void
    {
        $this->paymentMethodRepository->deletePaymentMethod($paymentMethodId);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllPaymentMethods(): LengthAwarePaginator
    {
        return $this->paymentMethodRepository->getAllPaymentMethods();
    }

    /**
     * @param int $id
     *
     * @return PaymentMethod
     */
    public function getPaymentMethodsById(int $id): PaymentMethod
    {
        return $this->paymentMethodRepository->getPaymentMethodsById($id);
    }
}
