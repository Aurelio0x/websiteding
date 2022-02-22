<?php
/** @var mysqli $db */

// If url does not have an id, redirect to index
if(!isset($_GET['id']) || $_GET['id'] == '') {
    // redirect to index.php
    header('Location: index.php');
    exit;
}

//Get access to the database
require_once "includes/database2.php";

//Retrieve the GET parameter from the 'Super global'
$commissionID = mysqli_escape_string($db, $_GET['id']);

//Retrieve information from te database
$query = "SELECT * FROM commissieaanvraag WHERE id = '$commissionID'";
$result = mysqli_query($db, $query)
    or die ('Error: ' . $query );

if(mysqli_num_rows($result) != 1)
{
    // redirect when db returns no result
    header('Location: index.php');
    exit;
}

$commission = mysqli_fetch_assoc($result);

//Close connection with mysql
mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <title>Commissie Details</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<h1><?= $commission['surname'] . ' - ' . $commission['familyname'] ?></h1>

<div>
    <img src="images/<?= $commission['image'] ?>" alt=""/>
</div>
<ul>
    <li>Geboortedatum:  <?= $commission['birthdate'] ?></li>
    <li>E-Mail:   <?= $commission['email'] ?></li>
    <li>Omschrijving: <?= $commission['description'] ?></li>
    <li>Geschatte kosten: <?= $commission['costs'] ?></li>

</ul>
<div>
    <a href="index.php">Go back to the list</a>
</div>
</body>
</html>
