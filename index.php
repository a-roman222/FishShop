<?php
// sessions.
require ('pages/connect.php');
$stmt = $con->prepare('SELECT p.product_id, p.product_name, p.description, p.price, p.stock, p.available, c.category_name, i.imagen_name  FROM products p, categories c, images i WHERE p.category_id = c.category_id AND p.imagen_id = i.imagen_id;');
$stmt->execute();

$result = $stmt->get_result()
    ->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <title>Fish Shop</title>
</head>
<body class="main-color-bg" >

    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
            <a class="navbar-item" href="#">
                <img src="img/logo.png" alt="Logo">
            </a>
            <span class="navbar-burger burger" data-target="navbarMenu">
                <span></span>
                <span></span>
                <span></span>
            </span>
            </div>
            <div id="navbarMenu" class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item is-active">
                Home
                </a>
                <a class="navbar-item" href="pages/about.php">
                About Us
                </a>
                <a class="navbar-item" href="pages/contact.php">
                Contact
                </a>
                <a class="navbar-item" href="pages/login.php">
                Log In
                </a>
            </div>
            </div>
        </div>
    </nav>
    <div id="snow-container"></div>

    <section class="hero main-color-bg is-medium">
         <div class="has-text-centered">
            <img src="img\banner.png" alt="">
         </div>

         
      </section>
      

      <div class="container main-color-bg is-max-desktop">
         <section class="featured">
            <div class="level">
               <div class="level-left">
                  <div class="level-item">
                     <h2 class="subtitle">New Arrivals</h2>
                  </div>
               </div>
            </div>

            <?php
foreach ($result as $key => $prod):

    if ($key % 3 === 0):

?>
        <div class="columns">
<?php
    endif;
?>

        <div class="column is-4"> 
            <article>
                <figure class="image is-5by3">
                  <a href="pages/view_fish.php?id=<?=$prod['product_id'] ?>">
                    <img src="/FishShop/upload/<?=$prod['imagen_name'] ?>" />
                  </a>
                </figure>
                <h2 class="prod-subtitle"><?=$prod['product_name'] ?></h2>
                <span class="tag is-rounded"><?=$prod['category_name'] ?></span> <span class="tag is-info is-rounded">$<?=$prod['price'] ?></span>
            </article>
        </div>

<?php
    if (($key + 1) % 3 === 0 || ($key + 1) === count($result)):

?>
        </div>
<?php
    endif;
endforeach;
?>




         </section>

         <br>

         <section class="reviews">
            <div class="level">
               <div class="level-left">
                  <div class="level-item">
                     <h2 class="subtitle">Customer reviews</h2>
                  </div>
               </div>
            </div>

            <div class="columns">

                <div class="column is-6">
                    <div class="testimonial">
                        <div class="shadow"></div>
                        <span class="top border"></span>
                        <div class="title-rw">Happy to purchase</div>
                        <p>I ordered few plants and got within two days in guwahati.all plants are healthy and as like as shown in website.excellent packing.really satisfied.overall excellent.thanks..</p>
                        <p class="source">&mdash; Luis Jackson</p>
                        <span class="bottom border"></span>
                    </div>
               </div>

               <div class="column is-6">
                    <div class="testimonial">
                        <div class="shadow"></div>
                        <span class="top border"></span>
                        <div class="title-rw">Fast delivery</div>
                        <p>Happy to purchase. Took delivery at Hyderabad- kachiguda. Nil mortality rate.</p>
                        <p class="source">&mdash; Kalyan Kumar</p>
                        <span class="bottom border"></span>
                    </div>
               </div>
            </div>
         </section>
      </div>
      <br>

    <footer class="footer">
        
        <div class="content has-text-centered">

                <strong>PetShop CMS 4.0</strong> by <a href="https://jgthms.com">Andres Roman</a>. The source code is licensed
                <a href="http://opensource.org/licenses/mit-license.php">RRC</a> (Red River College)
           
        </div>
    </footer>

    <script src="js/snow.js" type="text/javascript"></script>
    
</body>
</html>
