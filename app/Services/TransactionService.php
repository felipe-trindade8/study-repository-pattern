<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Services\Contracts\TransactionServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TransactionService implements TransactionServiceContract
{

    protected $transactionRepository;

    public function __construct(TransactionRepositoryContract $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param array $data
     *
     * @return Transaction
     */
    public function createTransaction(array $data): Transaction
    {
        return $this->transactionRepository->createTransaction($data);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllTransactions(): LengthAwarePaginator
    {
        return $this->transactionRepository->getAllTransactions();
    }

    /**
     * @param int $id
     *
     * @return Transaction
     */
    public function getTransactionsById(int $id): Transaction
    {
        return $this->transactionRepository->getTransactionsById($id);
    }

    /**
     * @param int $userId
     *
     * @return LengthAwarePaginator
     */
    public function getTransactionsByUserId(int $userId): LengthAwarePaginator
    {
        return $this->transactionRepository->getTransactionsByUserId($userId);
    }
}
