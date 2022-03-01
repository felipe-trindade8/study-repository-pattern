<?php

namespace Tests\Feature\PaymentMethod;

use App\Services\Contracts\PaymentMethodServiceContract;
use App\Services\Contracts\ValidateCardServiceContract;
use App\Services\PaymentMethodService;
use App\Services\ValidateCardService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TestPaymentMethod extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var mixed
     */
    public $paymentMethodService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        app()->bind(ValidateCardServiceContract::class, ValidateCardService::class);
        $this->app->bind(PaymentMethodServiceContract::class, PaymentMethodService::class);
        $this->paymentMethodService = app()->make('App\Services\PaymentMethodService');
    }
}
