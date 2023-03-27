<?php
require '../../_conf.php';
require '../../vendor/autoload.php';
use \Firebase\JWT\JWT;

$pdo=new PDO("mysql:host=$bdd_server;dbname=$bdd_name","$bdd_user","$bdd_password");

$token = $_GET["token"];
if($token == null) {
    $obj['code'] = "error";
    $obj['message'] = "tokenIsNull";
    echo json_encode($obj);
}
if (check($token, $key) == null) {
    $obj['code'] = "error";
    $obj['message'] = "tokenNotValid";
    echo json_encode($obj);
}
else {
    //echo getAllProducts();
    echo getAllProductsAsync($pdo);
}

function getAllProducts() {
    $res = '{
      "id": "1",
      "libelle": "3",
      "code": "66",
      "url3d": "string",
      "description": "string",
      "stock": 0
    }';
    return $res;
}

function check($token, $key) {
    try {
        $decoded = JWT::decode($token, $key, array('HS256'));
        $userId = $decoded->user_id;
        return $userId;
    }
    catch (Exception $e) {
        return null;
    }
}

function getAllProductsAsync($pdo) {

    $senLogin = "SELECt * FROM Products";
    $reqLogin = $pdo->prepare($senLogin);
    $reqLogin->execute();
    $resLogin = $reqLogin->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resLogin as &$row) {
        foreach ($row as &$value) {
            $value = utf8_encode($value);
        }
    }
    $obj['code'] = 'ok';
    $obj['products'] = $resLogin;
    $json = json_encode($obj);
    return $json;
}

?>