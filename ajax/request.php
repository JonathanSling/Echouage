<?php
include('../class/Database.class.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);
$requestRessource = array_shift($request);
$id = array_shift($request);

$echouageDb = new Database();

if($echouageDb != false){
    switch($requestMethod){
        case "PUT":
            parse_str(file_get_contents('php://input'), $_PUT);
            if(isset($_PUT['id'], $_PUT['espece'], $_PUT['zone'], $_PUT['nb'], $_PUT['zone'])){
                header('Content-Type: text/plain; charset=utf-8');
                header('Cache-control: no-store, no-cache, must-revalidate');
                header('Pragma: no-cache');
                header('HTTP/1.1 200 OK');
                $echouageDb->modifyById($_PUT);
                echo json_encode($_PUT);
                exit();
            }
            header('HTTP/1.1 400 Bad Request');
            exit();

        default:
            header('HTTP/1.1 405 Method Not Allowed');
            exit();
    }

}else{
    header('HTTP/1.1 503 Service Unavailable');
    exit();
}

exit();