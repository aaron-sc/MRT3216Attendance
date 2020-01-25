<?php

/**
  * Delete a user
  */

require "config.php";
require "common.php";

if (isset($_GET["ID"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $ID = $_GET["ID"];

    $sql = "DELETE FROM IDENTITY WHERE ID = :ID";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':ID', $ID);
    $statement->execute();

    $success = "Student successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT ID, FIRST_NAME, LAST_NAME FROM IDENTITY";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}


?>

<?php require "templates/header.php"; ?>

<h2>Delete a Student</h2>

<?php if ($success) echo $success; ?>

<table border=1 frame=void rules=all>
  <thead>
    <tr>
  <th>ID</th>
  <th>First Name</th>
  <th>Last Name</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
<td><?php echo escape($row["ID"]); ?></td>
<td><?php echo escape($row["FIRST_NAME"]); ?></td>
<td><?php echo escape($row["LAST_NAME"]); ?></td>
      <td><a href="delete_a_student.php?ID=<?php echo escape($row["ID"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="options.php">Back to home</a>

<?php require "templates/footer.php"; ?>