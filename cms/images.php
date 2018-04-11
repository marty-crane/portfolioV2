<?php
session_start();
require_once('../php/displayFunctions.php');
require_once('../php/cmsLogic.php');
$projectArray=portfolioList($db);
$imageArray=getImages($db);
//var_dump(getImages($db));

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Images lol</title>
    <link rel="stylesheet" type="text/css" href="../css/cmsStyles.css">
</head>
<body>
<a href="index.php">back to main page</a>
<form><label></label>
    <select name="picSelect"><?php echo makeDropDown($imageArray); ?>
    </select>
    <label></label>
    <select name="projectSelect"><?php echo makeDropDown($projectArray); ?>
    </select>
</form>
</body>
</html>
