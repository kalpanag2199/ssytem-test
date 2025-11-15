<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WooCommerceService;

class WooCommerceController extends Controller
{
    protected $wc;

    public function __construct(WooCommerceService $wc)
    {
        $this->wc = $wc;
    }

    /**
     * Fetch all products
     */
    public function getProducts()
    {
   
        try {
            $products = $this->wc->getProducts();
            return response()->json([
                'status' => true,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Fetch a single product by ID
     */
    public function getProduct($id)
    {
        try {
            $product = $this->wc->getProduct($id);

            return response()->json([
                'status' => true,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }

    }
    
public function createProduct(Request $request)
{
    $post = $request->all();

    // Prepare product data
        $data = [
            "name"        => ($post['name'])?? '',
            "type"        => "simple",
            "regular_price" => (isset($post['price'] ) && !empty($post['price'] )) ? strval($post['price']) :'',
            "description" => ($post['description']) ??'',
            "sku"         => ($post['sku']) ??'' ,
        ];

       try {

            $product = $this->wc->createProducts($data);

            return response()->json([
                'status' => true,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
}

/**
 * update products
 * */ 
    public function updateProducts($id,Request $request){
        
        $post = $request->all();
  
           try {

            $product = $this->wc->updateProduct($id,$post);

            return response()->json([
                'status' => true,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    /**
     * Create a WooCommerce Order
     */
    public function createOrder(Request $request)
    {
        try {
            $orderData = [
                "payment_method" => $request->payment_method ?? "cod",
                "payment_method_title" => $request->payment_method_title ?? "Cash on Delivery",
                "set_paid" => false,

                "billing" => [
                    "first_name" => $request->first_name,
                    "last_name" => $request->last_name,
                    "email" => $request->email,
                    "phone" => $request->phone,
                    "address_1" => $request->address,
                ],

                "line_items" => $request->line_items ?? [],
            ];

            $order = $this->wc->createOrder($orderData);

            return response()->json([
                'status' => true,
                'message' => 'Order created successfully',
                'data' => $order
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Update product stock
     */
    public function updateStock(Request $request, $id)
    {
        try {
            $updated = $this->wc->updateProductStock($id, $request->stock);

            return response()->json([
                'status' => true,
                'message' => 'Stock updated',
                'data' => $updated
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function deleteProduct($id)
        {
            try {
                // WooCommerce service call
                $deleted = $this->wc->deleteProduct($id);

                return response()->json([
                    'status' => true,
                    'message' => 'Product deleted successfully',
                    'data' => $deleted
                ]);
            } catch (\Exception $e) {
                return $this->errorResponse($e);
            }
        }


    /**
     * Handle errors
     */
    private function errorResponse($e)
    {
        return response()->json([
            'status' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}
