<?php

/**
  * Function to query information based on
  * a parameter: in this case, name.
  *
  */

require "config.php";
require "common.php";
$sqlnum = strval($_GET["q"]);
echo $sqlnum;
function query_this(string $to_query) {
    try {
		$connection = new PDO($dsn, $username, $password, $options);
		echo $to_query;
		$statement = $connection->prepare($to_query);
		$statement->execute();

		$result = $statement->fetchAll();
		return $result;
	} catch(PDOException $error) {
		return "Error: ". $sql . "<br>" . $error->getMessage();
	}
}

if($sqlnum == "63610069933") {
	echo query_this("SELECT * FROM IDENTITY");
}

?>
<?php require "templates/header.php"; ?>


<?php require "templates/footer.php"; ?>