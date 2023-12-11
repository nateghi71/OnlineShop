<?php

namespace App\HelperClasses;

class Pay extends Payment
{
    public function requestForPayment($amounts, $addressId) {
        $api = 'test';
        $redirect = route('home.payment.verify.pay');
        $result = $this->sendRequest('https://pay.ir/pg/send' ,['api'=> $api , 'amount'=> $amounts['paying_amount'] , 'redirect'=> $redirect]);
        $result = json_decode($result);
        if($result->status) {

            $createOrder = parent::createOrder($addressId, $amounts, $result->token, 'pay');
            if (array_key_exists('error', $createOrder)) {
                return $createOrder;
            }

            $go = "https://pay.ir/pg/$result->token";
            return ['success' => $go];
        } else {
            return ['error' => $result->errorMessage];
        }
    }

    public function verifyPayment($token) {
        $api = 'test';
        $result = $this->sendRequest('https://pay.ir/pg/verify' ,['api'=> $api, 'token'=> $token]);
        $result = json_decode($result);
        if(isset($result->status)){
            if($result->status == 1)
            {
                $updateOrder = parent::updateOrder($token, $result->transId);
                if (array_key_exists('error', $updateOrder)) {
                    return $updateOrder;
                }
                session()->forget('cart');
                session()->forget('coupon');
                return ['success' => 'تراکنش با موفقیت انجام شد'];
            }
            else
            {
                return ['error' => 'تراکنش با خطا مواجه شد'];
            }
        }
        else
        {
            return ['error' => 'تراکنش با خطا مواجه شد'];
        }
    }

    public function sendRequest($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}
