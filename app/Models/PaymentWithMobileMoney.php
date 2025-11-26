<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentWithMobileMoney extends Model
{
    use HasFactory;

    protected $fillable = ['payment_id', 'momo_number_id', 'momo_type_id'];

    public function payments()
    {
        return $this->belongsTo('App\Model\Payment');
    }


    public function mobile_money_accounts()
    {
        return $this->belongsTo('App\Model\MobileMoneyAccount');
    }


    public function mobile_money_account_types()
    {
        return $this->belongsTo('App\Model\MobileMoneyAccountType');
    }
}
