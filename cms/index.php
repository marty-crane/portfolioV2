<?php
session_start();
require_once('../php/displayFunctions.php');
require_once('../php/cmsLogic.php');
require('../php/adminFunctions.php');

session_start();
//var_dump($_SESSION);

//$_SESSION['loggedIn']=logIn($_POST['username'],$_POST['password'],$db);

//ifLoggedIn($_SESSION['loggedIn']);

//var_dump(password_hash('test',PASSWORD_BCRYPT));

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kyam Harris | Edit page</title>
    <link rel="stylesheet" type="text/css" href="../css/cmsStyles.css">
</head>
<body>
    <h1>Edit some stuff</h1>
    <a href="about.php">Edit About section</a>
    <a href="portfolioAdd.php">Add a project</a>
    <a href="portfolioEdit.php">Edit a project</a>
    <a href="images.php">Sort out some images</a>
    <a href="portfolioDelete.php">Delete some shit</a>
    <a href="skills.php">un fuck-up the skills section</a>
</body>
</html>