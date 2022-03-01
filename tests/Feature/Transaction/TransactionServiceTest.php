<?php

namespace Tests\Feature\Transaction;

use App\Models\Transaction;

class TransactionServiceTest extends TestTransaction
{

    public function test_get_transactions()
    {
        // Arrange
        $mockTransaction = Transaction::factory()->create()->toArray();

        // Act
        $transactions = $this->transactionService->getAllTransactions()->toArray();

        // Assert
        $this->assertArrayHasKey('data', $transactions);
        $this->assertArrayHasKey('current_page', $transactions);
        $this->assertArrayHasKey('first_page_url', $transactions);
        $this->assertArrayHasKey('from', $transactions);
        $this->assertArrayHasKey('last_page', $transactions);
        $this->assertArrayHasKey('last_page_url', $transactions);
        $this->assertArrayHasKey('links', $transactions);
        $this->assertArrayHasKey('next_page_url', $transactions);
        $this->assertArrayHasKey('path', $transactions);
        $this->assertArrayHasKey('per_page', $transactions);
        $this->assertArrayHasKey('prev_page_url', $transactions);
        $this->assertArrayHasKey('to', $transactions);
        $this->assertArrayHasKey('total', $transactions);
        $this->assertEquals([$mockTransaction], $transactions['data']);
    }

    public function test_get_user_transactions()
    {
        // Arrange
        $mockTransaction = Transaction::factory()->create([
            'user_id' => 1
        ])->toArray();

        // Act
        $transactions = $this->transactionService->getTransactionsByUserId(1)->toArray();

        // Assert
        $this->assertArrayHasKey('data', $transactions);
        $this->assertArrayHasKey('current_page', $transactions);
        $this->assertArrayHasKey('first_page_url', $transactions);
        $this->assertArrayHasKey('from', $transactions);
        $this->assertArrayHasKey('last_page', $transactions);
        $this->assertArrayHasKey('last_page_url', $transactions);
        $this->assertArrayHasKey('links', $transactions);
        $this->assertArrayHasKey('next_page_url', $transactions);
        $this->assertArrayHasKey('path', $transactions);
        $this->assertArrayHasKey('per_page', $transactions);
        $this->assertArrayHasKey('prev_page_url', $transactions);
        $this->assertArrayHasKey('to', $transactions);
        $this->assertArrayHasKey('total', $transactions);
        $this->assertEquals([$mockTransaction], $transactions['data']);
    }

    public function test_create_transaction()
    {
        // Arrange
        $mockTransaction = Transaction::factory()->make()->toArray();

        // Act
        $transaction = $this->transactionService->createTransaction($mockTransaction)->toArray();

        // Assert
        $this->assertDatabaseHas('transactions', $transaction);
    }
}
