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

    $sql = "SELECT IDENTITY.ID, FIRST_NAME, LAST_NAME, SUM(TIMESTAMPDIFF(MINUTE, TIME_IN, TIME_OUT)) AS 'total_min' FROM IDENTITY JOIN PRACTICE ON PRACTICE.ID = IDENTITY.ID GROUP BY ID HAVING total_min >= :hour_range";
    $hour_range = $_POST['hour_range']*60;
    $statement = $connection->prepare($sql);
    $statement->bindParam(':hour_range', $hour_range, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();

    // $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
// SORT BY [TABLE]
if (isset($_GET["TABLE"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $TABLE = $_GET["TABLE"];

    $sql = "SELECT IDENTITY.ID, FIRST_NAME, LAST_NAME, SUM(TIMESTAMPDIFF(MINUTE, TIME_IN, TIME_OUT)) AS 'total_min' FROM IDENTITY JOIN PRACTICE ON PRACTICE.ID = IDENTITY.ID GROUP BY ID ORDER BY " . $TABLE . " ASC";

    $statement = $connection->prepare($sql);
    $statement->execute();
	$result2 = $statement->fetchAll();
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

    <table border=1 frame=void rules=all>
      <thead>
<tr>
<!--
  <th>ID</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Total Hours</th>
  <th>Total Minutes</th>
  -->
  <th><a href="get_all_times.php?TABLE=ID">ID</a></th>
  <th><a href="get_all_times.php?TABLE=FIRST_NAME">First Name</a></th>
  <th><a href="get_all_times.php?TABLE=LAST_NAME">Last Name</a></th>
  <th>Total Hours</th>
  <th><a href="get_all_times.php?TABLE=total_min">Total Minutes</a></th>
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

<!-- FOR TABLE -->

<?php
if (isset($_POST['TABLE'])) {
  if ($result2 && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table border=1 frame=void rules=all>
      <thead>
<tr>
<!--
  <th>ID</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Total Hours</th>
  <th>Total Minutes</th>
  -->
  <th><a href="get_all_times.php?TABLE=ID">ID</a></th>
  <th><a href="get_all_times.php?TABLE=FIRST_NAME">First Name</a></th>
  <th><a href="get_all_times.php?TABLE=LAST_NAME">Last Name</a></th>
  <th>Total Hours</th>
  <th><a href="get_all_times.php?TABLE=total_min">Total Minutes</a></th>
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
  <p>Hours Above/Equal To: <span id="time_slider"></span></p>
  <input type="range" min="0" max="200" value="0" name="hour_range" id="hour_range">
  <br>
  <input type="submit" name="submit" value="View Results">
</form>
<button onclick="exportTableToCSV('data.csv')">Export Data Table To CSV File</button>

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