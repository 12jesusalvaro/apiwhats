<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Message;
use App\Models\Chat;
use App\Models\User;
use GuzzleHttp\Client;

class WhatsController extends Controller
{

    public function index()
    {
        // Obtener la lista de chats desde la base de datos
        $chats = Message::all();
        $users = User::all();
        return view('index', compact('chats', 'users'));
    }

    public function show($id)
    {
        // Obtener los mensajes del chat específico desde la base de datos
        $messages = Message::where('chat_id', $id)->get();

        return view('chats.show', compact('messages'));
    }


    public function sendMessage(Request $request)
    {
        $accessToken = 'EAAEBlhl96hkBOZBf64hZBkFXwbovmOJg5zxtZCk9iUtDOR2e4L047m5GHcv5uBFCXtTRksrHnyAEnxTEfLOT2FVf8zM8ZAooRGFtVwdcOqBR7JKMNEHZBZC8P4EPbvUt8pnXrWlifkTF8xti3CaramDBUy4z0VEEf6YK1nmYKeKheelGrG3xmKROGLZBug6OOrh0ndZBUvBZAftIPWLVEIvoZD'; // Reemplaza con tu token de WhatsApp
        $fromPhoneNumberId = '123193497545437'; // Reemplaza con tu ID de número de teléfono
        $numero = $request->input('users');
        $toPhoneNumber = "51".$numero;
        $messageType = $request->input('message_type');

        // Configuración común para la solicitud
        $baseUrl = "https://graph.facebook.com/v18.0/{$fromPhoneNumberId}/messages";
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];

