<?php

namespace App\HelperClasses;

class IdPay extends Payment
{
    public function requestForPayment($amounts , $addressId) {
        $redirect = route('home.payment.verify.idPay');
        $result = $this->sendRequest('https://api.idpay.ir/v1.1/payment' ,['order_id'=> 101, 'amount'=> $amounts['paying_amount'], 'callback'=> $redirect]);
        $result = json_decode($result);

        if(isset($result->error_code)) {
            return ['error' => $result->error_message];
        } else {
            $createOrder = parent::createOrder($addressId, $amounts, $result->id, 'pay');
            if (array_key_exists('error', $createOrder)) {
                return $createOrder;
            }

            return ['success' => $result->link];
        }
    }

    public function verifyPayment($id , $order_id) {
        $result = $this->sendRequest('https://api.idpay.ir/v1.1/payment/verify' ,['order_id'=> $order_id, 'id'=> $id]);
        $result = json_decode($result);

        if(isset($result->error_code)) {
            return ['error' => $result->error_message];
        } else {
            $updateOrder = parent::updateOrder($id, $result->payment->track_id);
            if (array_key_exists('error', $updateOrder)) {
                return $updateOrder;
            }
            session()->forget('cart');
            session()->forget('coupon');

            return ['success' => 'success'];
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
            'X-API-KEY: 6a7f99eb-7c20-4412-a972-6dfb7cd253a4',
            'X-SANDBOX: true',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}
