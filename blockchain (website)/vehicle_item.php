<?php
require_once('db.php');
//session_start();

// get colour function
// return json string
if (isset($_GET["action"]) && $_GET["action"] === 'getColour') {
	if (isset($_GET["model"])) {
		$sql_colour = "SELECT DISTINCT vcolour FROM vehicle_items WHERE vmodel = '" .$_GET["model"] . "'";

		$query = $conn->prepare($sql_colour);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($results);
	} else {
		echo "No brand provided.";
	}
}

// get model function
if (isset($_GET["action"]) && $_GET["action"] === 'getModel') {
	if (isset($_GET["brand"])) {
		$sql_model = "SELECT DISTINCT vmodel FROM vehicle_items WHERE vbrand = '" .$_GET["brand"] . "'";

		$query = $conn->prepare($sql_model);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($results);
	} else {
		echo "No brand provided.";
	}
}

// get vehicle price
if (isset($_GET["action"]) && $_GET["action"] === 'getPrice') {
	if (isset($_GET["model"])) {
		$sql_price = "SELECT vprice FROM vehicle_items WHERE vmodel = '" .$_GET["model"] . "'";

		$query = $conn->prepare($sql_price);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($results);
	} else {
		echo "No brand provided.";
	}
}

?>