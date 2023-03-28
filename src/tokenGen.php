<?php
require '../vendor/autoload.php';
require '../_conf.php';
$pdo=new PDO("mysql:host=$bdd_server;dbname=$bdd_name","$bdd_user","$bdd_password");
use \Firebase\JWT\JWT;

// preparation info pour token
$now = new DateTime('now', new DateTimeZone('Europe/Paris'));
$expired = clone $now;
$expired->add(new DateInterval('P1D'));
$userId = "a08c4c49-c5b5-11ed-b1cb-0a0027000014";


/*// recuperation apiKey
$senApiKey = "SELECT ApiKey FROM Users WHERE Id = :idUser";
$reqApiKey = $pdo->prepare($senApiKey);
$reqApiKey-> bindParam(':idUser', $userId, PDO::PARAM_STR);
$reqApiKey->execute();
$resApiKey = $reqApiKey->fetch(PDO::FETCH_ASSOC);*/

// Données à inclure dans le token
$payload = array(
    "createdDate" => $now->format('Y-m-d\TH:i:sP'),
    "user_id" => $userId,
    "expiredDate" => $expired->format('Y-m-d\TH:i:sP'),
);

// Créer le token
$token = JWT::encode($payload, $key);
//$decoded = JWT::decode($token, $key, array('HS256'));

$link = "https://10.60.120.154/MSPR-I1-PTK/src/index.php?token=$token";
echo $token . "<br>";
echo "<a href='$link' target='_blank'>Redirection vers le lien</a>";

?>

<body>
    <script type="text/javascript" src="scripts/qrcode.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <div id="qrcode"></div>
    <script>
        new QRCode(document.getElementById("qrcode"), "<?php echo $link?>");
    </script>
</body>