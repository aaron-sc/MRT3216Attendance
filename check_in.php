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

    $data = array(
      "ID" => $_POST["ID"],
      "TIME_IN"     => date('Y-m-d H:i:s'),
    );

    $sql = sprintf(
"INSERT INTO %s (%s) values (%s)",
"PRACTICE",
implode(", ", array_keys($data)),
":" . implode(", :", array_keys($data))
    );

    $statement = $connection->prepare($sql);
    $statement->execute($data);
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }

}

if (isset($_POST['submit']) && $statement) {
 echo escape($_POST["ID"]).' successfully checked in';
} 

if ($_GET['q'] != ""){
	echo $_GET['link'];
}

?>



<h2>Check In</h2>

<form method="post">
  <label for="ID">ID: </label>
  <input type="text" name="ID" id="ID" autofocus>
  <input type="submit" name="submit" value="Submit">
</form>

<a href="options.php">Back to home</a>

<?php require "templates/footer.php"; ?>