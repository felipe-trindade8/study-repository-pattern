<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_number',
        'user_id',
        'holder',
        'expiration_date',
        'security_code',
        'brand'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function getCardNumberMaskedAttribute()
    {
        $number_array = str_split($this->card_number, 4);
        return $number_array[0] . str_repeat('*', 8) . $number_array[1];
    }
}
