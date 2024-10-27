<script>
   function check2() {
      var input = document.getElementById('form-user-pass-2');
      if (input.value != document.getElementById('form-user-pass').value) {
         input.setCustomValidity('Password Must be Matching.');
      } else {
         input.setCustomValidity('');
      }
   }
   function edit_user(user) {

   document.getElementById("form-user-name").value = user.first_name;
   document.getElementById("form-user-last-name").value = user.last_name;
   document.getElementById("form-user-email").value = user.email;
   document.getElementById("form-user-address").value = user.person_address;
   document.getElementById("form-user-phone").value = user.phone;
   document.getElementById("form-user-city").value = user.city;
   document.getElementById("form-user-user").value = user.user;

   document.getElementById("user_id").value = user.user_id;
   document.getElementById("person_id").value = user.person_id;
   }
</script>

<?php
ob_start(); // Start output buffering

require('connect.php');

$stmt = $con->prepare('SELECT * FROM categories');
$stmt->execute();

$categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if ($_POST && !empty($_POST['form-user-name']) && !empty($_POST['form-user-email']) && !empty($_POST['form-user-last-name']) && !empty($_POST['form-user-user'])) {

    if ($_POST['form-user-pass-2'] == $_POST['form-user-pass']) {

      $userId = $_POST['user_id'];
      $personId = $_POST['person_id'];

      $funame = filter_input(INPUT_POST, 'form-user-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $fulname = filter_input(INPUT_POST, 'form-user-last-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $fuemail = filter_input(INPUT_POST, 'form-user-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $fuaddress = filter_input(INPUT_POST, 'form-user-address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $fuphone = filter_input(INPUT_POST, 'form-user-phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $fucity = filter_input(INPUT_POST, 'form-user-city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $fuser = filter_input(INPUT_POST, 'form-user-user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $fupass = filter_input(INPUT_POST, 'form-user-pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $newpassword = password_hash($fupass, PASSWORD_DEFAULT);

      $query2 = "UPDATE person SET first_name = ?, last_name = ?, email = ?, phone  = ?, person_address  = ?, city = ? WHERE person_id = ?";
      $statement2 = $con->prepare($query2);
      $statement2->bind_param('ssssssi', $funame, $fulname, $fuemail, $fuaddress, $fuphone, $fucity ,$personId);

      if ($statement2->execute()) {
         $statement2->close();

         $query3 = "UPDATE users SET user = ?, password = ? WHERE user_id = ?";
         $statement3 = $con->prepare($query3);
         $statement3->bind_param('ssi', $fuser, $newpassword, $userId);

         if ($statement3->execute()) {
            $statement3->close();
            header("Refresh:0");
         }
      }

    }
}
?>
<!-- Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="">

            <div class="modal-body" id="add-modal">

            <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="form-user-name" class="col-form-label">Name:</label>
                     <input type="text" class="form-control" id="form-user-name" name="form-user-name" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="form-user-last-name" class="col-form-label">Last Name:</label>
                     <input type="text" class="form-control" id="form-user-last-name" name="form-user-last-name" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-4">
                     <label for="form-user-user" class="col-form-label">User:</label>
                     <input type="text" class="form-control" id="form-user-user" name="form-user-user" required>
                  </div>
                  <div class="form-group col-md-8">
                     <label for="form-user-email" class="col-form-label">Email:</label>
                     <input type="email" class="form-control" id="form-user-email" name="form-user-email" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="form-user-pass" class="col-form-label">New Password:</label>
                     <input type="password" class="form-control" id="form-user-pass" name="form-user-pass" oninput="check2()" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="form-user-pass-2" class="col-form-label">Repeat Password:</label>
                     <input type="password" class="form-control" id="form-user-pass-2" name="form-user-pass-2" oninput="check2()" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="form-user-address" class="col-form-label">Address:</label>
                     <input type="text" class="form-control" id="form-user-address" name="form-user-address" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="form-user-phone" class="col-form-label">Phone:</label>
                     <input type="text" class="form-control" id="form-user-phone" name="form-user-phone" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="form-user-city" class="col-form-label">City:</label>
                     <input type="hidden" id="user_id" name="user_id" value="">
                     <input type="hidden" id="person_id" name="person_id" value="">
                     <input type="text" class="form-control" id="form-user-city" name="form-user-city" required>
                  </div>
               </div>

            </div>

            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary" name="edit_mode" value="edit_mode">Save</button>
            </div>

         </form>

      
      
    </div>
  </div>
</div>

