<?php
$token = isset($_GET['token']) ? $_GET['token'] : null;
if ($token == null) {
    echo "Acces Denied";
}
else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayTonKawa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <style>
        .product-item {
            background: lightblue;
            margin-bottom: 8px;
            padding: 4px;
        }
    </style>
</head>
<body>
    <div id="products"></div>
    <script>
        $(document).ready(function() {
            $("body").background = "red";
            var result;
            $.ajax({
                type: "GET",
                url: "http://localhost/MSPR-I1-PTK/api/Products/getall.php",
                data: {token: "<?php echo $token?>"},
                success: function (data) {
                    var res = JSON.parse(data);
                    console.log(res)
                    if(res["code"] === "error") {
                        var newDiv = $("<div>");
                        newDiv.text(res["message"]);
                        $("#products").append(newDiv);
                    }
                    if(res["code"] === "ok") {
                        $.each(res["products"], function(index, value) {
                            // Créer la nouvelle div pour chaque produit
                            var newDiv = $("<div>", {class: "product-item"});

                            // Ajouter des données du produit à la div (supposons que chaque objet a une propriété `name` et `price`)
                            $("<p>").text("Nom: " + value.Libelle).appendTo(newDiv);
                            $("<p>").text("Description: " + value.Description).appendTo(newDiv);

                            $("<a>")
                                .attr("href", "https://localhost/MSPR-I1-PTK/src/detailproduct.php?pc="+value.Code)
                                .attr("target", "_blank")
                                .text("Voir plus")
                                .appendTo(newDiv);

                            // Ajouter la nouvelle div à la div avec l'ID `products`
                            $("#products").append(newDiv);
                        });
                    }
                }
            });
        });
    </script>

</body>
</html>

<?php } ?>




