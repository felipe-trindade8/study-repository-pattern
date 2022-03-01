<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepositoryEloquent implements TransactionRepositoryContract
{

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllTransactions(): LengthAwarePaginator
    {
        return $this->transaction->paginate();
    }

    /**
     * @param int $id
     *
     * @return Transaction
     */
    public function getTransactionsById(int $id): Transaction
    {
        return $this->transaction->whereId($id)->first();
    }

    /**
     * @param int $userId
     *
     * @return LengthAwarePaginator
     */
    public function getTransactionsByUserId(int $userId): LengthAwarePaginator
    {
        return $this->transaction->whereUserId($userId)->paginate();
    }

    /**
     * @param array $data
     *
     * @return Transaction
     */
    public function createTransaction(array $data): Transaction
    {
        return $this->transaction->create($data);
    }

    /**
     * @param int $transactionId
     * @param array $data
     *
     * @return bool
     */
    public function updateTransaction(int $transactionId, array $data): bool
    {
        return $this->transaction->whereId($transactionId)->update($data);
    }

    /**
     * @param int $transactionId
     *
     * @return void
     */
    public function deleteTransaction($transactionId): void
    {
        $this->transaction->destroy($transactionId);
    }
}
