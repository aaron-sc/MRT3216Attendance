<?php
/**
  * Use an HTML form to edit an entry in the
  * users table.
  *
  */
require "config.php";
require "common.php";
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $change =[
      "ID"        => $_POST['ID'],
      "FIRST_NAME" => $_POST['FIRST_NAME'],
	  "LAST_NAME" => $_POST['LAST_NAME']
    ];
    
    $sql = "UPDATE IDENTITY
            SET ID = :ID,
              FIRST_NAME = :FIRST_NAME,
			  LAST_NAME = :LAST_NAME
            WHERE ID = :ID";
  $statement = $connection->prepare($sql);
  $statement->execute($change);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['ID'])) {
  try {
    $connection = new PDO($dsn, $userNAME, $password, $options);
    $ID = $_GET['ID'];
    $sql = "SELECT * FROM IDENTITY WHERE ID = :ID";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':ID', $ID);
    $statement->execute();

    $change = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <?php echo escape($_POST['NAME']); ?> successfully updated.
<?php endif; ?>

<h2>Edit A Student's Details</h2>

<form method="post">
    <?php foreach ($change as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" ID="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'ID' ? 'readonly' : null); ?>> <br>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="options.php">Back to home</a>

<?php require "templates/footer.php"; ?>