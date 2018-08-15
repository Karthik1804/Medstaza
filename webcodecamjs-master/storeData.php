<!DOCTYPE=html>
<html>
<head>
        <meta charset="UTF-8">
        <title>WebCodeCamJS</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    
<style>
table, th, td 
{
    border-collapse: collapse;
}
th
{
    padding: 5px;  
}
td
{
    padding: 5px;  
}
</style>

</head>
<body>
<center><h2>Medstaz Pharmacy</h2></center>
<?php

//$data = $_POST["hidden1"];

if (isset($_POST['hidden1'])) {
	$data = htmlspecialchars($_POST['hidden1']);
	$myString = $data;
	$myArray = explode(',', $myString);

?>
<div class="container" id="QR-Code">
		<div class="panel panel-info">
                <div class="panel-heading">
                    <div class="navbar-form navbar-left">
                        <h4>Details of Medicine Scanned from QR Scanner:-</h4>
                    </div>
				</div>
				<div class="panel-body text-center">
                    <div class="col-md-6">
						<form name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
							  <table style="width:30%">
								<tr><th  align="right">Medicines</th><td align="left"><input name="med" type="text" size="10" value="<?php echo $myArray[0] ?>"></td></tr>	
								<tr><th  align="right" >Exp.Date</th><td  align="left"><input name="exp" type="text" size="10" value="<?php echo $myArray[1] ?>"></td></tr>
								<tr><th  align="right">Price</th><td align="left"><input name="pri" type="text" size="10" value="<?php echo $myArray[2] ?>"></td></tr>
								<tr><th  align="right">Quantity</th><td  align="left"><input name="qty" type="text" size="10"/></td></tr>
								<tr><th  align="right">Customer</th><td  align="left"><input name="cust" type="text" size="40"/></td></tr>
								<input type="hidden" name="hidden2" value="yes" />
								<tr><td colspan=2 align="center"><input name="submit" type="submit" value="Store & Print" ></td></tr>
							  </table>
						</form>
					</div>
				</div>
		</div>	

<?php    //used to store scanned data in DB
}
	if (isset($_POST['hidden2']) and $_POST['hidden2'] == "yes" ) {
		$dbConnection = mysqli_connect('localhost', 'root', null, 'medstaza');
		$med=$_POST['med'];
		$exp=$_POST['exp'];
		$pri=$_POST['pri'];
		$qty=$_POST['qty'];
		$cust=$_POST['cust'];
		$query = "INSERT INTO medtrack (MedicalShopID, MedicineName, Price, ExpiryDate, Qty, Customer) VALUES ('MedPlusShopNo45', '$med', '$exp', '$pri', '$qty', '$cust' )";
?>
<div class="container" id="QR-Code">
		<div class="panel panel-info">
			<div class="panel-heading"><b>
<?php
			if (mysqli_query($dbConnection, $query)) {
				echo "Successfully inserted " . mysqli_affected_rows($dbConnection) . " row";
			} else {
				echo "Error occurred: " . mysqli_error($dbConnection);
			}
?>
			</b></div>
		</div>
</div>
<?php
	}
?>

<?php    //used to access all stored data
	
		$dbConnection = mysqli_connect('localhost', 'root', '', 'medstaza');

		$query = "select * from medtrack";
		
		$result = mysqli_query($dbConnection, $query);

		if (mysqli_num_rows($result) > 0) { 
?>
	<div class="container" id="QR-Code">
		<div class="panel panel-info">
                <div class="panel-heading">
                    <div class="navbar-form navbar-left">
                        <h4>Existing Data in DB</h4>
                    </div>
				</div>
				<div class="panel-body text-center">
                   
<?php		
			
			echo "<table width='100%'><tr style='background-color:grey;'><th>Sl.No.</th><th>MedicalShopID</th><th>Medicine</th><th>Price</th><th>Expiry Date</th><th>Qty</th><th>Customer</th></tr>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>{$row['idmedtrack']}</td>";
				echo "<td>{$row['MedicalShopID']}</td>";
				echo "<td>{$row['MedicineName']}</td>";
				echo "<td>{$row['Price']}</td>";
				echo "<td>{$row['ExpiryDate']}</td>";
				echo "<td>{$row['Qty']}</td>";
				echo "<td>{$row['Customer']}</td>";
				echo "</tr>";
			}
			echo "</table>";
?>
					
				</div>
		</div>	
<?php
		} else {
			echo "Query didn't return any result";
		}

?>

</body>