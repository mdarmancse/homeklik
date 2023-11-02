<?php

namespace App\Libraries;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;
class Auth
{
    public function sendOtp($number)
        {
            return "123456";
            // $otp = mt_rand(100000, 999999);
            // $msg = "Your OTP is " . $otp . ". Don't share the code with anyone.";
            // $to = "88" . $number;
            // $data = [
            // "api_key" => SMS_API_KEY,
            // "senderid" => SMS_SENDER_ID,
            // "number" => $to,
            // "message" => $msg
            // ];
            // $url = "https://bulksmsbd.net/api/smsapi";
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // $response = curl_exec($ch);
            // curl_close($ch);
            // if (json_decode($response)) {
            // $res = json_decode($response);
            // if ($res->response_code == 202) {
            //     return $otp;
            // }
            // return false;
            // }
        }
    public function generate_token($user_id)
        {
            $date   = Carbon::now();
            $expire_at     = Carbon::now()->addDay(30)->getTimestamp();
            $request_data = [
                'iat'  => $date->getTimestamp(),         // Issued at: time when the token was generated
                'nbf'  => $date->getTimestamp(),         // Not before
                'exp'  => $expire_at,                    // Expire
                'user_id' => $user_id
            ];
            return JWT::encode(
                $request_data,
                JWT_KEY,
                'HS512'
            );
        }
    public function verify_token($token)
        {
            return JWT::decode($token, new Key(JWT_KEY, 'HS512'));
        }
}