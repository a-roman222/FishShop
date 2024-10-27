<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (isset($_SESSION['loggedin'])) {
	header('Location: products.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Fish Shop</title>
</head>
<body>

<section class="hero main-color-bg is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-white">System Administration</h3>
                    <hr class="login-hr">
                    <p class="subtitle has-text-white">Please login to proceed.</p>
                    <div class="box">
                        <figure class="avatar">
                            <a href="../index.php">
                                <img src="../img/aq.png">
                            </a>
                        </figure>
                        <form action="authenticate.php" method="post">
                            <div class="field">
                                <div class="control">
                                    <input name="username" class="input is-large" type="text" placeholder="User" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input name="password" class="input is-large" type="password" placeholder="Password">
                                </div>
                            </div>
                            <br>
                            <button type="submit" value="Login" class="button is-block is-link is-large is-fullwidth">
                                Login <i class="fa fa-sign-in" aria-hidden="true"></i>
                            </button>
                            <?php if (isset($_SESSION['logingfail']) && $_SESSION['logingfail']): ?>
                                <br>
                                <div class="notification is-danger is-light">
                                    Incorrect <strong>user</strong> and/or <strong>password</strong>, try again.
                                </div>
                            <?php endif ?>
                        </form>
                    </div>
                    <p class="has-text-grey">
                        <a href="../index.php">Back to Index</a> <br><code>User: aroman / Pass: admin123</code>

                    </p>
                </div>
            </div>
        </div>
    </section>

    
</body>
</html>