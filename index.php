<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <title>Demo App</title>
  </head>
  <body>

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "1234";
    ?>

    <div class="container">
      <h1><strong>DEMO APP FOR CA RELEASE AUTOMATION</strong></h1>
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

            //DB create
            $db_create = "CREATE DATABASE IF NOT EXISTS demoapp_db";
            if(mysqli_query($conn, $db_create)){
                echo "<span class='text-success'>Database created</span><br>";
            } else {
                echo "<span class='text-warning'>Database already exists</span>";
            }
            mysqli_select_db($conn, 'demoapp_db');

            //Table create
            $table_create = "CREATE TABLE IF NOT EXISTS demoapp (
                    id INT(6) AUTO_INCREMENT PRIMARY KEY,
                    content VARCHAR(30) NOT NULL
                    )";
            if ($conn->query($table_create) === TRUE) {
                echo "<span class='text-success'>Table <i>demoapp</i> created successfully</span><br>";
            } else {
                echo "<span class='text-warning'>Error creating table: </span>" . $conn->error;
            }

            //Table insert
            $content = mysqli_real_escape_string($conn, $_POST['content']);
            if (!empty($content)) {
              $insert_form = "INSERT INTO demoapp (content) VALUES('$content')";
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
            <label for="content">Type something to insert in the DB : </label>
            <input type="text" class="form-control" name="content" value="">
          </div>
          <input type="submit" class="btn btn-primary" name="submit" value="Envoyer">
      </form>
    </div>
    <br><br>
    <div class="container">
      <h2>DB entries</h2>
      <p>
        <table class="table">
          <?php
              $display_table = "SELECT * FROM demoapp";
              $result = $conn->query($display_table);
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<tr><td>".$row['id']."<td><td>".$row['content']."<td></tr>";
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
