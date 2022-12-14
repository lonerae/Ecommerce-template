<?php require "helper/headers.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ecommerce template</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body class="container-fluid">

<!--Navigation Bar-->
<?php include "standalone/navbar.php";?>
  
<?php
  if (isset($_GET["search"])) {
    $con = connect('db_template');
    
    $query = "SELECT products.product, products.price, productsimages.cover 
    FROM products INNER JOIN productsimages ON products.id = productsimages.id
    WHERE products.product LIKE ?";
    
    
    if (!empty($_GET["search"])) {
        $res = $con->prepare($query);
        $res->execute(array('%' . safe($_GET["search"]) . '%'));
        $arr = $res->fetchAll();
    }
  }
?>

<!--Results-->
<div id="results-table" class="container-fluid main">
  <div class="row">
    <?php
      if (!empty($arr)) {
        foreach ($arr as $value) {
          echo '<div class="col-md-3">' .
             '<div id="' . $value['product'] . '"></div>  
             </div>
             <script>
                $(function() {
                  $("[id=\''. $value['product'] .'\']").load("standalone/card.html", function() {
                    $("[id=\''. $value['product'] .'\']").find("img").attr("title","' . $value['product'] . '");
                    $("[id=\''. $value['product'] .'\']").find("img").attr("src","' . $value['cover'] . '");
                    $("[id=\''. $value['product'] .'\']").find("h4").text("' . $value['product'] . '");
                    $("[id=\''. $value['product'] .'\']").find("p").text("' . $value['price'] . '???");
                    $("[id=\''. $value['product'] .'\']").find("a").attr("href", "product.php?name=' . $value['product'] . '");
                  });        
                });
              </script>';
        }
      } else {
        echo '<p>No items found.</p>';
      }
    ?>
  </div>
</div>

<!--Footer-->
<?php include "standalone/footer.html";?>
  
</body>
</html>
