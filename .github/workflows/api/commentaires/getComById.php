<?php
require '../../_conf.php';
$pdo=new PDO("mysql:host=$bdd_server;dbname=$bdd_name","$bdd_user","$bdd_password");

$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {

    $request = json_decode($postdata);
    $id_idea = $request->body->id_idea;
    if(!isset($id_idea)) {
        echo null;
    }

    $senLogin = "SELECT c.text text, c.createdDate date,u.pseudo pseudo FROM commentaires c INNER JOIN users u ON u.id_user = c.id_user WHERE id_idea = :id_idea ORDER BY createdDate ASC";
    $reqLogin = $pdo->prepare($senLogin);
    $reqLogin->bindParam(':id_idea',$id_idea);
    $reqLogin->execute();
    $resLogin = $reqLogin->fetchAll(PDO::FETCH_ASSOC);

    if($resLogin) {
        $obj = array();
        foreach ($resLogin as $res) {
            array_push($obj,$res);
        }
        echo json_encode($obj);
    }
    else {
        echo false;
    }
}
echo null;
?>