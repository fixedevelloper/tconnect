<?php


namespace App\Services;


use App\Models\Country;
use App\Models\Reservation;

class FlutterWaveService
{
    public function makePayment(Reservation $reservation){
        $url='https://api.flutterwave.com/v3/payments';
        $body=[
            'tx_ref'=>'UNIQUE_TRANSACTION_REFERENCE',
			'amount'=> $reservation->trajet_id,
			'currency'=> 'NGN',
			'redirect_url'=> 'https://example_company.com/success',
            'customer'=>[
                'email'=> 'developers@flutterwavego.com',
				'name'=>  'Flutterwave Developers',
				'phonenumber'=>  '09012345678',
            ],
			'customizations'=>[
                'title'=> 'Flutterwave Standard Payment',
            ]
        ];
        return $this->cURL($url,$body);

    }
    protected function cURL($url, $json)
    {

        // Create curl resource
        $ch = curl_init($url);

        // Request headers
        $headers = array(
            'Content-Type:application/json',
            "PAYDUNYA-MASTER-KEY: ".env("PAYDUNYA_PRINCIPAL"),
            "PAYDUNYA-PRIVATE-KEY: ".env("PAYDUNYA_SECRET_KEY"),
            "PAYDUNYA-TOKEN: ".env("PAYDUNYA_TOKEN")
        );
        // Return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $output contains the output string
        $output = curl_exec($ch);

        // Close curl resource to free up system resources
        curl_close($ch);
        return json_decode($output);
    }
}
