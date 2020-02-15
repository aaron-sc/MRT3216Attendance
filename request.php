<?php

/**
  * Function to query information based on
  * a parameter: in this case, name.
  *
  */

require "config.php";
require "common.php";
$sqlnum = strval($_GET["q"]);
function query_this($query) {
    try {
		$connection = new PDO($dsn, $username, $password, $options);

		$statement = $connection->prepare($query);
		$statement->execute();

		$result = $statement->fetchAll();
		return $result;
	} catch(PDOException $error) {
		return $sql . "<br>" . $error->getMessage();
	}
}

if($sqlnum == "63610069933") {
	echo query_this("SELECT IDENTITY.ID, FIRST_NAME, LAST_NAME, SUM(TIMESTAMPDIFF(MINUTE, TIME_IN, TIME_OUT)) AS 'total_min' FROM IDENTITY JOIN PRACTICE ON PRACTICE.ID = IDENTITY.ID GROUP BY ID HAVING total_min >= :hour_range");
}

?>
<?php require "templates/header.php"; ?>


<?php require "templates/footer.php"; ?>