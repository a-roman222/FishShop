<?php
// sessions.
    require ('connect.php');
    if($_GET['id']){
        $id = $_GET['id'];

        $stmt = $con->prepare("SELECT p.product_name, p.description, p.price, p.stock, p.available, c.category_name, i.imagen_name  FROM products p, categories c, images i WHERE p.category_id = c.category_id AND p.imagen_id = i.imagen_id AND p.product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $prod = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
        $stmt->close();
    } else {
        header('Location: products.php');
    }

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <title>Fish Shop</title>
</head>
<body class="main-color-bg">

    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
            <a class="navbar-item" href="#">
                <img src="../img/logo.png" alt="Logo">
            </a>
            <span class="navbar-burger burger" data-target="navbarMenu">
                <span></span>
                <span></span>
                <span></span>
            </span>
            </div>
            <div id="navbarMenu" class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item is-active" href="../index.php">
                Home
                </a>
                <a class="navbar-item" href="about.php">
                About Us
                </a>
                <a class="navbar-item" href="contact.php">
                Contact
                </a>
                <a class="navbar-item" href="login.php">
                Log In
                </a>
            </div>
            </div>
        </div>
    </nav>

    <div id="snow-container"></div>

    <section class="hero main-color-bg is-medium">
         <div class="has-text-centered">
            <a href="../index.php">
                <img src="../img/banner.png" alt="">
            </a>
         </div>    
      </section>
      

      <div class="container main-color-bg is-max-desktop">
         <section class="featured">
            <div class="level">
               <div class="level-left">
                  <div class="level-item">
                     <h1 class="subtitle"><?=$prod['product_name'] ?></h1>
                  </div>
               </div>
            </div>

            <div class="columns">

                <div class="column is-6">
                    <div class="white-color">
                        <?=$prod['description'] ?>
                    </div>
                    <br>
                    <div class="is-flex">
                        <div> 
                            <strong class="lblue-color">
                                Price: &nbsp;
                            </strong>
                            <span class="tag">
                                $<?=$prod['price'] ?>
                            </span>
                        </div>
                        &nbsp;&nbsp;&nbsp;
                        <div> 
                            <strong class="lblue-color">
                                Stock: 
                            </strong>
                            <span class="white-color">
                                <?=$prod['stock'] ?> (units)
                            </span>

                            &nbsp;&nbsp;&nbsp;

                            <?= $prod['available']==1 ? '<span class="tag is-success"> Available </span>' : '<span class="tag is-warning"> Not Available </span>'?>

                        </div>
                    </div>

                </div>

                <div class="column is-6">
                    <img style="border-radius: 5px;" src="/FishShop/upload/<?=$prod['imagen_name'] ?>" width="100%" />
                </div>

            </div>


            
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
    <script src="../js/snow.js" type="text/javascript"></script>
    
</body>
</html>
