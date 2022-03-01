<?php

namespace App\Services\Contracts;

interface ValidateCardServiceContract
{
    /**
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data): bool;

    /**
     * @return array
     */
    public function getErrors(): array;
}
