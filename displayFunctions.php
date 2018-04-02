<?php

function connectDatabase() {
    $db = new PDO('mysql:host=127.0.0.1; dbname=kyamPortfolio2', 'root');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $db;
}

$db = connectDatabase();

function getStatic($db) {
    $query=$db->prepare("SELECT `name`,`content` FROM `static`;");
    $query->execute();
    return $query->fetchAll();
}

function fillStatic($db) {
    $static=[];
    $array=getStatic($db);
    foreach ($array as $array) {
        $static[$array['name']] = $array['content'];
    }
    return $static;
}

function getShowcase($db) {
    $query=$db->prepare("SELECT `portfolio`.`name`,`portfolio`.`url`,`portfolio`.`description`,`portfolio`.`github`,`portfolio`.`date`, `images`.`path`, `images`.`alt`
                         FROM `featured`
                         LEFT JOIN `portfolio`
                         ON `featured`.`portfolioID`
                         =`portfolio`.`id`
                         LEFT JOIN `images`
                         ON `featured`.`portfolioID`
                         =`images`.`portfolioItem`
                         WHERE `portfolio`.`deleted`=0
                         ORDER BY `portfolio`.`date` DESC
                         LIMIT 3;");
    $query->execute();
    return $query->fetchAll();
};

function buildShowcase($db) {
    $string="";
    $array = getShowcase($db);
    foreach ($array as $showcase) {
        $string.="<article class='showcaseOuter'>
                <div class='portfolioShowcase'>
                    <img class='portfolioPicture' src=". $showcase['path'] ." alt=". $showcase['alt']. ">
                    <a href=".$showcase['url']." target=\"_blank\">".$showcase['name']."</a>
                    <p>".$showcase['description']."</p>
                    <a href=".$showcase['github']." class=\"portfolioGithub\" id=\"github\" target=\"_blank\">
                        <img src=\"assets/contact/github.svg\">
                    </a>
                </div>
            </article>";
    }
    return $string;
}

function getPortfolio($db) {
    $query=$db->prepare("SELECT `portfolio`.`id`,`portfolio`.`name`,`images`.`path`, `images`.`alt`
                         FROM `portfolio`
                         LEFT JOIN `images`
                         ON `portfolio`.`ID`
                         =`images`.`portfolioItem`
                         WHERE `portfolio`.`deleted`=0
                         ORDER BY `portfolio`.`date` DESC;");
    $query->execute();
    return $query->fetchAll();
}

function getSkills($db, $id) {
    $query=$db->prepare("SELECT `skill`
                         FROM `skills`
                         WHERE `portfolioID` = $id;");
    $query->execute();
    return $query->fetchAll();
}

function buildSkills($db,$id) {
    $string="";
    foreach(getSkills($db,$id) as $skill) {
        $string.=$skill['skill']." ";
    }
    return $string;
}


function buildPortfolio($db) {
    $portfolio = getPortfolio($db);
    $string="";
    foreach($portfolio as $item) {
        $string.="<article class=\"portfolioOuter\">
            <div class=\"portfolioItem\">
                <img src=". $item['path'] ." alt=' ". $item['alt'] ."'>
                <a href='focus.php'>". $item['name'] ."</a>
                <p class=\"skillList\">". buildSkills($db,$item['id']) ."
                </p>
            </div>
        </article>";
    }
    return $string;
}

?>

<form>

</form>
