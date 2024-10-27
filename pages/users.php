<?php
// sessions.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

require('connect.php');

   if(isset($_POST['u-search']) && isset($_POST['user-search'])){
      $stmt = $con->prepare('SELECT u.user_id, u.person_id, p.first_name, p.last_name, u.user, p.email, p.phone, p.person_address, p.city, u.creation_date,  u.user_id FROM users u, person p WHERE u.person_id = p.person_id AND (p.first_name LIKE ? OR p.last_name LIKE ? OR u.user LIKE ?);');
      $stmt->bind_param("sss", $qparam1, $qparam2, $qparam3);
      $qparam1 = '%' . $_POST['user-search'] . '%';
      $qparam2 = '%' . $_POST['user-search'] . '%';
      $qparam3 = '%' . $_POST['user-search'] . '%';
   }else{
      $stmt = $con->prepare('SELECT u.user_id, u.person_id, p.first_name, p.last_name, u.user, p.email, p.phone, p.person_address, p.city, u.creation_date,  u.user_id FROM users u, person p WHERE u.person_id = p.person_id;');
   }

// $stmt = $con->prepare('SELECT u.user_id, u.person_id, p.first_name, p.last_name, u.user, p.email, p.phone, p.person_address, p.city, u.creation_date,  u.user_id FROM users u, person p WHERE u.person_id = p.person_id;');
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
      include('add_user_modal.php')
      ?>
      <?php
         include('edit_user_modal.php');
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
                  <h1 class="h3 mb-2 text-gray-800">Users</h1>
                  <div class="mb-4 d-flex">
                     <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">Add User</button>
                     <div class="col-md-4">

                        

                        <form action="" method="post">
                           <div class="search">
                              <i class="fa fa-search"></i>
                              <button type="submit" class="btn btn-primary">Search</button>
                              <input type="text" class="form-control" placeholder="Search a product" name="user-search" id="user-search">
                              <input type="hidden" name="u-search" value="search">
                           </div>
                        </form>

                     </div>
                  </div>
                  <div class="card shadow mb-4">
                     <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">User list</h6>
                     </div>
                     <div class="card-body">
                        <div class="table-responsive">

                        <?php if (!empty($result)): ?>
                           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                 <tr>
                                    <th>Name</th>
                                    <th>Last Name</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Creation</th>
                                    <th>Actions</th>
                                 </tr>
                              </thead>
                              <tbody>
                                <?php 
                                    foreach ($result as $row) {
                                       $user = json_encode($row, true);
                                       $keys = array_keys($row);
                                       $count = count($keys);
                                       echo '<tr>';
                                       for($i = 2; $i < $count; $i++){
                                          $value = $row[$keys[$i]];
                                          echo '<td>' . $value . '</td>';
                                       }
                                       echo '
                                                <td class="d-flex justify-content-center">
                                                   <button type="button" class="btn btn-success btn-sm" alt="Edit" onclick=\'edit_user('.$user.')\' data-toggle="modal"  data-target="#editUserModal">
                                                   <i class="fas fa-pen"></i>
                                                   </button>&nbsp;

                                                   <form action="delete_user.php" method="post">
                                                      <input type="hidden" name="user2" value=" '. $row[$keys[0]].'">
                                                      <input type="hidden" name="person2" value=" '. $row[$keys[1]].'">
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