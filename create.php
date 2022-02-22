<?php
/** @var mysqli $db */

//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
    //Require database in this file & image helpers
    require_once "includes/database2.php";
    require_once "includes/image-helpers.php";

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $surname = mysqli_escape_string($db, $_POST['surname']);
    $familyname = mysqli_escape_string($db, $_POST['familyname']);
    $birthdate = mysqli_escape_string($db, $_POST['birthdate']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $description = mysqli_escape_string($db, $_POST['description']);
    $costs = mysqli_escape_string($db, $_POST['costs']);


    //Require the form validation handling
    require_once "includes/form-validation.php";

    //Special check for add form only
    if ($_FILES['image']['error'] == 4) {
        $errors['image'] = 'Image cannot be empty';
    }

    if (empty($errors)) {
        //Store image & retrieve name for database saving
        $image = addImageFile($_FILES['image']);

        //Save the record to the database
        $query = "INSERT INTO commissieaanvraag (surname, familyname, birthdate, email, description, costs, image)
                  VALUES ('$surname', '$familyname', '$birthdate', '$email', '$description', $costs, '$image')";
        $result = mysqli_query($db, $query) or die('Error: ' . mysqli_error($db) . ' with query ' . $query);

        //if succeeded, send to thank you page. Or if error, show it
        if ($result) {
            header('Location: ../x2/bedankt.php');
            exit;
        } else {
            $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        //Close connection
        mysqli_close($db);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Commissie aanmaken</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<h1>Commissie aanmaken</h1>
<?php if (isset($errors)) { ?>
    <ul class="errors">
        <?php foreach ($errors as $error) { ?>
            <li> <?= $error ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<!-- enctype="multipart/form-data" no characters will be converted -->
<form action="" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="surname">Voornaam</label>
        <input id="surname" type="text" name="surname"
               value="<?= isset($surname) ? htmlentities($surname) : '' ?>"/>
        <span class="errors"><?= $errors['surname'] ?? '' ?></span>
    </div>
    <div class="data-field">
        <label for="familyname">Achternaam</label>
        <input id="familyname" type="text" name="familyname"
               value="<?= isset($familyname) ? htmlentities($familyname) : '' ?>"/>
        <span class="errors"><?= isset($errors['familyname']) ? $errors['familyname'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="birthdate">Geboortedatum</label>
        <input id="birthdate" type="date" name="birthdate"
               value="<?= isset($birthdate) ? htmlentities($birthdate) : '' ?>"/>
        <span class="errors"><?= isset($errors['birthdate']) ? $errors['birthdate'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="email">E-Mail</label>
        <input id="email" type="email" name="email" value="<?= isset($email) ? htmlentities($email) : '' ?>"/>
        <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="description">Omschrijving</label>
        <input id="description" type="text" name="description"
               value="<?= isset($description) ? htmlentities($description) : '' ?>"/>
        <span class="errors"><?= isset($errors['description']) ? $errors['description'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="costs">Geschatte kosten in euro's</label>
        <input id="costs" type="number" name="costs"
               value="<?= isset($costs) ? htmlentities($costs) : '' ?>"/>
        <span class="errors"><?= isset($errors['costs']) ? $errors['costs'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="image">Image</label>
        <input type="file" name="image" id="image"/>
        <span class="errors"><?= isset($errors['image']) ? $errors['image'] : '' ?></span>
    </div>
    <div class="data-submit">
        <input type="submit" name="submit" value="Save"/>
    </div>
</form>
</body>
</html>
