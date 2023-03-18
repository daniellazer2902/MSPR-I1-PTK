<?php
require '../../_conf.php';
$pdo=new PDO("mysql:host=$bdd_server;dbname=$bdd_name","$bdd_user","$bdd_password");

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {

    $request = json_decode($postdata);
    $email = $request->body->email;
    $password = $request->body->password;

    $senLogin = "SELECT * FROM users WHERE email = :email";
    $reqLogin = $pdo->prepare($senLogin);
    $reqLogin->bindParam(':email',$email);
    $reqLogin->execute();
    $resLogin = $reqLogin->fetch(PDO::FETCH_ASSOC);
    if( $resLogin) {

        if( password_verify($password, $resLogin['password']) ||$password == $resLogin['password'] ) {
            http_response_code(201);
            echo $resLogin['id_user'];
        }else {
            echo null;
        }
    }
}
echo null;
?>