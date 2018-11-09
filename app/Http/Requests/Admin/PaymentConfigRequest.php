<?php

namespace App\Http\Requests\Admin;

use App\Models\PaymentConfig;
use Illuminate\Foundation\Http\FormRequest;

class PaymentConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'icon' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'icon.required' => '请上传支付图标',
            'partner.required' => '商户号不能为空',
            'seller_email.required' => '收款支付宝账号不能为空',
            'key.required' => '支付密钥不能为空',
            'rsa_private_key.required' => '请上传商户私钥文件',
            'rsa_public_key.required' => '请上传支付宝公钥文件',
            'cacert.required' => '请上传支付宝CA证书',
            'appid.required' => '微信公众号AppId不能为空',
            'appsecret.required' => '微信公众号AppSecret不能为空',
            'mchid.required' => '支付商户号不能为空',
            'environment.required' => '请选择支付环境',
            'sign_cert.required' => '请上传签名证书文件',
            'sign_pwd.required' => '签名证书密码不能为空',
            'verify_cert.required' => '请上传验签证书文件',
            'encrypt_cert.required' => '请上传密码加密证书文件',
        ];
    }

    public function withValidator($validator)
    {
        $code = PaymentConfig::where('id', $this->request->get('id'))->value('code');
        $validator->sometimes(['partner', 'seller_email', 'key', 'rsa_private_key', 'rsa_public_key', 'cacert'], 'required', function ($input) use ($code) {
            return $code == PaymentConfig::ALIPAY;
        });
        $validator->sometimes(['appid', 'appsecret', 'mchid', 'key'], 'required', function ($input) use ($code) {
            return $code == PaymentConfig::WXPAY;
        });
        $validator->sometimes(['environment', 'partner', 'sign_cert', 'sign_pwd', 'verify_cert', 'encrypt_cert'], 'required', function ($input) use ($code) {
            return $code == PaymentConfig::UPACP;
        });
    }
}
