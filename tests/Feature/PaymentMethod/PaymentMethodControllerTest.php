<?php

namespace Tests\Feature\PaymentMethod;

use App\Models\PaymentMethod;
use Database\Seeders\PaymentMethodsSeeder;
use Illuminate\Http\Response;

class PaymentMethodControllerTest extends TestPaymentMethod
{
    public function test_request_api_v1_index_payment_method()
    {
        // Arrange
        $this->seed(PaymentMethodsSeeder::class);

        // Act
        $response = $this->get(route('api.v1.catestore.creditcard.index'));

        // Assert
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                'current_page',
                'data',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);
    }

    public function test_request_api_v1_show_payment_method()
    {
        // Arrange
        $this->seed(PaymentMethodsSeeder::class);

        $mockPayment = PaymentMethod::factory()->create();

        // Act
        $response = $this->get(route('api.v1.catestore.creditcard.show', $mockPayment->id));

        // Assert
        $response->assertStatus(200);
        $this->assertEquals($mockPayment->toArray(), $response['data']);
    }

    public function test_request_api_v1_create_valid_payment_method()
    {
        // Arrange
        $mockPayment = PaymentMethod::factory()->make([
            'card_number' => $this->faker()->numerify('################'),
            'expiration_date' => now()->addMonths()->format('m-y'),
            'brand' => 'VISA',
        ])->toArray();

        // Act
        $response = $this->postJson(route('api.v1.catestore.creditcard.store'), $mockPayment);

        // Assert
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals($mockPayment, $response['data']);
    }

    public function test_request_api_v1_update_valid_payment_method()
    {
        // Arrange
        $mockPayment = PaymentMethod::factory()->create([
            'card_number' => $this->faker()->numerify('################'),
            'expiration_date' => now()->addMonths()->format('m-y'),
            'brand' => 'VISA',
        ]);
        $dataUpdate = array_merge($mockPayment->toArray(), [
            'card_number' => $this->faker()->numerify('################')
        ]);

        // Act
        $response = $this->putJson(route('api.v1.catestore.creditcard.update', $mockPayment->id), $dataUpdate);

        // Assert
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_request_api_v1_delete_valid_payment_method()
    {
        // Arrange
        $mockPayment = PaymentMethod::factory()->create([
            'card_number' => $this->faker()->numerify('################'),
            'expiration_date' => now()->addMonths()->format('m-y'),
            'brand' => 'VISA',
        ]);

        // Act
        $response = $this->deleteJson(route('api.v1.catestore.creditcard.destroy', $mockPayment->id));

        // Assert
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
