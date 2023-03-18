<?php
require '../../_conf.php';
$pdo=new PDO("mysql:host=$bdd_server;dbname=$bdd_name","$bdd_user","$bdd_password");

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {

    $request = json_decode($postdata);
    $id_idea = $request->body->id_idea;
    $id_user = $request->body->id_user;
    /// vérifier si c'est like ////

    $senLogin = "SELECT id_idea FROM upvote WHERE id_idea = :id_idea AND id_user = :id_user";
    $reqLogin = $pdo->prepare($senLogin);
    $reqLogin->bindParam(':id_idea',$id_idea);
    $reqLogin->bindParam(':id_user',$id_user);
    $reqLogin->execute();
    $resLogin = $reqLogin->fetch(PDO::FETCH_ASSOC);

    /// like ///
    if(!$resLogin) {
        $seninsert = "INSERT INTO upvote(id_user,id_idea) VALUES (:id_user,:id_idea)";
        $reqinsert = $pdo->prepare($seninsert);
        $reqinsert->bindParam(':id_user',$id_user);
        $reqinsert->bindParam(':id_idea',$id_idea);
        $reqinsert->execute();

        echo json_encode("ok");

    }
    /// dislike ///
    else {
        $sendelete = "DELETE FROM upvote WHERE id_idea = :id_idea AND id_user = :id_user";
        $reqdelete = $pdo->prepare($sendelete);
        $reqdelete->bindParam(':id_user',$id_user);
        $reqdelete->bindParam(':id_idea',$id_idea);
        $reqdelete->execute();

        echo json_encode("ok");

    }
}
echo null;
?>