<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Requests\Admin\PaymentConfigRequest;
use App\Models\PaymentConfig;
use App\Services\Storage\Local\StorageService;
use App\Traits\ListPageTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentConfigController extends Controller
{
    use ResponseJsonTrait;
    use ListPageTrait;

    public function index(Request $request)
    {
        return view('admin.config.payment_configs.index');
    }

    public function lists(Request $request)
    {
        $payment_configs = PaymentConfig::all();
        return $this->handleSuccess($payment_configs);
    }

    public function edit(PaymentConfig $paymentConfig)
    {
        $config = unserialize($paymentConfig->config);
        return view('admin.config.payment_configs.edit', compact('paymentConfig', 'config'));
    }

    public function update(PaymentConfigRequest $request, PaymentConfig $paymentConfig, StorageService $storageService)
    {
        $code = $paymentConfig->code;
        $target_dir = 'payment/'.$code;
        if ($code == PaymentConfig::ALIPAY) {
            $pay_config = [
                'partner'			=> $request->partner,
                'seller_email'		=> $request->seller_email,
                'key'				=> $request->key,
                'rsa_private_key'   => $paymentConfig->rsa_private_key,
                'rsa_public_key'    => $paymentConfig->rsa_public_key,
                'cacert'            => $paymentConfig->cacert,
            ];
            if ($storageService->exist('temp/'.$request->rsa_private_key)) {
                $rsa_private_key = $storageService->move('temp/'.$request->rsa_private_key, ['target_dir' => $target_dir]);
                if ($rsa_private_key) {
                    $pay_config['rsa_private_key'] = StorageService::getFileName($rsa_private_key) . '.' . StorageService::getFileExt($rsa_private_key);
                }
            }
            if ($storageService->exist('temp/'.$request->rsa_public_key)) {
                $rsa_public_key = $storageService->move('temp/'.$request->rsa_public_key, ['target_dir' => $target_dir]);
                if ($rsa_public_key) {
                    $pay_config['rsa_public_key'] = StorageService::getFileName($rsa_public_key) . '.' . StorageService::getFileExt($rsa_public_key);
                }
            }
            if ($storageService->exist('temp/'.$request->cacert)) {
                $cacert = $storageService->move('temp/'.$request->cacert, ['target_dir' => $target_dir]);
                if ($cacert) {
                    $pay_config['cacert'] = StorageService::getFileName($cacert) . '.' . StorageService::getFileExt($cacert);
                }
            }
            $paymentConfig->config = serialize($pay_config);
        } else if ($code == PaymentConfig::WXPAY) {
            $pay_config = [
                'appid'			=> $request->appid,
                'appsecret'		=> $request->appsecret,
                'mchid'			=> $request->mchid,
                'key'           => $request->key,
                'apiclient_cert'=> $paymentConfig->apiclient_cert,
                'apiclient_key' => $paymentConfig->apiclient_key,
            ];
            if ($storageService->exist('temp/'.$request->apiclient_cert)) {
                $apiclient_cert = $storageService->move('temp/'.$request->apiclient_cert, ['target_dir' => $target_dir]);
                if ($apiclient_cert) {
                    $pay_config['apiclient_cert'] = StorageService::getFileName($apiclient_cert) . '.' . StorageService::getFileExt($apiclient_cert);
                }
            }
            if ($storageService->exist('temp/'.$request->apiclient_key)) {
                $apiclient_key = $storageService->move('temp/'.$request->apiclient_key, ['target_dir' => $target_dir]);
                if ($apiclient_key) {
                    $pay_config['apiclient_key'] = StorageService::getFileName($apiclient_key) . '.' . StorageService::getFileExt($apiclient_key);
                }
            }
            $paymentConfig->config = serialize($pay_config);
        } else if ($code == PaymentConfig::UPACP) {
            $pay_config = [
                'partner'		=> $request->partner,
                'sign_cert'		=> $paymentConfig->sign_cert,
                'sign_pwd'		=> $request->sign_pwd,
                'verify_cert'   => $paymentConfig->verify_cert,
                'encrypt_cert'  => $paymentConfig->encrypt_cert,
                'environment'   => $request->environment,
            ];
            if ($storageService->exist('temp/'.$request->sign_cert)) {
                $sign_cert = $storageService->move('temp/'.$request->sign_cert, ['target_dir' => $target_dir]);
                if ($sign_cert) {
                    $pay_config['sign_cert'] = StorageService::getFileName($sign_cert) . '.' . StorageService::getFileExt($sign_cert);
                }
            }
            if ($storageService->exist('temp/'.$request->verify_cert)) {
                $verify_cert = $storageService->move('temp/'.$request->verify_cert, ['target_dir' => $target_dir]);
                if ($verify_cert) {
                    $pay_config['verify_cert'] = StorageService::getFileName($verify_cert) . '.' . StorageService::getFileExt($verify_cert);
                }
            }
            if ($storageService->exist('temp/'.$request->encrypt_cert)) {
                $encrypt_cert = $storageService->move('temp/'.$request->encrypt_cert, ['target_dir' => $target_dir]);
                if ($verify_cert) {
                    $pay_config['encrypt_cert'] = StorageService::getFileName($encrypt_cert) . '.' . StorageService::getFileExt($encrypt_cert);
                }
            }
            $paymentConfig->config = serialize($pay_config);
        }
        $icon = $request->icon;
        if ($storageService->exist('temp/'.$icon)) {
            $paymentConfig->icon = $storageService->move('temp/'.$icon, ['target_dir' => $target_dir]);
        }
        $paymentConfig->desc = $request->desc ?? '';
        $paymentConfig->sort = $request->sort ?? 0;
        $paymentConfig->save();
        return $this->handleSuccess();
    }

    public function enabled(Request $request, PaymentConfig $paymentConfig)
    {
        $paymentConfig->enabled = $request->enabled ? 1 : 0;
        $paymentConfig->save();
        return $this->handleSuccess();
    }

    public function debug(Request $request, PaymentConfig $paymentConfig)
    {
        $paymentConfig->debug = $request->debug ? 1 : 0;
        $paymentConfig->save();
        return $this->handleSuccess();
    }
}