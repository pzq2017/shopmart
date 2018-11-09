<?php

use Illuminate\Database\Seeder;

class PaymentConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_configs = [
            [
                'name' => '支付宝支付',
                'code' => 'alipay',
            ],
            [
                'name' => '微信支付',
                'code' => 'wxpay',
            ],
            [
                'name' => '银联支付',
                'code' => 'upacp',
            ],
            [
                'name' => '线下支付',
                'code' => 'offpay',
                'online' => false
            ],
        ];

        foreach ($payment_configs as $payment_config) {
            \DB::table('payment_configs')->insert($payment_config);
        }
    }
}
