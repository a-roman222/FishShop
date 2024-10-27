<?php

require('connect.php');

if ($_POST && !empty($_POST['form-cat-name'])) {
   
   if ($_POST['form-pass'] == $_POST['form-pass-2']) {
      //  Sanitize inputs to escape HTML entities and filter out dangerous characters.
      $fcat_name = filter_input(INPUT_POST, 'form-cat-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $query = "INSERT INTO categories (category_name) VALUES (?)";
      $statement7 = $con->prepare($query);

      //  Bind values to the parameters
      $statement7->bind_param('s', $fcat_name);

      //  Execute the INSERT.
      //  execute() will check for possible SQL injection and remove if necessary
      if ($statement7->execute()) {
         header('Location: categories.php');
         // Close the statements
         $statement7->close();
      }

   }
}
?>

   <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="">

            <div class="modal-body" id="add-modal">

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="form-cat-name" class="col-form-label">Category Name:</label>
                     <input type="text" class="form-control" id="form-cat-name" name="form-cat-name" required>
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