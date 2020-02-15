<?php

/**
  * Function to query information based on
  * a parameter: in this case, name.
  *
  */

require "config.php";
require "common.php";
$sqlnum = strval($_GET["q"]);
function query_this(string $to_query) {
	echo "Function Time!";
    try {
		$sql = $to_query;
		$statement = $connection->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll();

		return $result;
	} catch(PDOException $error) {
		echo "Fail Time!";
		return "Error: ". $sql . "<br>" . $error->getMessage();
	}
}

if($sqlnum == "63610069933") {
	echo query_this("SELECT IDENTITY.ID, FIRST_NAME, LAST_NAME, SUM(TIMESTAMPDIFF(MINUTE, TIME_IN, TIME_OUT)) AS 'total_min' FROM IDENTITY JOIN PRACTICE ON PRACTICE.ID = IDENTITY.ID WHERE IDENTITY.ID = 1013934 GROUP BY ID;")["total_min"];
}

?>
<?php require "templates/header.php"; ?>


<?php require "templates/footer.php"; ?>