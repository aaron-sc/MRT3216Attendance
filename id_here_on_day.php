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

    $sql = 'SELECT IDENTITY.ID, FIRST_NAME, LAST_NAME, TIMESTAMPDIFF(MINUTE, TIME_IN, TIME_OUT) AS TOTAL_MINUTES, CAST(PRACTICE.TIME_IN AS DATE) AS DAY_IN FROM IDENTITY JOIN PRACTICE ON PRACTICE.ID=IDENTITY.ID HAVING DAY_IN = :id_day
';
    $id_day = $_POST['id_day'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':id_day', $id_day, PDO::PARAM_STR);
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
  <th>Total Minutes</th>
  <th>Total Hours</th>
  <th>Date</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["ID"]); ?></td>
<td><?php echo escape($row["FIRST_NAME"]); ?></td>
<td><?php echo escape($row["LAST_NAME"]); ?></td>
<td><?php echo escape($row["TOTAL_MINUTES"]); ?></td>
<td><?php echo escape($row["TOTAL_MINUTES"]/60); ?></td>
<td><?php echo escape($row["DAY_IN"]); ?></td>


      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php }
} ?>

<h2>Get all times</h2>

<form method="post">
  <!--<label for="id">ID: </label>-->
  <!--<input type="text" name="id" id="id">-->
  <p>Find Everyone Here On: </p> <input type="date" name="id_day" id="id_day">
  <br>
  <input type="submit" name="submit" value="View Results">
</form>

<a href="options.php">Back to home</a>


<?php require "templates/footer.php"; ?>