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

    $sql = "SELECT IDENTITY.ID, FIRST_NAME, LAST_NAME, SUM(TIMESTAMPDIFF(MINUTE, TIME_IN, TIME_OUT)) AS 'total_min' FROM IDENTITY JOIN PRACTICE ON PRACTICE.ID = IDENTITY.ID WHERE IDENTITY.ID = :id GROUP BY ID;";
    $id = $_POST['id'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
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
<td><?php echo ceil(escape($row["total_min"]) / 60);  ?></td>
<td><?php echo escape($row["total_min"]);  ?></td>


      </tr>
    <?php } ?>
      </tbody>
  </table>
  <?php } else { ?>
    > No results found for <?php echo escape($_POST['id']); ?>.
  <?php }
} ?>

<h2>Get total minutes</h2>

<form method="post">
  <label for="id">ID: </label>
  <input type="text" name="id" id="id">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="options.php">Back to home</a>

<script>
Quagga.init({           
        inputStream : {
            name : "Live",
            type : "LiveStream",
            target: document.querySelector('#barcode-scanner'), 
             constraints: {
                width: 100,
                height: 400,                  
                facingMode: "environment"  //"environment" for back camera, "user" front camera
                }               
        },                         
        decoder : {
            readers : ["code_128_reader","code_39_reader"],
			debug: {
                        showCanvas: true,
                        showPatches: true,
                        showFoundPatches: true,
                        showSkeleton: true,
                        showLabels: true,
                        showPatchLabels: true,
                        showRemainingPatchLabels: true,
                        boxFromPatches: {
                            showTransformed: true,
                            showTransformedBox: true,
                            showBB: true
                        }
                    }
        }

    }, function(err) {
        if (err) {
            esto.error = err;
            console.log(err);
                return
        }

 		console.log("Initialization finished. Ready to start");
        Quagga.start();
        Quagga.onDetected(function(result) {                              
                var last_code = result.codeResult.code;                   
                    console.log("last_code "); 
             });
		            Quagga.onProcessed(function (result) {
                var drawingCtx = Quagga.canvas.ctx.overlay,
                drawingCanvas = Quagga.canvas.dom.overlay;

                if (result) {
                    if (result.boxes) {
                        drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                        result.boxes.filter(function (box) {
                            return box !== result.box;
                        }).forEach(function (box) {
                            Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
                        });
                    }

                    if (result.box) {
                        Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
                    }

                    if (result.codeResult && result.codeResult.code) {
                        Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
                    }
                }
            });


            Quagga.onDetected(function (result) {
                // console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
				document.getElementById("id").innerHTML = result.codeResult.code;
				Quagga.stop();

            });
    });
</script>

<?php require "templates/footer.php"; ?>