<?php

namespace App\Services;

use App\Services\Contracts\ValidateCardServiceContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ValidateCardService implements ValidateCardServiceContract
{

    /**
     * @property array FOURTEEN_DIGITS_BRANDS
     */
    private const FOURTEEN_DIGITS_BRANDS = ['DINERS' => 'Diners'];

    /**
     * @property array SIXTEEN_DIGITS_BRANDS
     */
    private const SIXTEEN_DIGITS_BRANDS = ['VISA' => 'VISA', 'MASTER' => 'Mastercard'];

    /**
     * @property array $errors
     */
    protected $errors;

    /**
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data): bool
    {

        $rules = [
            'card_number' => 'required',
            'holder' => 'required',
            'expiration_date' => 'required|date_format:m-y|after:' . now()->format('m-y'),
            'security_code' => 'required|digits:3',
            'brand' => [Rule::in(array_merge(self::FOURTEEN_DIGITS_BRANDS, self::SIXTEEN_DIGITS_BRANDS))]
        ];
        $validator = Validator::make($data, $rules);

        $validator->sometimes('card_number', ['digits:14'], function ($input) {
            return in_array($input->brand, self::FOURTEEN_DIGITS_BRANDS);
        });

        $validator->sometimes('card_number', ['digits:16'], function ($input) {
            return in_array($input->brand, self::SIXTEEN_DIGITS_BRANDS);
        });

        if ($validator->fails()) {
            $this->errors = $validator->errors()->toArray();
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
