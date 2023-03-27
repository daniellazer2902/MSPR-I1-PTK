<!DOCTYPE html>
<?php

$code = isset($_GET['pc']) ? $_GET['pc'] : null;
if($code == null) {
    echo "Pas de code cafetiere trouvé";
}
else {
?>
<html>
<script src="https://aframe.io/releases/1.0.4/aframe.min.js"></script>
<!-- we import arjs version without NFT but with marker + location based support -->
<script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
<body style="margin : 0px; overflow: hidden;">
<a-scene embedded arjs>
    <a-marker preset="custom" type="pattern" url="pattern.patt">
        <a-entity
                position="0 0 0"
                scale="5 5 5"
                gltf-model="http://localhost/MSPR-I1-PTK/src/models/<?php echo $code ?>/scene.gltf"
        ></a-entity>
    </a-marker>
    <a-entity camera></a-entity>
</a-scene>
</body>
</html>

<?php
}
?>