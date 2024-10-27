
<?php
ob_start(); // Start output buffering
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
require('connect.php');

$stmt = $con->prepare('SELECT * FROM categories');
$stmt->execute();

$categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if ($_POST && !empty($_POST['form-name']) && !empty($_POST['form-price']) && !empty($_POST['form-description'])) {

   $img_name=$_FILES["image"]["name"];
   $extension = substr($img_name,strlen($img_name)-4,strlen($img_name));
   $allowed_extensions = array(".jpg","jpeg",".png",".gif");

   if(in_array($extension,$allowed_extensions)){
      $image_name=md5($img_name).$extension;
      if(move_uploaded_file($_FILES["image"]["tmp_name"],"../upload/".$image_name)){

         $query = "INSERT INTO images (imagen_name) VALUES (?)";
         $statement = $con->prepare($query);

         //  Bind values to the parameters
         $statement->bind_param('s', $image_name);

         if($statement->execute()){

            $last_id = $con->insert_id;

            //  Sanitize inputs to escape HTML entities and filter out dangerous characters.
            $fname = filter_input(INPUT_POST, 'form-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $fprice = filter_input(INPUT_POST, 'form-price', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $fdescription = filter_input(INPUT_POST, 'form-description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $fstock = filter_input(INPUT_POST, 'form-stock', FILTER_SANITIZE_NUMBER_INT);
            $favailable = filter_input(INPUT_POST, 'form-available', FILTER_SANITIZE_NUMBER_INT);
            $fcategory = filter_input(INPUT_POST, 'form-category', FILTER_SANITIZE_NUMBER_INT);

            $query2 = "INSERT INTO products (product_name, price, description, stock, available, category_id, imagen_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $statement2 = $con->prepare($query2);

            // Bind values to the parameters
            $statement2->bind_param('sssiiss', $fname, $fprice, $fdescription, $fstock, $favailable, $fcategory, $last_id);

            if ($statement2->execute()) {
               $statement2->close();
               header('Location: products.php');
            }
            $statement->close();
         }

      }
   }
}
?>

   <!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="" enctype="multipart/form-data">

            <div class="modal-body" id="add-modal">

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="form-name" class="col-form-label">Name:</label>
                     <input type="text" class="form-control" id="form-name" name="form-name" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="form-description" class="col-form-label">Description:</label>
                     <textarea  type="text" class="form-control" id="form-description" name="form-description" rows="4" required>
                     </textarea>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-4">
                     <label for="form-price" class="col-form-label">Price:</label>
                     <input type="number" class="form-control" id="form-price" name="form-price" step=".01" required>
                  </div>
                  <div class="form-group col-md-8">
                     <label for="form-stock" class="col-form-label">Stock:</label>
                     <input type="number" class="form-control" id="form-stock" name="form-stock" min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="form-category" class="col-form-label">Category:</label>

                     <select id="form-category" name="form-category" class="form-control">
                        <?php
                           foreach ($categories as $row) {
                              echo '<option value=" '.$row['category_id']. '">'. $row['category_name'] . '</option>';
                           }
                        ?>
                     </select>
                     
                  </div>
                  <div class="form-group col-md-6">
                     <label for="form-available" class="col-form-label">Available:</label>

                     <select id="form-available" name="form-available" class="form-control">
                        <option selected value="1">Yes</option>
                        <option value="0">No</option>
                     </select>

                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="image" class="form-label">Select image to upload:</label>
                     <input type="file" name="image" id="image" required>
                     <br><small class="text-warning">Allowed extensions:  jpg, jpeg, png, gif</small>
                  </div>
               </div>

            </div>

            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary" name="create">Add</button>
            </div>

         </form>

    </div>
  </div>
</div>