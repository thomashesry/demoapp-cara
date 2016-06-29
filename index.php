<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <title>Demo App CA RA</title>
  </head>
  <body>

    <?php
        include("credentials.php");
    ?>

    <div class="container">
      <h1><strong>THE WAREHOUSE</strong></h1>
    </div>
    <br>
    <div class="container">
      <h2>Logs</h2>
      <p>
        <?php

            //SQL connection
            $conn = new mysqli($servername, $username, $password);
            if ($conn->connect_error) {
                die("<span class='text-warning'>Connection failed: </span>" . $conn->connect_error);
            }
            echo "<span class='text-success'>Connected successfully</span><br>";

            mysqli_select_db($conn, 'demoapp_db');

            //Table insert
            $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
            $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
            if (!empty($product_name) && !empty($product_price)) {
              $insert_form = "INSERT INTO warehouse (product_name, product_price) VALUES('$product_name', '$product_price')";
              if ($conn->query($insert_form) === TRUE) {
                echo "<span class='text-success'>Row inserted successfully</span>";
              }else {
                  echo "<span class='text-warning'>Error inserting row: </span>" . $conn->error;
              }
            }
            else{echo "<span class='text-warning'>Text input must not be empty</span>";}
         ?>
      </p>
    </div>
    <br>
    <div class="container">
      <form action="" method="post">
          <div class="form-group">
            <label for="product_name">Product name : </label>
            <input type="text" class="form-control" name="product_name" value=""><br>
            <label for="product_price">Product price : </label>
            <input type="text" class="form-control" name="product_price" value="">
          </div>
          <input type="submit" class="btn btn-primary" name="submit" value="Submit">
      </form>
    </div>
    <br><br>
    <div class="container">
      <h2>Warehouse</h2>
      <p>
        <table class="table">
          <tr>
            <th>ID</th>
            <th>Product name</th>
            <th>Product price</th>
        </tr>
          <?php
              $display_table = "SELECT * FROM warehouse";
              $result = $conn->query($display_table);
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<tr><td>".$row['id']."</td><td>".$row['product_name']."</td><td>".$row['product_price']."</td></tr>";
                }
              }
              else {
                  echo "<i>No entries yet</i>";
              }
          ?>
        </table>
      </p>
    </div>
    <?php $conn->close(); ?>
  </body>
</html>
