<?php
session_start();
require_once('../php/displayFunctions.php');
require_once('../php/cmsLogic.php');
require('../php/adminFunctions.php');

session_start();


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
    <a href="images.php">Add & assign images</a>
    <a href="portfolioDelete.php">Delete some project</a>
    <a href="skills.php">Assign & add skills</a>
    <a href="../logOut.php">Log out</a>
</body>
</html>