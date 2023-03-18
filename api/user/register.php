<?php
require '../../_conf.php';
$pdo=new PDO("mysql:host=$bdd_server;dbname=$bdd_name","$bdd_user","$bdd_password");

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {

    $request = json_decode($postdata);
    $email = $request->body->email;
    $password = $request->body->password;
    $adresse = $request->body->adresse;
    if(!isset($email, $password, $adresse)) {
        echo null;
    }

    $pseudo = "appr".random_int(1000, 9999);
    var_dump($pseudo);

    $senLogin = "SELECT * FROM users WHERE email = :email OR pseudo = :pseudo";
    $reqLogin = $pdo->prepare($senLogin);
    $reqLogin->bindParam(':email',$email);
    $reqLogin->bindParam(':pseudo',$pseudo);
    $reqLogin->execute();
    $resLogin = $reqLogin->fetch(PDO::FETCH_ASSOC);
    echo json_encode($resLogin);

    if(!$resLogin) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

       /* $seninsert = "INSERT INTO users(pseudo,email,password,adresse) VALUES (:pseudo,:email,:password,adresse)";
        $reqinsert = $pdo->prepare($seninsert);
        $reqinsert->bindParam(':pseudo',$pseudo);
        $reqinsert->bindParam(':email',$email);
        $reqinsert->bindParam(':password',$password_hash);
        $reqinsert->bindParam(':adresse',$adresse);
        $reqinsert->execute();

        if($reqinsert) {
            echo true;
        }
        else {
            echo false;
        }*/
    }
    else {
        echo false;
    }
}
echo null;
?>