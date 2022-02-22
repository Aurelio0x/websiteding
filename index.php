<?php
/** @var mysqli $db */

//Connect with the database
require_once "includes/database2.php";

//Get the result set from the database with a SQL query
$query = "SELECT * FROM commissieaanvraag";
$result = mysqli_query($db, $query) or die ('Error: ' . $query );

//Loop through all results to create an array
$commissionrequest = [];
while ($row = mysqli_fetch_assoc($result)) {
    $commissionrequest[] = $row;
}

//Close connection
mysqli_close($db);
?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Russo+One&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Rochester&display=swap');
</style>

<head>
    <title>Commissie aanvragen</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<div id="logo">
    <a class= "kek" href="../x2/index2.html">
        <img src="../x2/images/Afbeelding1.pnghuis.png">
    </a>
</div>
<h1>Commissie aanvragen</h1>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Voornaam</th>
        <th>Achternaam</th>
        <th>Geboortedatum</th>
        <th>E-Mail</th>
        <th>Omschrijving</th>
        <th>Geschatte kosten</th>
        <th colspan="3"></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="10"></td>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($commissionrequest as $commission) { ?>
        <tr>
            <td><?= $commission['id'] ?></td>
            <td><?= $commission['surname'] ?></td>
            <td><?= $commission['familyname'] ?></td>
            <td><?= $commission['birthdate'] ?></td>
            <td><?= $commission['email'] ?></td>
            <td><?= $commission['description'] ?></td>
            <td><?= $commission['costs'] ?></td>
            <td><a href="details.php?id=<?= $commission['id'] ?>">Details</a></td>
            <td><a href="edit.php?id=<?= $commission['id'] ?>">Aanpassen</a></td>
            <td><a href="delete.php?id=<?= $commission['id'] ?>">Verwijder</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
<button class="btn">
<a href="create.php">Nieuwe commissie aanmaken</a>
</button class="btn">
</html>
