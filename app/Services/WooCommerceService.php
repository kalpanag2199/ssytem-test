<?php

namespace App\Services;

use Automattic\WooCommerce\Client;

class WooCommerceService
{
    protected $woocommerce;

    public function __construct()
    {
        $this->woocommerce = new Client(
            env('WC_STORE_URL'),
            env('WC_CONSUMER_KEY'),
            env('WC_CONSUMER_SECRET'),
            [
                'version' => 'wc/v3',
                'query_string_auth' => true, // ← IMPORTANT
            ]
        );
    }

    public function getProducts()
    {
       // dd($this->woocommerce->http->getRequest()->getUrl());

        return $this->woocommerce->get('products');
    }

    public function getProduct($id)
    {
        return $this->woocommerce->get("products/{$id}");
    }

    public function createOrder($data)
    {
        return $this->woocommerce->post('orders', $data);
    }

    public function updateProductStock($id, $newStock)
    {
        return $this->woocommerce->put("products/{$id}", [
            'stock_quantity' => $newStock,
        ]);
    }


    public function updateProduct($id, $data = [])
    {

        return $this->woocommerce->put("products/{$id}", $data);
    }



    public function createProducts($data){
         
        return $this->woocommerce->post('products', $data);

    }

    public function deleteProduct($id)
        {
        
            return $this->woocommerce->delete("products/{$id}", ['force' => true]);
        }



    /**
     * @author : Kalpana Gupta 
     * @return : json 
     * @description : Not using this currently
     * */ 
    public function curlRequestConsume($url="",$method="",$jsonPostFields=""){
        
        $curl = curl_init();

            $options = [
                CURLOPT_URL => env('WC_STORE_URL') . $url . '?consumer_key=' . env('WC_CONSUMER_KEY') . '&consumer_secret=' . env('WC_CONSUMER_SECRET'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
            ];

            // If POST/PUT/PATCH data exists, add headers and body
            if (!empty($jsonPostFields)) {
                $options[CURLOPT_POSTFIELDS] = $jsonPostFields;
                $options[CURLOPT_HTTPHEADER] = [
                    'Content-Type: application/json'
                ];
            }

            curl_setopt_array($curl, $options);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;


    }
}
