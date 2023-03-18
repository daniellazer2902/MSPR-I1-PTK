<?php
require '../../_conf.php';
$pdo=new PDO("mysql:host=$bdd_server;dbname=$bdd_name","$bdd_user","$bdd_password");

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {

    $request = json_decode($postdata);
    $title = $request->body->title;
    if(!isset($title)) {
        echo null;
    }

    $senLogin = "SELECT * FROM idea WHERE title = :title";
    $reqLogin = $pdo->prepare($senLogin);
    $reqLogin->bindParam(':title',$title);
    $reqLogin->execute();
    $resLogin = $reqLogin->fetch(PDO::FETCH_ASSOC);

    if( !$resLogin) {
        $seninsert = "INSERT INTO idea(id_user,title,description) VALUES (:id_user,:title,:description);";
        $reqinsert = $pdo->prepare($seninsert);
        $reqinsert->bindParam(':id_user',$request->body->id_user);
        $reqinsert->bindParam(':title',$title);
        $reqinsert->bindParam(':description',$request->body->description);
        $reqinsert->execute();

        if($reqinsert) {
            echo true;
        }
        else {
            echo false;
        }
    }
    else {
        echo false;
    }
}
echo null;
?>