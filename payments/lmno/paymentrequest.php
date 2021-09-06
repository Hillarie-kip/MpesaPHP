<?php
            $consumer_key = "";
	        $consumer_secret = "";
            $BusinessShortCode = '';
            $LipaNaMpesaPasskey = '';
            $TransactionType = 'CustomerBuyGoodsOnline';
            $tokenUrl = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
            $lipaOnlineUrl = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $CallBackURL = '';
	
            $timestamp = date("YmdHis");
            $password = base64_encode($BusinessShortCode . $LipaNaMpesaPasskey . $timestamp);
			
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $tokenUrl);
            $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $curl_response = curl_exec($curl);

            $token = json_decode($curl_response)->access_token;
            $curl2 = curl_init();
            curl_setopt($curl2, CURLOPT_URL, $lipaOnlineUrl);
            curl_setopt($curl2, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token));


            $curl2_post_data = [
                'BusinessShortCode' => $BusinessShortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => $TransactionType,
                'Amount' => $Amount,
                'PartyA' => $Phone,
                'PartyB' => $TillNumber,
                'PhoneNumber' => $Phone,
                'CallBackURL' => $CallBackURL,
                'AccountReference' => $Phone,
                'TransactionDesc' => "Payment for Goods",
            ];

            $data2_string = json_encode($curl2_post_data);

            curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl2, CURLOPT_POST, true);
            curl_setopt($curl2, CURLOPT_POSTFIELDS, $data2_string);
            curl_setopt($curl2, CURLOPT_HEADER, false);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, 0);
            $curl2_response = json_decode(curl_exec($curl2));
            
			echo json_encode($curl2_response, JSON_PRETTY_PRINT);
             $code=$curl2_response-> ResponseCode;
            $CheckoutRequestID=$curl2_response-> CheckoutRequestID;
            
            
            
                
               

            
            