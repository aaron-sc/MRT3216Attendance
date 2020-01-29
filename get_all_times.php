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
	$TABLE = $_POST['TABLE'];
	$ASCORDESC = $_POST['ASC-DESC'];
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT IDENTITY.ID, FIRST_NAME, LAST_NAME, SUM(TIMESTAMPDIFF(MINUTE, TIME_IN, TIME_OUT)) AS 'total_min' FROM IDENTITY JOIN PRACTICE ON PRACTICE.ID = IDENTITY.ID GROUP BY ID HAVING total_min >= :hour_range ORDER BY " . $TABLE . " " . $ASCORDESC;
	
    $hour_range = $_POST['hour_range']*60;
    $statement = $connection->prepare($sql);
    $statement->bindParam(':hour_range', $hour_range, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
	$success = "Sorting by " . $TABLE . " " . $ASCORDESC;
    // $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

?>
<?php require "templates/header.php"; ?>


<!-- FOR SUBMIT -->
<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>
	<?php if ($success) echo $success; ?>
	<br>
	<br>
    <table border=1 frame=void rules=all>
      <thead>
<tr>
  <th>ID</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Total Hours</th>
  <th>Total Minutes</th>
</tr>
      </thead>
      <tbody>
  <?php foreach ($result as $row) { ?>
      <tr>
<td><?php echo escape($row["ID"]); ?></td>
<td><?php echo escape($row["FIRST_NAME"]); ?></td>
<td><?php echo escape($row["LAST_NAME"]); ?></td>
<td><?php echo escape($row["total_min"]) / 60;  ?></td>
<td><?php echo escape($row["total_min"]);  ?></td>


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
  <label for="hour_range">Hours Above/Equal To: <span id="time_slider"></span></label>
  <input type="range" min="0" max="200" value="0" name="hour_range" id="hour_range">
  <br>

  <!-- ORDER BY TABLE -->
  <label for="TABLE">Order By:</label>
  <select id="TABLE" name="TABLE">
	<option value="ID">ID</option>
	<option value="FIRST_NAME">First Name</option>
	<option value="LAST_NAME">Last Name</option>
	<option value="total_min">Total Minutes</option>
  </select>
  <br>
  <!-- ORDER ASC/DESC -->
  <label for="ASC-DESC">A-Z or Z-A:</label>
  <select id="ASC-DESC" name="ASC-DESC">
	<option value="ASC">A-Z</option>
	<option value="DESC">Z-A</option>
  </select>
  <br>
  <input type="submit" name="submit" value="View Results">
</form>
<button onclick="exportTableToCSV('data.csv')">Export Data Table To CSV File</button>
<br>
<a href="options.php">Back to home</a>



<script>
var slider = document.getElementById("hour_range");
var output = document.getElementById("time_slider");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>


<!--Below is for the download data-->
<script type="text/javascript">
  function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

  function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
</script>

<?php require "templates/footer.php"; ?>