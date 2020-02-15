<?php

/**
  * Function to query information based on
  * a parameter: in this case, name.
  *
  */

try {
	require "config.php";
	require "common.php";

	$connection = new PDO($dsn, $username, $password, $options);

	$sql = strval($_GET["sql"])



	$statement = $connection->prepare($sql);
	$statement->execute();

	$result = $statement->fetchAll();
	echo $result;
} catch(PDOException $error) {
	echo $sql . "<br>" . $error->getMessage();
}
}
?>
<?php require "templates/header.php"; ?>


<?php require "templates/footer.php"; ?>