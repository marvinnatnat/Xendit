<?php
// Allow from any origin
if(isset($_SERVER["HTTP_ORIGIN"]))
{
    // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
else
{
    //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}
//From here, handle the request as it is ok

define('BASEPATH', dirname(__DIR__));
define('VIEWPATH', BASEPATH.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);

require_once BASEPATH . DIRECTORY_SEPARATOR.'../vendor/autoload.php';

use App\app\Application;
use App\controllers\ApiController;

$app = new Application();

$app->router->get('/', 'checkout/checkout');
$app->router->get('/try-checkout', 'checkout/try-checkout');
$app->router->get('/api/health', function() {
    header('Content-Type: application/json');
    return json_encode(['ok']);
});

$app->router->post('/api/invoice', [ApiController::class, 'invoice']);

$app->router->get('/api/invoice', [ApiController::class, 'getInvoiceById']);

$app->run();