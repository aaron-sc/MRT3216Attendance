<?php

/**
  * Function to query information based on
  * a parameter: in this case, name.
  *
  */
require "config.php";
require "common.php";


if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT IDENTITY.ID, FIRST_NAME, LAST_NAME, TIME_IN FROM IDENTITY JOIN PRACTICE ON IDENTITY.ID=PRACTICE.ID";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();

    // $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table border=1 frame=void rules=all>
      <thead>
<tr>
  <th>ID</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>TIME_IN</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["ID"]); ?></td>
<td><?php echo escape($row["FIRST_NAME"]); ?></td>
<td><?php echo escape($row["LAST_NAME"]); ?></td>
<td><?php echo escape($row["TIME_IN"]); ?></td>



      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php }
} ?>

<h2>Find Who Is Still Checked In</h2>

<form method="post">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="options.php">Back to home</a>

<?php require "templates/footer.php"; ?>