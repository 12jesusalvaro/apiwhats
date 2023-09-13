<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsController extends Controller
{
    public function sendMessage(){
        
        //sendMessages with curls
        /*$curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://graph.facebook.com/v17.0/123193497545437/messages',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "messaging_product": "whatsapp",
            "to": "51961340859",
            "type": "template",
            "template": {
                "name": "hello_world",
                "language": {
                    "code": "en_US"
                }
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer EAAEBlhl96hkBOzPIQw6QZCxqS01DmD4mHobmj12zKSZBQ8pZBdvklo3ZCuWYACkAguh1Q1Ao4iOl02GzTZAfQRuNsOwmtKK9td4XX1lvNo49bSmdKisFTIxmJhRayBNY5e2r0OZCJ6WKU6MOQrJlqcGA7IC6sAzXsZCdwTnewOsPoqD465gKLfU4tKnoCc54WzDDwwiRbxMD6PNoilYtFe3'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;*/
        try {
            $token = 'EAAEBlhl96hkBOzPIQw6QZCxqS01DmD4mHobmj12zKSZBQ8pZBdvklo3ZCuWYACkAguh1Q1Ao4iOl02GzTZAfQRuNsOwmtKK9td4XX1lvNo49bSmdKisFTIxmJhRayBNY5e2r0OZCJ6WKU6MOQrJlqcGA7IC6sAzXsZCdwTnewOsPoqD465gKLfU4tKnoCc54WzDDwwiRbxMD6PNoilYtFe3';
            $phoneID  = '123193497545437';
            $version = 'v17.0';
            $url = 'https://graph.facebook.com/v17.0/123193497545437/messages';
            $payload = [
                "messaging_product" => "whatsapp",
                "to" => "51961340859",
                "type" => "template",
                "template" => [
                    "name" => "hello_world",
                    "language" => [
                        "code" => "en_US"
                    ]
                ]
            ];
            $message = Http::withToken($token)->post('https://graph.facebook.com/'.$version.'/'.$phoneID.'/messages', $payload)->throw()->json();

            return response()->json([
                'success' => true,
                'data' => $message
            ],200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage(),
            ],500);
        }
        
    }

    public function getMessage(){

    }
}
