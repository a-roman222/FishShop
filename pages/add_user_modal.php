<script>
   function check() {
    var input = document.getElementById('form-pass-2');
    if (input.value != document.getElementById('form-pass').value) {
        input.setCustomValidity('Password Must be Matching.');
    } else {
        input.setCustomValidity('');
    }
}
</script>

<?php
ob_start(); // Start output buffering
require('connect.php');

if ($_POST && !empty($_POST['form-name']) && !empty($_POST['form-last-name']) && !empty($_POST['form-user']) && !empty($_POST['form-email']) && !empty($_POST['form-pass']) && !empty($_POST['form-pass-2']) && !empty($_POST['form-address']) && !empty($_POST['form-phone']) && !empty($_POST['form-city'])) {
   
   if ($_POST['form-pass'] == $_POST['form-pass-2']) {
      //  Sanitize inputs to escape HTML entities and filter out dangerous characters.
      $fname = filter_input(INPUT_POST, 'form-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $flname = filter_input(INPUT_POST, 'form-last-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $femail = filter_input(INPUT_POST, 'form-email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $faddress = filter_input(INPUT_POST, 'form-address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $fphone = filter_input(INPUT_POST, 'form-phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $fcity = filter_input(INPUT_POST, 'form-city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $fuser = filter_input(INPUT_POST, 'form-user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $fpass = filter_input(INPUT_POST, 'form-pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $password = password_hash($fpass, PASSWORD_DEFAULT);

      $query = "INSERT INTO person (first_name, last_name, email, phone, person_address, city) VALUES (?, ?, ?, ?, ?, ?)";
      $statement = $con->prepare($query);

      //  Bind values to the parameters
      $statement->bind_param('ssssss', $fname, $flname, $femail, $fphone, $faddress, $fcity);

      //  Execute the INSERT.
      //  execute() will check for possible SQL injection and remove if necessary
      if ($statement->execute()) {
         $last_id = $con->insert_id;

         $query2 = "INSERT INTO users (user, password, person_id) VALUES (?, ?, ?)";
         $statement2 = $con->prepare($query2);

         // Bind values to the parameters
         $statement2->bind_param('ssi', $fuser, $password, $last_id);

         // Execute the second INSERT.
         if ($statement2->execute()) {
            $statement2->close();
            header('Location: users.php');
         }
         // Close the statements
         $statement->close();
      }

   }
}
?>

   <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="">

            <div class="modal-body" id="add-modal">

               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="form-name" class="col-form-label">Name:</label>
                     <input type="text" class="form-control" id="form-name" name="form-name" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="form-last-name" class="col-form-label">Last Name:</label>
                     <input type="text" class="form-control" id="form-last-name" name="form-last-name" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-4">
                     <label for="form-user" class="col-form-label">User:</label>
                     <input type="text" class="form-control" id="form-user" name="form-user" required>
                  </div>
                  <div class="form-group col-md-8">
                     <label for="form-email" class="col-form-label">Email:</label>
                     <input type="email" class="form-control" id="form-email" name="form-email" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="form-pass" class="col-form-label">Password:</label>
                     <input type="password" class="form-control" id="form-pass" name="form-pass" oninput="check()" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="form-pass-2" class="col-form-label">Repeat Password:</label>
                     <input type="password" class="form-control" id="form-pass-2" name="form-pass-2" oninput="check()" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="form-address" class="col-form-label">Address:</label>
                     <input type="text" class="form-control" id="form-address" name="form-address" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="form-phone" class="col-form-label">Phone:</label>
                     <input type="text" class="form-control" id="form-phone" name="form-phone" required>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="form-city" class="col-form-label">City:</label>
                     <input type="text" class="form-control" id="form-city" name="form-city" required>
                  </div>
               </div>

            </div>

            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary" name="create">Create</button>
            </div>

         </form>

      
      
    </div>
  </div>
</div>