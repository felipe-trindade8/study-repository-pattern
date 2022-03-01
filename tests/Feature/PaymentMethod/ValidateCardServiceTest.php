<?php

namespace Tests\Unit\CreditCard;

use App\Models\PaymentMethod;
use App\Services\Contracts\ValidateCardServiceContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ValidateCardService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ValidateCardServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var mixed
     */
    public $validateCardService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        app()->bind(ValidateCardServiceContract::class, ValidateCardService::class);
        $this->validateCardService = app()->make('App\Services\ValidateCardService');
    }

    public function test_invalid_credit_card_data()
    {
        // Arrange
        $mockInvalidCard = [];

        //Act
        $invalid_card = $this->validateCardService->validate($mockInvalidCard);
        $errors = $this->validateCardService->getErrors();

        // Assert
        $this->assertFalse($invalid_card);
        $this->assertArrayHasKey('card_number', $errors);
        $this->assertArrayHasKey('holder', $errors);
        $this->assertArrayHasKey('expiration_date', $errors);
        $this->assertArrayHasKey('security_code', $errors);
    }

    public function test_valid_sixteen_digits_credit_card()
    {
        // Arrange
        $mockValidCard = PaymentMethod::factory()->create([
            'card_number' => $this->faker()->numerify('################'),
            'expiration_date' => now()->addMonths()->format('m-y'),
            'brand' => 'VISA',
        ])->toArray();

        //Act
        $valid_card = $this->validateCardService->validate($mockValidCard);

        // Assert
        $this->assertTrue($valid_card);
    }

    public function test_valid_fourteen_digits_credit_card()
    {
        // Arrange
        $mockValidCard = PaymentMethod::factory()->create([
            'card_number' => $this->faker()->numerify('##############'),
            'expiration_date' => now()->addMonths()->format('m-y'),
            'brand' => 'Diners',
        ])->toArray();

        //Act
        $valid_card = $this->validateCardService->validate($mockValidCard);

        // Assert
        $this->assertTrue($valid_card);
    }

    public function test_invalid_sixteen_digits_credit_card()
    {
        // Arrange
        $mockInvalidCard = PaymentMethod::factory()->create([
            'card_number' => $this->faker()->numerify('##############'),
            'expiration_date' => now()->addMonths()->format('m-y'),
            'brand' => 'Mastercard',
        ])->toArray();

        //Act
        $invalid_card = $this->validateCardService->validate($mockInvalidCard);
        $errors = $this->validateCardService->getErrors();

        // Assert
        $this->assertFalse($invalid_card);
        $this->assertArrayHasKey('card_number', $errors);
    }

    public function test_invalid_fourteen_digits_credit_card()
    {
        // Arrange
        $mockValidCard = PaymentMethod::factory()->create([
            'card_number' => $this->faker()->numerify('################'),
            'expiration_date' => now()->addMonths()->format('m-y'),
            'brand' => 'Diners',
        ])->toArray();

        //Act
        $invalid_card = $this->validateCardService->validate($mockValidCard);
        $errors = $this->validateCardService->getErrors();

        // Assert
        $this->assertFalse($invalid_card);
        $this->assertArrayHasKey('card_number', $errors);
    }

    public function test_invalid_expired_credit_card()
    {
        // Arrange
        $mockValidCard = PaymentMethod::factory()->create([
            'card_number' => $this->faker()->numerify('################'),
            'expiration_date' => now()->format('m-y'),
            'brand' => 'VISA',
        ])->toArray();

        //Act
        $invalid_card = $this->validateCardService->validate($mockValidCard);
        $errors = $this->validateCardService->getErrors();

        // Assert
        $this->assertFalse($invalid_card);
        $this->assertArrayHasKey('expiration_date', $errors);
    }

    public function test_invalid_brand_credit_card()
    {
        // Arrange
        $mockValidCard = PaymentMethod::factory()->create([
            'card_number' => $this->faker()->numerify('################'),
            'expiration_date' => now()->format('m-y'),
            'brand' => 'Amex',
        ])->toArray();

        //Act
        $invalid_card = $this->validateCardService->validate($mockValidCard);
        $errors = $this->validateCardService->getErrors();

        // Assert
        $this->assertFalse($invalid_card);
        $this->assertArrayHasKey('brand', $errors);
    }

    public function test_invalid_security_code_credit_card()
    {
        // Arrange
        $mockValidCard = PaymentMethod::factory()->create([
            'card_number' => $this->faker()->numerify('################'),
            'expiration_date' => now()->format('m-y'),
            'brand' => 'VISA',
            'security_code' => '1234'
        ])->toArray();

        //Act
        $invalid_card = $this->validateCardService->validate($mockValidCard);
        $errors = $this->validateCardService->getErrors();

        // Assert
        $this->assertFalse($invalid_card);
        $this->assertArrayHasKey('security_code', $errors);
    }
}
