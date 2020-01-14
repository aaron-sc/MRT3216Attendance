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
      "NAME"  => $_POST['NAME'],
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
 echo escape($_POST["ID"]).' successfully added.';
} ?>



<h2>Add A Person</h2>

<form method="post">
  <label for="ID">ID: </label>
  <input type="text" name="ID" id="ID">
  <label for="NAME">Name: </label>
  <input type="text" name="NAME" id="NAME">
  <input type="submit" name="submit" value="Submit">
</form>

<a href="options.php">Back to home</a>

<?php require "templates/footer.php"; ?>