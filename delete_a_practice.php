<?php

/**
  * Delete a user
  */

require "config.php";
require "common.php";

if (isset($_GET["PRACTICE_ID"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $PRACTICE_ID = $_GET["PRACTICE_ID"];

    $sql = "DELETE FROM PRACTICE WHERE PRACTICE_ID = :PRACTICE_ID";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':PRACTICE_ID', $PRACTICE_ID);
    $statement->execute();

    $success = "Practice successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT PRACTICE_ID, IDENTITY.ID, IDENTITY.NAME, TIMESTAMPDIFF(MINUTE, TIME_IN, TIME_OUT) AS TOTAL_MINUTES, TIME_IN, TIME_OUT FROM IDENTITY JOIN PRACTICE ON PRACTICE.ID=IDENTITY.ID ORDER BY ID";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}


?>

<?php require "templates/header.php"; ?>

<h2>Delete a Practice</h2>

<?php if ($success) echo $success; ?>

<table border=1 frame=void rules=all>
  <thead>
    <tr>
  <th>ID</th>
  <th>Name</th>
  <th>Time In</th>
  <th>Time Out</th>
  <th>Total Time</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
<td><?php echo escape($row["ID"]); ?></td>
<td><?php echo escape($row["NAME"]); ?></td>
<td><?php echo escape($row["TIME_IN"]); ?></td>
<td><?php echo escape($row["TIME_OUT"]); ?></td>
<td><?php echo escape($row["TOTAL_MINUTES"]); ?></td>
      <td><a href="delete_a_practice.php?PRACTICE_ID=<?php echo escape($row["PRACTICE_ID"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="options.php">Back to home</a>

<?php require "templates/footer.php"; ?>