        // Configurar los datos específicos del mensaje
        $messageData = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $toPhoneNumber,
        ];

        if ($messageType === 'Texto') {
            $messageData['type'] = 'text';
            $messageData['text'] = [
                'preview_url' => false,
                'body' => $request->input('texto'),
            ];
        } elseif ($messageType === 'Imagen') {
            // Subir el archivo a tu aplicación Laravel y obtener la URL
            $imageLink = 'https://static.whatsapp.net/rsrc.php/v3/yI/r/dmsjl8aYsry.png';

            $messageData['type'] = 'image';
            $messageData['image'] = [
                'link' => $imageLink,
            ];
        }elseif ($messageType === 'Pdf') {
            // Subir el archivo a tu aplicación Laravel y obtener la URL
            $documentLink = 'https://www.cm.com/cdn/web/es-mx/file/whitepapers/whatsapp-business-guide.pdf';

            $messageData['type'] = 'document';
            $messageData['document'] = [
                'link' => $documentLink,
            ];
        }elseif ($messageType === 'Template') {
            $messageData['type'] = 'template';
            $messageData['template'] = [
                'name' => 'hello_world',
                'language' => [
                    'code' => 'en_US',
                ],
            ];
        }

        // Envía la solicitud utilizando Laravel HTTP client
        $response = Http::withHeaders($headers)->post($baseUrl, $messageData);

        // Manejar la respuesta según sea necesario
        $responseData = $response->json();

        // Puedes agregar lógica adicional según la respuesta
        return redirect()->route('chats.index')->with('status', true);
        //return response()->json(['message' => 'Mensaje enviado con éxito', 'response' => $responseData]);
    }



    public function sendMessage1(Request $request){

        /*
        try {
            $token = 'EAAEBlhl96hkBO3RrfPfdYNxmDpfGKa9WZC2cjQocd71m5BLgVSAEGLv4VfxQZBGgNWXHpV2TB59wALCaJBIwEGh0ajJ3De467SVZBnMPH3yVrMfaFzZCJeGShbt7GhEUSxiTPCENXeVo49V0m1iPQZBFMHYJycJUZBzMtEupulND3L1paabKpHEQMPxB2IYahElhPmjPbWQbZCszDMGJBYZD';
            $phoneID  = '123193497545437';
            $version = 'v17.0';
            $url = 'https://graph.facebook.com/v17.0/123193497545437/messages';
            $numero = $request->input('users');
            $payload = [
                "messaging_product" => "whatsapp",
                "to" => "51".$numero,
                "type" => "template",
                "template" => [
                    "name" => "hello_world",
                    "language" => [
                        "code" => "en_US"
                    ]
                ]
            ];
            $message = Http::withToken($token)->post('https://graph.facebook.com/'.$version.'/'.$phoneID.'/messages', $payload)->throw()->json();
            return redirect()->route('chat.index')->with('status', true);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'data' => $e->getMessage(),
            ],500);
            //return redirect()->route('chat.index')->with('status', false);
        }*/

        $accessToken = 'EAAEBlhl96hkBO61uXqdMPFWR5Phn2ZAhkZC3JTFqF7j6jRixAMmjagljB0NN5Nw3sc4nNQXVbgNZARb3rYnPO884pCJVk56j9zdcpVigVpRRqJ8b2V9QiuLpwZBzM48kcr9bkDpii52Oq9uFNIiBVs9fWKkd6EjuxeZBoULHvnzMCpb2u6aVM2Rc5Lg2xXQD8T3SiPnvFrkgsi2SGCcgZD';
        $fromPhoneNumberId = '123193497545437';
        $numero = $request->input('users');
        $toPhoneNumber = "51".$numero;
        $mensaje = $request->input('body');

        $client = new Client();

        $response = $client->post("https://graph.facebook.com/v18.0/{$fromPhoneNumberId}/messages", [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $toPhoneNumber,
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => $mensaje,
                ],
            ],
        ]);

        // Manejar la respuesta como sea necesario
        $body = $response->getBody();
        $contents = $body->getContents();

        // Hacer algo con la respuesta...
        return redirect()->route('chats.index')->with('status', true);
    }

    public function getMessage(Request $request){
        // Obtén todos los datos del cuerpo del webhook
        $webhookData = $request->all();

        // Puedes acceder a datos específicos del mensaje
        $messageText = $webhookData['message']['text'];
        $phoneNumber = $webhookData['from']['phone_number'];

        // Aquí puedes manejar la lógica basada en los datos del mensaje
        // Por ejemplo, puedes guardar el mensaje en la base de datos, enviar respuestas, etc.

        // Loggear los datos del mensaje
        \Log::info('Mensaje recibido:', $webhookData);

        // Responder con un código de estado 200 para indicar que has recibido el webhook
        return response()->json(['status' => 'success'], 200);
    }

    public function verifyWebhook(Request $request){
        try{
            $verifyToken = 'HolaNovato';
            $query = $request->query();

            $mode = $query['hub_mode'];
            $token  = $query['hub_verify_token'];
            $challenge  = $query['hub_challenge'];

            if($mode && $token){
                if($mode === 'subscribe' && $token == $verifyToken){
                    return response($challenge, 200)->header('Content-Type','text/plain');
                }
            }

            throw new Exception('Invalid request');
        }
        catch (Exception $e){
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function processWebhook(Request $request){
        try {
            $bodyContent = json_decode($request->getContent(), true);

            // Determina qué pasa
            $value = $bodyContent['entry'][0]['changes'][0]['value'];

            // Inicializa $body para evitar problemas si no es un mensaje de texto
            $body = null;

            if (!empty($value['messages'])) { // Mensaje
                if ($value['messages'][0]['type'] == 'text') {
                    $body = $value['messages'][0]['text']['body'];
                }
            }

            // Accede a otros datos disponibles
            $metadata = $value['metadata'] ?? null;
            $contacts = $value['contacts'] ?? [];
            $contactsProfileName = !empty($contacts[0]['profile']['name']) ? $contacts[0]['profile']['name'] : null;

            // Puedes agregar más lógica según tus necesidades

            // Otros datos disponibles en $value, puedes mostrarlos con dd() también
            dd($value);

            return response()->json([
                'success' => true,
                'data' => [
                    'body' => $body,
                    'metadata' => $metadata,
                    'contactsProfileName' => $contactsProfileName,
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    public function recibeMessage(){
        $token = 'HolaNovato';
        //reto que recibimos de FB
        $palabraReto = $_GET['hub_challenge'];
        //token de verificacion que recibimos de FB
        $tokenverificacion = $_GET['hub_verify_token'];
        //si el token que generamos es el mismo que nos envia facebok retornamos el reto para validar que somos nosotros
        if($token === $tokenverificacion){
            echo $palabraReto;
            exit;
        }

        //recipcion de mensajes
        //leemos los datos enviados por whatsaap
        $respuesta = file_get_contents("php://input");
        //convertimos el JSON en array de php
        $respuesta = json_decode($respuesta, true);
        //extraemos el telefono del array
        $mensaje = "Telefono: ".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from']."</br>";
        //extramos el mensaje del array
        $mensaje .="Mensaje:".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        //guardamos el mensaje y la respuesta en el archivo text.txt
        file_put_contents("text.txt", $mensaje);
    }
    public function recibe(){
        //LEEMOS LOS DATOS ENVIADOS POR WHATSAPP
        $respuesta = file_get_contents("php://input");
        //echo file_put_contents("text.txt", "Hola");
        //SI NO HAY DATOS NOS SALIMOS
        if($respuesta==null){
        exit;
        }
        //CONVERTIMOS EL JSON EN ARRAY DE PHP
        $respuesta = json_decode($respuesta, true);
        //EXTRAEMOS EL TELEFONO DEL ARRAY
        $mensaje="Telefono:".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from']."\n";
        //EXTRAEMOS EL MENSAJE DEL ARRAY
        $mensaje.="Mensaje:".$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        //GUARDAMOS EL MENSAJE Y LA RESPUESTA EN EL ARCHIVO text.txt
        //dd($mensaje);
        file_put_contents("text.txt", $mensaje);
    }

}
