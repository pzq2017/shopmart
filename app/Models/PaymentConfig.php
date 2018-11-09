<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentConfig extends Model
{
    protected $table = 'payment_configs';

    protected $fillable = ['name', 'code', 'desc', 'icon', 'config', 'online', 'sort'];

    protected $dates = ['created_at', 'updated_at'];

    const ALIPAY = 'alipay';
    const WXPAY = 'wxpay';
    const UPACP = 'upacp';
    const OFFPAY = 'offpay';
}
