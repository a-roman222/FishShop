<?php
require('connect.php');

if (isset($_POST['del2'])) {
  $event = intval($_POST['del2']);

  $stmt = $con->prepare("SELECT i.imagen_id, i.imagen_name FROM products p, images i WHERE p.product_id = ? AND p.imagen_id = i.imagen_id");
  $stmt->bind_param("i", $event);
  $stmt->execute();
  $stmt->bind_result($imagen_id, $imagen_name);

    if ($stmt->fetch()) {
        $stmt->close();

        $stmt2 = $con->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt2->bind_param("i", $event);

        if ($stmt2->execute()) {
            $stmt2->close();

            $stmt3 = $con->prepare("DELETE FROM images WHERE imagen_id = ?");
            $stmt3->bind_param("i", $imagen_id);

            if($stmt3->execute()){
                $stmt3->close();
                // delte file in folder

                $filename = "../upload/".$imagen_name;

                if (file_exists($filename)){
                    unlink($filename);
                } else {
                    echo "File not found.";
                }

                header('Location: products.php');
                exit(); // Ensure that no code is executed after the redirect
            }  
        } else {
            echo "Error deleting record: " . $stmt2->error;
        }
    }

  $stmt->close(); // Close the statement if there are no results
}
?>
