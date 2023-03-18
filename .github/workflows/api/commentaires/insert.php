<?php
require '../../_conf.php';
$pdo=new PDO("mysql:host=$bdd_server;dbname=$bdd_name","$bdd_user","$bdd_password");

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {

    $request = json_decode($postdata);
    $text = $request->body->text;
    if(!isset($text)) {
        echo null;
    }
    $date = date('Y-m-d H:i:s');

    $seninsert = "INSERT INTO commentaires(id_user,id_idea,text,createdDate) VALUES (:id_user,:id_idea,:text,:dateC)";
    $reqinsert = $pdo->prepare($seninsert);
    $reqinsert->bindParam(':id_user',$request->body->id_user);
    $reqinsert->bindParam(':id_idea',$request->body->id_idea);
    $reqinsert->bindParam(':text',$text, PDO::PARAM_STR);
    $reqinsert->bindParam(':dateC',$date);
    $reqinsert->execute();

    if($reqinsert) {
        echo true;
    }
    else {
        echo false;
    }
}
echo null;
?>