<?php
/** @var mysqli $db */

// Require DB settings with connection variable
require_once "includes/database2.php";
require_once "includes/image-helpers.php";

// Check if form has been submitted else check if id is set
if (isset($_POST['submit'])) {
    $id = mysqli_escape_string($db, $_POST['id']);
    $surname = mysqli_escape_string($db, $_POST['surname']);
    $familyname = mysqli_escape_string($db, $_POST['familyname']);
    $birthdate = mysqli_escape_string($db, $_POST['birthdate']);
    $email = mysqli_escape_string($db, $_POST['email']);
    $description = mysqli_escape_string($db, $_POST['description']);
    $costs = mysqli_escape_string($db, $_POST['costs']);
    $image = mysqli_escape_string($db, $_POST['image']);

    // Require form-validations
    require_once "../x1/includes/form-validation.php";

    if (empty($errors)) {
        // update reservation from database table
        $result = updateCommissie($db, $id, $surname, $familyname, $birthdate, $email, $description, $costs,);

        if ($result) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/PRG02-2021-2022/sandbox/x1/index.php');
            exit;
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

    }
} else if (isset($_GET['id']) || $_GET['id'] != '') {
    // Get id of commission
    $commissionID = mysqli_escape_string($db, $_GET['id']);

    // Get commission from database table
    $result = getCommissie($db, $commissionID);

    if (mysqli_num_rows($result) == 1) {
        $commission = mysqli_fetch_assoc($result);
    } else {
       header('Location: http://' . $_SERVER['HTTP_HOST'] . '/PRG02-2021-2022/sandbox/x1/index.php');
       exit;
    }
} else {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/PRG02-2021-2022/sandbox/x1/index.php');
    exit;
}

//Close connection
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Commissie aanpassen</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
    <!-- edit form -->
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Name input -->
        <div class="mb-3">
            <label for="surname" class="">Voornaam</label>
            <input type="text" name="surname" class="" id="surname" value="<?= isset($surname) ? htmlentities($surname) : $commission['surname'] ?>">
            <span class="text-danger"><?= isset($errors['surname']) ? $errors['surname'] : ''; ?></span>
        </div>
        <!-- Name input -->
        <div class="mb-3">
            <label for="familyname" class="">Achternaam</label>
            <input type="text" name="familyname" class="" id="familyname" value="<?= isset($familyname) ? htmlentities($familyname) : $commission['familyname'] ?>">
            <span class="text-danger"><?= isset($errors['familyname']) ? $errors['familyname'] : ''; ?></span>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="">Geboortedatum</label>
            <input type="date" name="birthdate" class="" id="birthdate" value="<?= isset($birthdate) ? htmlentities($birthdate) : $commission['birthdate'] ?>">
            <span class="text-danger"><?= isset($errors['birthdate']) ? $errors['birthdate'] : ''; ?></span>
        </div>
        <!-- Email input -->
        <div class="mb-3">
            <label for="email" class="">Email address</label>
            <input type="text" name="email" class="" id="email" value="<?= isset($email) ? htmlentities($email) : $commission['email'] ?>">
            <span class="text-danger"><?= isset($errors['email']) ? $errors['email'] : ''; ?></span>
        </div>
        <!-- Phone input -->
        <div class="mb-3">
            <label for="description" class="">Omschrijving</label>
            <textarea id="description" name="description" rows="4" cols="50"><?= isset($description) ? htmlentities($description) : $commission['description']; ?></textarea>
            <span class="text-danger"><?= isset($errors['description']) ? $errors['description'] : ''; ?></span>
        </div>
        <!-- Email input -->
        <div class="mb-3">
            <label for="costs" class="">Geschatte kosten</label>
            <input type="number" name="costs" class="" id="costs" value="<?= isset($costs) ? htmlentities($costs) : $commission['costs'] ?>">
            <span class="text-danger"><?= isset($errors['costs']) ? $errors['costs'] : ''; ?></span>
        </div>
        <!-- Email input -->


        <!-- Submit form -->
        <div class="mb-3">
            <input type="hidden" name="id" value="<?= $commission['id'] ?>"/>
            <input type="submit" name="submit" class="" value="Submit" aria-describedby="contactHelp">
            <div id="contactHelp" class="form-text">We'll never share your contact info with anyone else.</div>
        </div>
    </form>
</body>
</html>
