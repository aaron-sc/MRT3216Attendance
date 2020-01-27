<?php include "templates/header.php"; ?>

<?php
  require "config.php";
  require "common.php";
  require "utility.php";

/**
  * Use an HTML form to create a new entry in the
  * users table.
  *
  */

if (isset($_POST['submit'])) {

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    // $data = array(
    //   "ID" => $_POST["ID"],
    //   "TIME_IN"     => date('Y-m-d H:i:s'),
    // );
    $id = $_POST["ID"];
    $sql = "UPDATE `PRACTICE` SET `TIME_OUT`= CURRENT_TIMESTAMP WHERE ID = " . $id ." AND TIME_OUT IS NULL;";
    $statement = $connection->prepare($sql);
    $statement->execute();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }

}


if (isset($_POST['submit']) && $statement) {
 echo escape($_POST["ID"]).' successfully checked out';
} ?>



<h2>Check Out</h2>

<form method="post">
  <label for="ID">ID: </label>
  <input type="text" name="ID" id="ID" autofocus>
  <input type="submit" name="submit" value="Submit">
</form>

<a href="options.php">Back to home</a>

<?php require "templates/footer.php"; ?>