<?php

namespace App\Http\Controllers;

use App;
use App\OrdersModel;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Metodo que permite realizar una transacción
     *
     * @return array
     */
    public function createTransaction(Request $request)
    {
        date_default_timezone_set('America/Bogota');

        $url_base = env('URL_BASE');

        $login     = env('LOGIN');
        $secretKey = env('SECRETKEY');
        $seed      = date('c');

        $nonce = mt_rand();

        $nonceBase64 = base64_encode($nonce);

        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

        $data = [
            'auth' => [
                "login"   => $login,
                "seed"    => $seed,
                "nonce"   => $nonceBase64,
                "tranKey" => $tranKey
            ],
            'locale'     => 'es_CO',
            'buyer'      => [
                'name'      => $request->nombre,
                'surname'   => $request->apellidos,
                'email'     => $request->correo,
                'mobile'    => $request->celular
            ],
            'payment'    => [
                'reference'    => $request->referencia,
                'description'  => $request->descripcion,
                'amount'       => [
                    'currency'    => $request->moneda,
                    'total'       => $request->total,
                ],
                'allowPartial' => 'false'
            ],
            'expiration' => date('c', strtotime('+1 day')),
            'returnUrl'  => url('/listado'),
            'ipAddress'  => $_SERVER['REMOTE_ADDR'],
            'userAgent'  => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'CLIENT_USER_AGENT'
        ];

        try
        {
            $client = new \GuzzleHttp\Client([
                'curl' => [CURLOPT_SSL_VERIFYPEER => false],'verify' => false, 'base_uri' => $url_base
            ]);

            $json = json_encode($data);
            $json_array = json_decode($json);

            $response = $client->request('POST', '/redirection/api/session', ['json' => $json_array]);
            
            $string_response = $response->getBody()->getContents();
            $object_array = json_decode($string_response);
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }

        $order = new OrdersModel;

        $order->customer_name           = $request['nombre'];
        $order->customer_surname        = $request['apellidos'];
        $order->customer_email          = $request['correo'];
        $order->customer_mobile         = $request['celular'];
        $order->payment_requestId       = $object_array->requestId;
        $order->payment_date            = $object_array->status->date;
        $order->payment_reference       = $request['referencia'];
        $order->payment_description     = $request['descripcion'];
        $order->payment_currency        = $request['moneda'];
        $order->payment_total           = $request['total'];

        $order->save();

        return $object_array;
    }

    /**
     * Metodo que permite mostrar el detalle del pago realizado
     */
    public function verifyTransaction(int $requestId)
    {
        date_default_timezone_set('America/Bogota');

        $url_base = env('URL_BASE');

        $login     = env('LOGIN');
        $secretKey = env('SECRETKEY');
        $seed      = date('c');

        $nonce = mt_rand();

        $nonceBase64 = base64_encode($nonce);

        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

        $order = OrdersModel::where('payment_requestId', $requestId)->first();

        $data = [
            'auth' => [
                "login"   => $login,
                "seed"    => $seed,
                "nonce"   => $nonceBase64,
                "tranKey" => $tranKey
            ]
        ];

        try
        {
            $client = new \GuzzleHttp\Client([
                'curl' => [CURLOPT_SSL_VERIFYPEER => false],'verify' => false, 'base_uri' => $url_base
            ]);

            $json = json_encode($data);
            $json_array = json_decode($json);
            $response = $client->request('POST', '/redirection/api/session/' . $requestId, ['json' => $json_array]);

            $string_response = $response->getBody()->getContents();
            $object_array = json_decode($string_response);

            $order->payment_status              = $object_array->payment[0]->status->status;
            $order->payment_message             = $object_array->payment[0]->status->message;
            $order->payment_internalReference   = $object_array->payment[0]->internalReference;

            $order->save();
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }

        return view('verify', compact('object_array'));
    }

    /**
     * Metodo que permite mostrar el detalle del pago realizado
     */
    public function processTransaction(int $requestId)
    {
        date_default_timezone_set('America/Bogota');

        $url_base = env('URL_BASE');

        $login     = env('LOGIN');
        $secretKey = env('SECRETKEY');
        $seed      = date('c');

        $nonce = mt_rand();

        $nonceBase64 = base64_encode($nonce);

        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));

        $order = OrdersModel::where('payment_requestId', $requestId)->first();

        $data = [
            "auth" => [
                "login"   => $login,
                "tranKey" => $tranKey,
                "nonce"   => $nonceBase64,
                "seed"    => $seed
            ],
            "internalReference" => $order->payment_internalReference,
            "amount"            => [
                "currency"      => $order->payment_currency,
                "total"         => $order->payment_total
            ],
            "action"            => "checkout"
        ];

        try
        {
            $client = new \GuzzleHttp\Client([
                'curl' => [CURLOPT_SSL_VERIFYPEER => false],'verify' => false, 'base_uri' => $url_base
            ]);

            $json = json_encode($data);
            $json_array = json_decode($json);

            $response = $client->request('POST', '/redirection/api/transaction', ['json' => $json_array]);
            echo "<pre>";print_r( $response );echo "</pre>";die();

            $string_response = $response->getBody()->getContents();
            $object_array = json_decode($string_response);

            $order->payment_status        = $object_array->payment[0]->status->status;
            $order->payment_message       = $object_array->payment[0]->status->message;

            $order->save();
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }

        return view('verify', compact('object_array'));
    }

    /**
     * Metodo que pemrite listar todas las transacciones registradas
     */
    public function listTransactions()
    {
        $responses = OrdersModel::all();

        return view('list', compact('responses'));
    }
}
