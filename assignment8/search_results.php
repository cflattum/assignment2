<?php

//var_dump($_GET);
// Same 4 steps to connect and query the database

// STEP 1
$host = "303.itpwebdev.com";
$user = "cflattum_db_user";
$password = "Chris1999!";
$db = "cflattum_dvd_db";

$mysqli = new mysqli($host, $user, $password, $db);


if($mysqli->connect_errno) {
	echo $mysqli->connect_error;
	exit();
}

// Remove weird symbols
$mysqli->set_charset("utf-8");


// STEP 2
$sql = "SELECT dvd_titles.title AS title,
genres.genre AS genre,
ratings.rating AS rating,
labels.label AS label,
formats.format AS format,
sounds.sound AS sound,
dvd_titles.release_date as r_date
FROM dvd_titles
JOIN genres 
ON dvd_titles.genre_id = genres.genre_id 
JOIN ratings 
ON dvd_titles.rating_id = ratings.rating_id 
JOIN labels 
ON dvd_titles.label_id = labels.label_id 
JOIN formats 
ON dvd_titles.format_id = formats.format_id 
JOIN sounds 
ON dvd_titles.sound_id = sounds.sound_id
WHERE 1=1";

//total results need anotjher function
$sql_total = "SELECT COUNT(*) FROM dvd_titles
 JOIN genres 
ON dvd_titles.genre_id = genres.genre_id 
JOIN ratings 
ON dvd_titles.rating_id = ratings.rating_id 
JOIN labels 
ON dvd_titles.label_id = labels.label_id 
JOIN formats 
ON dvd_titles.format_id = formats.format_id 
JOIN sounds 
ON dvd_titles.sound_id = sounds.sound_id 
WHERE 1=1";


// Depending on what user information was passed to this page, append to the base statement
if( (isset($_GET["title"]) && !empty($_GET["title"]) )  && (!($_GET["title"] == ""))) {
	$sql = $sql . " AND dvd_titles.title LIKE '%" . $_GET["title"] . "%' ";
	$sql_total = $sql_total . " AND dvd_titles.title LIKE '%" . $_GET["title"] . "%' ";
}

// Check if user selected genre
if( (isset($_GET["genre"]) && !empty($_GET["genre"]) )  && (!($_GET["genre"] == "any"))) {
	$sql = $sql . " AND genres.genre_id = " . $_GET["genre"];
	$sql_total = $sql_total . " AND genres.genre_id = " . $_GET["genre"];
}

// Check if user selected ratings
if( (isset($_GET["rating"]) && !empty($_GET["rating"]) )  && (!($_GET["rating"] == "any"))) {
	$sql = $sql . " AND ratings.rating_id = " . $_GET["rating"];
	$sql_total = $sql_total . " AND ratings.rating_id = " . $_GET["rating"];
}

// Check if user selected label
if( (isset($_GET["label"]) && !empty($_GET["label"]) )  && (!($_GET["label"] == "any"))) {
	$sql = $sql . " AND labels.label_id = " . $_GET["label"];
	$sql_total = $sql_total . " AND labels.label_id = " . $_GET["label"];
}

// Check if user selected label
if( (isset($_GET["format"]) && !empty($_GET["format"]))  && (!($_GET["sound"] == "any")) ) {
	$sql = $sql . " AND formats.format_id = " . $_GET["format"];
	$sql_total = $sql_total . " AND formats.format_id = " . $_GET["format"];
}

// Check if user selected label
if( (isset($_GET["sound"]) && !empty($_GET["sound"]))  && (!($_GET["sound"] == "any")) ) {
	$sql = $sql . " AND sounds.sound_id = " . $_GET["sound"];
	$sql_total = $sql_total . " AND sounds.sound_id = " . $_GET["sound"];
}

// // Check award
// if( (isset($_GET["award"]) && !empty($_GET["award"]))) {
// 	$sql = $sql . " AND dvd_titles.award = " . $_GET["award"];
// 	$sql_total = $sql_total . " AND dvd_titles.award = " . $_GET["award"];
// }

// Check award
if( $_GET["award"] == "yes" ) {
	$sql = $sql . " AND dvd_titles.award IS NOT NULL";
	$sql_total = $sql_total . " AND dvd_titles.award IS NOT NULL";
}

if( $_GET["award"] == "no" ) {
	$sql = $sql . " AND dvd_titles.award IS NULL";
	$sql_total = $sql_total . " AND dvd_titles.award IS NULL";
}
//dont need to check for any in award bc it should show all

// Check release date
if( (isset($_GET["release_date_from"]) && !empty($_GET["release_date_from"])) && (isset($_GET["release_date_to"]) && !empty($_GET["release_date_to"])) ) {
	$sql = $sql . " AND dvd_titles.release_date BETWEEN " . "\"" . $_GET["release_date_to"] . "\" AND " . "\"" . $_GET["release_date_from"] . "\"";
	$sql_total = $sql_total . " AND dvd_titles.release_date BETWEEN " . "\"" . $_GET["release_date_to"] . "\" AND " . "\"" . $_GET["release_date_from"] . "\"";
}

// Don't forget the semicolon at the end!
$sql = $sql . ";";

//echo "<hr>" . $sql . "<hr>";
//echo "<hr>" . $sql_total . "<hr>";

// Submit the query!
$results = $mysqli->query($sql);
$results_total = $mysqli->query($sql_total);


if(!$results) {
	echo $mysqli->error;
	exit();
}

// close the db connection
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">

				Showing 
				<?php
				  $row = $results_total->fetch_row(); 
				  $value = $row[0] ?? false;
				   echo $value;
				?> 
				result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>DVD Title</th>
							<th>Release Date</th>
							<th>Genre</th>
							<th>Rating</th>
						</tr>
					</thead>
					<tbody>
					<?php while($row = $results->fetch_assoc()):?>
					<tr>
						<td><?php echo $row["title"] ?></td>
						<td><?php echo $row["r_date"] ?></td>
						<td><?php echo $row["genre"] ?></td>
						<td><?php echo $row["rating"] ?></td>
					</tr>
					<?php endwhile;?>





						<!-- <tr>
							<td>
								Title name.
							</td>
							<td>Release Date</td>
							<td>Genre</td>
							<td>Rating</td>
						</tr> -->


					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
</body>
</html>