<?php

namespace App\controllers;
use App\services\checkout\CheckoutService;

class ApiController {

    public function invoice() {
        // get post data from input streams instead of superglobal $_POST
        // data
        $data = json_decode(file_get_contents('php://input'), true);
        
        $headers = getallheaders();  
        $apiKey = $headers['api-key'];
        $service = new CheckoutService();
        return $service->createInvoice($data, $apiKey);
    }

    public function getInvoiceById() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = null;
        }
            

        $headers = getallheaders();  
        $apiKey = $headers['api-key'];
        $service = new CheckoutService();
        return $service->getInvoice($id, $apiKey);
    }
}