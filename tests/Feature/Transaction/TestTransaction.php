<?php

namespace Tests\Feature\Transaction;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Repositories\Transaction\TransactionRepositoryContract;
use App\Repositories\Transaction\TransactionRepositoryEloquent;
use App\Services\TransactionService;
use App\Services\TransactionServiceContract;

class TestTransaction extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var mixed
     */
    public $transactionService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        app()->bind(TransactionRepositoryContract::class, TransactionRepositoryEloquent::class);
        app()->bind(TransactionServiceContract::class, TransactionService::class);
        $this->transactionService = app()->make('App\Services\TransactionServiceContract');
    }
}
