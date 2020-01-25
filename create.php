<?php include "templates/header.php"; ?>

<?php


/**
  * Use an HTML form to create a new entry in the
  * users table.
  *
  */


if (isset($_POST['submit'])) {
  require "config.php";
  require "common.php";

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $new_food = array(
      "ID" => $_POST["ID"],
      "FIRST_NAME"  => $_POST['FIRST_NAME'],
	  "LAST_NAME"  => $_POST['LAST_NAME'],
    );

    $sql = sprintf(
"INSERT INTO %s (%s) values (%s)",
"IDENTITY",
implode(", ", array_keys($new_food)),
":" . implode(", :", array_keys($new_food))
    );

    $statement = $connection->prepare($sql);
    $statement->execute($new_food);
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }

}

if (isset($_POST['submit']) && $statement) {
 echo escape($_POST["FIRST_NAME"]).' successfully added.';
} ?>



<h2>Add A Person</h2>

<form method="post">
  <label for="ID">ID: </label>
  <input type="text" name="ID" id="ID">
  <label for="FIRST_NAME">First Name: </label>
  <input type="text" name="FIRST_NAME" id="FIRST_NAME">
  <label for="LAST_NAME">Last Name: </label>
  <input type="text" name="LAST_NAME" id="LAST_NAME">
  <input type="submit" name="submit" value="Submit">
</form>

<a href="options.php">Back to home</a>

<?php require "templates/footer.php"; ?>