<?php

namespace Tests\Feature\Transaction;

use App\Jobs\Products\DecreaseProductQuantityJob;
use App\Models\Transaction;
use Illuminate\Http\Response;
use Database\Seeders\ProductsSeeder;
use Database\Seeders\TransactionsSeeder;
use Illuminate\Support\Facades\Bus;

class TransactionControllerTest extends TestTransaction
{

    public function test_request_api_v1_index_transaction()
    {
        // Arrange
        $this->seed(TransactionsSeeder::class);

        // Act
        $response = $this->get(route('api.v1.catestore.transaction.index'));

        // Assert
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'userd_id',
                    'name',
                    'amount',
                    'date',
                    'card_number',
                ]
            ]
        ]);
    }

    public function test_request_api_v1_user_transaction()
    {
        // Arrange
        $mockTransaction = Transaction::factory()->create([
            'user_id' => 1
        ])->toArray();

        // Act
        $response = $this->get(route('api.v1.catestore.transaction.user_transactions', 1));

        // Assert
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'userd_id',
                    'name',
                    'amount',
                    'date',
                    'card_number',
                ]
            ]
        ]);
    }

    public function test_request_api_v1_create_transaction()
    {
        // Arrange
        Bus::fake();
        $this->seed(ProductsSeeder::class);
        $this->get(route('api.v1.catestore.cart'));

        $mockPayment = Transaction::factory()->make([
            'total_amount' => collect(cache('cart'))->sum('price')
        ])->toArray();

        // Act
        $response = $this->postJson(route('api.v1.catestore.transaction.store'), $mockPayment);

        // Assert
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals($mockPayment, $response['data']);
        Bus::assertDispatched(DecreaseProductQuantityJob::class);
        $this->assertTrue(!cache()->has('cart'));
    }

    public function test_request_api_v1_create_invalid_transaction_empty_cart()
    {
        // Arrange
        $mockPayment = Transaction::factory()->make([
            'total_amount' => collect(cache('cart'))->sum('price')
        ])->toArray();

        // Act
        $response = $this->postJson(route('api.v1.catestore.transaction.store'), $mockPayment);

        // Assert
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function test_request_api_v1_create_invalid_transaction_validation_error()
    {
        // Arrange
        $mockPayment = Transaction::factory()->make()->toArray();
        unset($mockPayment['user_id']);

        // Act
        $response = $this->postJson(route('api.v1.catestore.transaction.store'), $mockPayment);

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
