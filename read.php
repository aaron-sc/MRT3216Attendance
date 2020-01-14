<?php

/**
  * Function to query information based on
  * a parameter: in this case, name.
  *
  */

if (isset($_POST['submit'])) {
  try {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT PASSWORD
    FROM ADMIN
    WHERE ID = :name";

    $name = $_POST['name'];
    $password = $_POST['name'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
    echo $result;
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>


<h2>Login</h2>

<form method="post">
  <label for="name">ID: </label>
  <input type="text" id="name" name="name">
  <label for="pass">PASSWORD: </label>
  <input type="text" id="pass" name="pass">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>