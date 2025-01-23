<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;

class MercadoPagoService
{
    public function __construct()
    {
        // Configura el token de acceso
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
    }

    public function createPaymentPreference($amount, $title, $quantity)
    {
        // Crear el array con los detalles del producto
        
        $items = [
            [
                "title" => $title,
                "description" => "Pago de modalidad de estudio |",
                "quantity" => (int) $quantity,  // Forzar que quantity sea un número entero
                "unit_price" => (int) $amount,
                "currency_id" => "COP"  // Cambia la moneda según sea necesario
                ]
            ];

        // Configura las URLs de retorno
        $backUrls = [
            'success' => route('payment.success'),
            'failure' => route('payment.failure'),
        ];

        // Crear el objeto de solicitud de preferencia
        $request = [
            "items" => $items,
            "back_urls" => $backUrls,
            "auto_return" => "approved",
        ];

        
        // Crear un nuevo cliente de preferencia
        $client = new PreferenceClient();
        
        try {
            // Enviar la solicitud de creación de preferencia
            $preference = $client->create($request);
            return $preference->init_point;  // URL para el Checkout Pro
        } catch (MPApiException $e) {
            // Manejar la excepción y obtener más detalles
            echo "Error al crear la preferencia: " . $e->getMessage();
            var_dump($e->getApiResponse()->getContent());
            return null;
        }
        
    }
}
