<?php
/** @var mysqli $db */

//Require music data & image helpers to use variable in this file
require_once "includes/database2.php";
require_once "includes/image-helpers.php";

if (isset($_POST['submit'])) {
    // DELETE IMAGE
    // To remove the image we need to query the file name from the db.
    // Get the record from the database result
    $commissionID = mysqli_escape_string($db, $_POST['id']);
    $query = "SELECT * FROM commissieaanvraag WHERE id = '$commissionID'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    $commission = mysqli_fetch_assoc($result);

    if (!empty($commission['image'])) {
        deleteImageFile($commission['image']);
    }

    // DELETE DATA
    // Remove the album data from the database with the existing albumId
    $query = "DELETE FROM commissieaanvraag WHERE id = '$commissionID'";
    mysqli_query($db, $query) or die ('Error: ' . mysqli_error($db));

    //Close connection
    mysqli_close($db);

    //Redirect to index after deletion & exit script
    header("Location: index.php");
    exit;

} else if (isset($_GET['id']) || $_GET['id'] != '') {
    //Retrieve the GET parameter from the 'Super global'
    $commissionID = mysqli_escape_string($db, $_GET['id']);

    //Get the information from the database
    $query = "SELECT * FROM commissieaanvraag WHERE id = '$commissionID'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    if (mysqli_num_rows($result) == 1) {
        $commission = mysqli_fetch_assoc($result);
    } else {
        // redirect when db returns no result
        header('Location: index.php');
        exit;
    }
} else {
    // Id was not present in the url OR the form was not submitted

    // Send back to index
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <title>Verwijder - <?= $commission['surname'] ?></title>
</head>
<body>
<h1>Delete - <?= $commission['surname'] ?></h1>
<form action="" method="post">
    <p>
        Weet u zeker dat u de commissieaanvraag van "<?= $commission['surname'] ?>" wilt verwijderen?
    </p>
    <input type="hidden" name="id" value="<?= $commission['id'] ?>"/>
    <input type="submit" name="submit" value="Verwijderen"/>
</form>
</body>
</html>
