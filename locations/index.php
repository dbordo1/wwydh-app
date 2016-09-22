<?php

	session_start();

	include "../helpers/conn.php";
/*
if ($_GET["isSearch"]) {
	echo "<h1>Location Search Results</h1>";
	echo "You searched for: ";
	if ($_GET["sAddress"])
	{
		echo "Address contains ";
		echo $_GET["sAddress"];
	}
	else
		echo "ANY Address";
	echo ", ";
	if ($_GET["sBlock"])
	{
		echo "Block contains ";
		echo $_GET["sBlock"];
	}
	else
		echo "ANY Block";
	echo ", ";
	if ($_GET["sLot"])
	{
		echo "Lot contains ";
		echo $_GET["sLot"];
	}
	else
		echo "ANY Lot";
	echo ", ";
	if ($_GET["sZip"])
	{
		echo "Zip Code contains ";
		echo $_GET["sZip"];
	}
	else
		echo "ANY Zip Code";
	echo ", ";
	if ($_GET["sCity"])
	{
		echo "City contains ";
		echo $_GET["sCity"];
	}
	else
		echo "ANY City";
	echo ", ";
	if ($_GET["sNeighborhood"])
	{
		echo "Neighborhood contains ";
		echo $_GET["sNeighborhood"];
	}
	else
		echo "ANY Neighborhood";
	echo ", ";
	if ($_GET["sPoliceDistrict"])
	{
		echo "Police District contains ";
		echo $_GET["sPoliceDistrict"];
	}
	else
		echo "ANY Police District";
	echo ", ";
	if ($_GET["sCouncilDistrict"])
	{
		echo "Council District contains ";
		echo $_GET["sCouncilDistrict"];
	}
	else
		echo "ANY Council District";
	echo ", ";
	if ($_GET["sLongitude"])
	{
		echo "Longitude contains ";
		echo $_GET["sLongitude"];
	}
	else
		echo "ANY Longitude";
	echo ", ";
	if ($_GET["sLatitude"])
	{
		echo "Latitude contains ";
		echo $_GET["sLatitude"];
	}
	else
		echo "ANY Latitude";
	echo ", ";
	if ($_GET["sOwner"])
	{
		echo "Owner contains ";
		echo $_GET["sOwner"];
	}
	else
		echo "ANY Owner";
	echo ", ";
	if ($_GET["sUse"])
	{
		echo "Use contains ";
		echo $_GET["sUse"];
	}
	else
		echo "ANY Use";
	echo ", ";
	if ($_GET["sMailingAddr"])
	{
		echo "Mailing Address contains ";
		echo $_GET["sMailingAddr"];
	}
	else
		echo "ANY Mailing Address";
}
else
{
	echo "<h1>All Locations</h1>" ;
}


echo "<p align=center>";
echo "<table width=1>";
*/

	$theQuery = "";
	$result = null;

	// BACKEND: change locations search code to prepared statements to prevent SQL injection
	if ($_GET["isSearch"]) {
		$theQuery = "SELECT * FROM `locations` WHERE `building_address` LIKE '%{$_GET["sAddress"]}%' AND `building_address` LIKE '%{$_GET["sAddress"]}%' AND `block` LIKE '%{$_GET["sBlock"]}%' AND `lot` LIKE '%{$_GET["sLot"]}%' AND `zip_code` LIKE '%{$_GET["sZip"]}%' AND `city` LIKE '%{$_GET["sCity"]}%' AND `neighborhood` LIKE '%{$_GET["sNeighborhood"]}%' AND `police_district` LIKE '%{$_GET["sPoliceDistrict"]}%' AND `council_district` LIKE '%{$_GET["sCouncilDistrict"]}%' AND `longitude` LIKE '%{$_GET["sLongitude"]}%' AND `latitude` LIKE '%{$_GET["sLatitude"]}%' AND `owner` LIKE '%{$_GET["sOwner"]}%' AND `use` LIKE '%{$_GET["sUse"]}%' AND `mailing_address` LIKE '%{$_GET["sMailingAddr"]}%'";
	}
	else {
		$q = $conn->prepare("SELECT l.*, COUNT(DISTINCT i.id) AS ideas, GROUP_CONCAT(DISTINCT f.feature SEPARATOR '[-]') AS features FROM locations l LEFT JOIN ideas i ON i.location_id = l.id LEFT JOIN location_features f ON f.location_id = l.id GROUP BY l.id");
	}

	$q->execute();
	$data = $q->get_result();;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>All Locations</title>
		<link href="../helpers/header_footer.css" type="text/css" rel="stylesheet" />
		<link href="styles.css" type="text/css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	</head>
	<body>
		<div class="grid-inner width">
			<div id="nav">
				<div class="nav-inner width">
					<a href="../home">
						<div id="logo"></div>
						<div id="logo_name">What Would You Do Here?</div>
					</a>
					<div id="user_nav" class="nav">
						<ul>
							<a href="#"><li>Log in</li></a>
							<a href="#"><li>Sign up</li></a>
						</ul>
					</div>
					<div id="main_nav" class="nav">
						<ul>
							<a href="../locations" class="active"><li>Locations</li></a>
							<a href="#"><li>Ideas</li></a>
							<a href="#"><li>Projects</li></a>
							<a href="#"><li>Contact</li></a>
						</ul>
					</div>
				</div>
			</div>
			<?php
			while ($row = $data->fetch_array(MYSQLI_ASSOC)) {
				if (isset($row["features"])) $row["features"] = implode(" | ", explode("[-]", $row["features"])); ?>

				<div class="location">
					<div class="grid-item">
						<?php if ($l["ideas"] > 0) { ?>
							<div class="ideas_count"><?php echo $l["ideas"] ?></div>
						<?php } ?>
						<div class="location_image" style="background-image: url(../helpers/location_images/<?php if (isset($row['image'])) echo $row['image']; else echo "pin.png";?>);"></div>
						<div class="location_desc">
							<div class="address"><?php echo $row["mailing_address"] ?></div>
							<div class="features">
								<?php echo $row["features"] ?>
							</div>
						</div>
					</div>
				</div>
				<!--
			  echo "<tr><td style=\"background-image:url(../helpers/location_images/{$row["image"]})\">
			 <div class=\"address\">{$row["building_address"]}</div><br/>
			 <div class=\"neighborhood\">{$row["neighborhood"]}</div><br/>
			 <div class=\"city\">{$row["city"]}</div><br/>
			 <div class=\"more\"><a href=\"propertyInfo.php?id={$row["id"]}\">(more)</a></div><br/>
			 </td></tr>
			 "; -->
		 	<?php }
			?>
		</div>
	</body>
</html>
