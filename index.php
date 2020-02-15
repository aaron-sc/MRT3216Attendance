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
    $password = $_POST['pass'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->execute();
    
    echo $password;
    $result = $statement->fetchAll();
    foreach ($result as $row)
      if($password == escape($row["PASSWORD"]) and !empty($password) and isset($password)){
        header("Location: options.php");
        die();
      }
      else {
        echo "Incorrect Username or Password";
      }
    
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
  <br>
  <label for="pass">PASSWORD: </label>
  <input type="password" id="pass" name="pass">
  <input type="submit" name="submit" value="Login">
</form>
<p>For Students</p>
<a href="get_total_time_non_admin.php">Get Total Time</a>
<br>
<br>
<a href="check_out_student.php">Check Out</a>
<?php require "templates/footer.php"; ?>