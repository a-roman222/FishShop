<?php
// sessions.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

require('connect.php');

   if(isset($_POST['c-search']) && isset($_POST['cat-search'])){
      $stmt = $con->prepare('SELECT c.category_id, c.category_name FROM categories c WHERE c.category_name LIKE ?;');
      $stmt->bind_param("s", $qparam5);
      $qparam5 = '%' . $_POST['cat-search'] . '%';
   }else{
      $stmt = $con->prepare('SELECT c.category_id, c.category_name FROM categories c;');
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
      include('add_category_modal.php')
      ?>

      <div id="wrapper">
         <?php
         include('menu.php')
         ?>
         <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
               <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                  <i class="fa fa-bars"></i>
                  </button>
                  <ul class="navbar-nav ml-auto">
                     <div class="topbar-divider d-none d-sm-block"></div>
                     <li class="nav-item dropdown no-arrow">
                        <a class="nav-link" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mr-2 fas fa-fw fa-user"></i>
                        <span class="d-none d-lg-inline text-gray-600 small"><?= $_SESSION['name'] ?></span>
                        </a>
                     </li>
                  </ul>
               </nav>
               <div class="container-fluid">
                  <h1 class="h3 mb-2 text-gray-800">Categories</h1>
                  <div class="mb-4 d-flex">
                     <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Add Category</button>
                     <div class="col-md-4">

                        

                        <form action="" method="post">
                           <div class="search">
                              <i class="fa fa-search"></i>
                              <button type="submit" class="btn btn-primary">Search</button>
                              <input type="text" class="form-control" placeholder="Search a category" name="cat-search" id="cat-search">
                              <input type="hidden" name="c-search" value="search">
                           </div>
                        </form>

                     </div>
                  </div>
                  <div class="card shadow mb-4">
                     <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Categories list</h6>
                     </div>
                     <div class="card-body">
                        <div class="table-responsive">

                        <?php if (!empty($result)): ?>
                           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                 <tr>
                                    <th>Category Id</th>
                                    <th>Category Name</th>
                                    <th></th>
                                 </tr>
                              </thead>
                              <tbody>
                                <?php 
                                    foreach ($result as $row) {

                                       $keys = array_keys($row);
                                       $count = count($keys);
                                       echo '<tr>';
                                       for($i = 0; $i < $count; $i++){
                                          $value = $row[$keys[$i]];
                                          echo '<td>' . $value . '</td>';
                                       }
                                       echo '
                                                <td class="d-flex justify-content-center">
                                                   <button type="button" class="btn btn-success btn-sm" alt="Edit" disabled>
                                                   <i class="fas fa-pen"></i>
                                                   </button>&nbsp;

                                                   <form action="delete_category.php" method="post">
                                                      <input type="hidden" name="cat2" value=" '. $row[$keys[0]].'">
                                                      <button type="submit" class="btn btn-danger btn-sm" type="submit" value="Delete">
                                                         <i class="fas fa-trash"></i>
                                                      </button>
                                                   </form>
                                                </td>
                                             ';

                                        echo '</tr>';
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
            <footer class="sticky-footer bg-white">
               <div class="container my-auto">
                  <div class="copyright text-center my-auto">
                     <span>Red River College Polytechnic &copy; Web Developper 2023 / (Andres Roman)</span>
                  </div>
               </div>
            </footer>
         </div>
      </div>
      
   
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

   </body>
</html>