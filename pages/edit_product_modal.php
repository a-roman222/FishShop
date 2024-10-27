<script>
function edit_product(product) {

   let cate = ['Food', 'Freshwater', 'Saltwater', 'Corals', 'Anemones'];

  document.getElementById("form-name2").value = product.product_name;
  document.getElementById("form-description2").value = product.description;
  document.getElementById("form-price2").value = product.price;
  document.getElementById("form-stock2").value = product.stock;
  document.getElementById("form-available2").value = product.available;
  document.getElementById("form-category2").selectedIndex = cate.indexOf(product.category_name);

  document.getElementById("prod_id").value = product.product_id;
  document.getElementById("prod_img_name").value = product.imagen_name;
  
  document.getElementById("form-imagen2").src = "/FishShop/upload/" + product.imagen_name;

}
</script>


<?php
ob_start(); // Start output buffering

require('connect.php');

$stmt = $con->prepare('SELECT * FROM categories');
$stmt->execute();

$categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['edit_mode']) && !empty($_POST['form-name2']) && !empty($_POST['form-price2']) && !empty($_POST['form-description2'])) {

   // update imagen
    if (!empty($_FILES["image"]["name"])) {

        $stmt = $con->prepare("SELECT p.imagen_id FROM products p WHERE p.product_id = ?");
        $stmt->bind_param("i", $_POST['prod_id']);
        $stmt->execute();
        $stmt->bind_result($imagen_id);

        if ($stmt->fetch()) {
            $stmt->close();

            $img_name = $_FILES["image"]["name"];
            $extension = substr($img_name, strlen($img_name) - 4, strlen($img_name));
            $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");

            if (in_array($extension, $allowed_extensions)) {

                $image_name = md5($img_name) . $extension;

                $filename = "../upload/" . $_POST['prod_img_name'];

                if (file_exists($filename) && move_uploaded_file($_FILES["image"]["tmp_name"], "../upload/" . $image_name)) {

                    $stmt2 = $con->prepare("UPDATE images SET imagen_name = ? WHERE imagen_id = ?");
                    $stmt2->bind_param("si", $image_name, $imagen_id);

                    if ($stmt2->execute()) {
                        unlink($filename);
                        $stmt2->close();
                    }
                }
            }
        }
    }
    // update data

    //  Sanitize inputs to escape HTML entities and filter out dangerous characters.
    $fname = filter_input(INPUT_POST, 'form-name2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fprice = filter_input(INPUT_POST, 'form-price2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fdescription = filter_input(INPUT_POST, 'form-description2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fstock = filter_input(INPUT_POST, 'form-stock2', FILTER_SANITIZE_NUMBER_INT);
    $favailable = filter_input(INPUT_POST, 'form-available2', FILTER_SANITIZE_NUMBER_INT);
    $fcategory = filter_input(INPUT_POST, 'form-category2', FILTER_SANITIZE_NUMBER_INT);

    $query2 = "UPDATE products SET product_name = ?, price = ?, description = ?, stock  = ?, available  = ?, category_id = ? WHERE product_id = ?";
    $statement2 = $con->prepare($query2);
    $statement2->bind_param('sssiiii', $fname, $fprice, $fdescription, $fstock, $favailable, $fcategory, $_POST['prod_id']);

    if ($statement2->execute()) {
      $statement2->close();
      header("Refresh:0");
   }
}
?>
<!-- Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="" enctype="multipart/form-data">

            <div class="modal-body" id="add-modal">

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="form-name2" class="col-form-label">Name:</label>
                     <input type="text" class="form-control" id="form-name2" name="form-name2" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="form-description2" class="col-form-label">Description:</label>
                     <textarea  type="text" class="form-control" id="form-description2" name="form-description2" rows="4" cols="50" required>
                     </textarea>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-4">
                     <label for="form-price2" class="col-form-label">Price:</label>
                     <input type="number" class="form-control" id="form-price2" name="form-price2" step=".01" required>
                  </div>
                  <div class="form-group col-md-8">
                     <label for="form-stock2" class="col-form-label">Stock:</label>
                     <input type="number" class="form-control" id="form-stock2" name="form-stock2" min="1" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="form-category2" class="col-form-label">Category:</label>

                     <select id="form-category2" name="form-category2" class="form-control">
                        <?php
                           foreach ($categories as $row) {
                              echo '<option value=" '.$row['category_id']. '">'. $row['category_name'] . '</option>';
                           }
                        ?>
                     </select>
                     
                  </div>
                  <div class="form-group col-md-6">
                     <label for="form-available2" class="col-form-label">Available:</label>

                     <select id="form-available2" name="form-available2" class="form-control">
                        <option selected value="1">Yes</option>
                        <option value="0">No</option>
                     </select>

                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="image" class="form-label">Imagen:</label>
                     <div class="text-center">
                        <img src="" width="200" height="200" id="form-imagen2">
                     </div>
                     
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="image" class="form-label">Select image to change:</label>
                     <input type="file" name="image" id="image">
                     <input type="hidden" id="prod_id" name="prod_id" value="">
                     <input type="hidden" id="prod_img_name" name="prod_img_name" value="">
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

