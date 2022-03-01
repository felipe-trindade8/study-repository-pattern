<?php

namespace App\Services\Contracts;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TransactionServiceContract
{
    /**
     * @param array $data
     *
     * @return Transaction
     */
    public function createTransaction(array $data): Transaction;

    /**
     * @return LengthAwarePaginator
     */
    public function getAllTransactions(): LengthAwarePaginator;

    /**
     * @param int $id
     *
     * @return Transaction
     */
    public function getTransactionsById(int $id): Transaction;

    /**
     * @param int $userId
     *
     * @return LengthAwarePaginator
     */
    public function getTransactionsByUserId(int $userId): LengthAwarePaginator;
}
