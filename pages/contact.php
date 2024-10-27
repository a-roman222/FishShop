
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
                <a class="navbar-item">
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
               <div class="has-text-centered">
                  <div class="level-item">
                     <h1 class="subtitle">Contact</h1>
                  </div>
               </div>
            </div>

            <div class="columns">
                <div class="column is-12">
                <div class="container">
  <div class="columns is-justify-content-center">
    <div class="column">
      <form method="POST" action="" class="box p-5">
        <label class="is-block mb-4">
          <span class="is-block mb-2">Your name</span>
          <input
            name="name"
            type="text"
            class="input"
            placeholder="Your Name"
          />
        </label>

        <label class="is-block mb-4">
          <span class="is-block mb-2">Email address</span>
          <input
            required
            name="email"
            type="email"
            class="input"
            placeholder="yourmail@example.com"
          />
        </label>

        <label class="is-block mb-4">
          <span class="is-block mb-2">Message</span>
          <textarea
            name="message"
            class="textarea"
            rows="3"
            placeholder="Tell us what you're thinking about..."
          ></textarea>
        </label>

        <div class="mb-4">
          <button type="submit" class="button is-primary green-bg px-4">Contact Us</button>
        </div>

      </form>
    </div>
  </div>
</div>
                    <br>
                </div>
            </div>

            
         </section>

         <br><br>

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
