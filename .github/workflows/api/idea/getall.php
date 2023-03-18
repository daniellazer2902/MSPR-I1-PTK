<?php
require '../../_conf.php';
$pdo=new PDO("mysql:host=$bdd_server;dbname=$bdd_name","$bdd_user","$bdd_password");

$senLogin = "SELECt i.*,COUNT(u.id_idea) votes FROM idea i LEFT JOIN upvote u ON u.id_idea = i.id_idea GROUP BY i.title ORDER BY COUNT(u.id_idea) DESC";
$reqLogin = $pdo->prepare($senLogin);
$reqLogin->execute();
$resLogin = $reqLogin->fetchAll(PDO::FETCH_ASSOC);

$obj = array();
foreach ($resLogin as $res) {
    array_push($obj,$res);
}
echo json_encode($obj);
?>