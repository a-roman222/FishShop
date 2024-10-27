<?php
// sessions.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
require('connect.php');

    if(isset($_POST['search']) && isset($_POST['product-search'])){
        $stmt = $con->prepare('SELECT p.product_id, p.product_name, p.description, p.price, p.stock, p.available, c.category_name, i.imagen_name  FROM products p, categories c, images i WHERE p.category_id = c.category_id AND p.imagen_id = i.imagen_id AND p.product_name  LIKE ? ;');
        $stmt->bind_param("s", $qparam);
        $qparam = '%' . $_POST['product-search'] . '%';
    }else{
        $stmt = $con->prepare('SELECT p.product_id, p.product_name, p.description, p.price, p.stock, p.available, c.category_name, i.imagen_name  FROM products p, categories c, images i WHERE p.category_id = c.category_id AND p.imagen_id = i.imagen_id;');
    }
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petstore Admin - Dashboard</title>

    <link href="../css/admin.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    
</head>
<body id="page-top">

    <?php
      include('add_product_modal.php');
    ?>
    <?php
      include('edit_product_modal.php');
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php
            include('menu.php')
         ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mr-2 fas fa-fw fa-user"></i>
                                <span class="d-none d-lg-inline text-gray-600 small"><?= $_SESSION['name'] ?></span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h1 class="h3 mb-2 text-gray-800">Products</h1>

                    <div class="mb-4 d-flex">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addProductModal">Add Product</button>
                        <div class="col-md-4">

                            <form action="" method="post">
                                <div class="search">
                                    <i class="fa fa-search"></i>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <input type="text" class="form-control" placeholder="Search a product" name="product-search" id="product-search">
                                    <input type="hidden" name="search" value="search">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Producst List</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            
                                <?php if (!empty($result)): ?>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Aavailable</th>
                                                <th>Category</th>
                                                <th>Imagen</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
                                                foreach ($result as $row) {
                                                $product = json_encode($row, true);
                                                $keys = array_keys($row);
                                                $count = count($keys);
                                                for($i = 1; $i < $count; $i++){
                                                    $value2 = $row[$keys[$i]];
                                                    if($i == 3){
                                                        echo '<td> $' . $value2 . '</td>';
                                                    }else if ($i == 5) {
                                                        if($value2){
                                                            echo '<td> Yes </td>';
                                                        } else {
                                                            echo '<td> No </td>';
                                                        }
                                                    } else if ($i == 7) {
                                                        echo '<td> <img src="/FishShop/upload/'. $value2 . '"width="200" height="200"></td>';
                                                    } else {
                                                        echo '<td>' . $value2 . '</td>';
                                                    }
                                                    
                                                }
                                                
                                                echo '
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <button type="button" class="btn btn-success btn-sm" alt="Edit" onclick=\'edit_product('.$product.')\' data-toggle="modal"  data-target="#editProductModal">
                                                                <i class="fas fa-pen"></i>
                                                                </button>&nbsp;
                                                                <form action="delete_product.php" method="post">
                                                                    <input type="hidden" name="del2" value=" '. $row[$keys[0]].'">
                                                                    <button type="submit" class="btn btn-danger btn-sm" type="submit" value="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                        </tr>
                                                    ';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php endif ?>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Red River College Polytechnic &copy; Web Developper 2023 / (Andres Roman)</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>