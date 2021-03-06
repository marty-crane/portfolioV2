<?php

/**
 * @return PDO
 */
function connectDatabase():PDO {
    $db = new PDO('mysql:host=127.0.0.1; dbname=kyamPortfolio2', 'root');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $db;
}

$db = connectDatabase();

/**
 * Get statis content from DB
 *
 * @param PDO $db
 *
 * @return array of static content
 */
function getStatic(PDO $db):array {
    $query=$db->prepare("SELECT `name`,`content` FROM `static`;");
    $query->execute();
    return $query->fetchAll();
}

/**
 * Takes static array and reassigned keys & values to new array
 *
 * @param PDO $db
 *
 * @return array
 */
function fillStatic(PDO $db):array {
    $static=[];
    $array=getStatic($db);
    foreach ($array as $array) {
        $static[$array['name']] = $array['content'];
    }
    return $static;
}

/**
 * Get showcase projects data
 *
 * @param PDO $db
 *
 * @return array projects data
 */
function getShowcase(PDO $db):array {
    $query=$db->prepare("SELECT `portfolio`.`id`,`portfolio`.`name`,`portfolio`.`url`,`portfolio`.`description`,`portfolio`.`github`,`portfolio`.`date`, `images`.`path`, `images`.`alt`
                         FROM `featured`
                         LEFT JOIN `portfolio`
                         ON `featured`.`portfolioID`
                         =`portfolio`.`id`
                         LEFT JOIN `images`
                         ON `featured`.`portfolioID`
                         =`images`.`portfolioItem`
                         WHERE `portfolio`.`deleted`=0
                         AND `images`.`deleted`=0
                         ORDER BY `portfolio`.`date` DESC
                         LIMIT 3;");
    $query->execute();
    return $query->fetchAll();
};

/**
 * Builds HTML elements for project showcase
 *
 * @param PDO $db
 *
 * @return string HTML elements to display showcase
 */
function buildShowcase(PDO $db):string {
    $string="";
    $array = getShowcase($db);
    foreach ($array as $showcase) {
        $string.="<article class='showcaseOuter'>
                <div class='portfolioShowcase'>
                    <img class='portfolioPicture' src=". $showcase['path'] ." alt=". $showcase['alt']. ">
                    <form method='get' action='focus.php'>
                    <input type='hidden' name='id' value=". $showcase['id']. ">
                    <input class='focusBuilder' type=\"submit\" value=". $showcase['name'] .">
                    </form>
                    <p>".$showcase['description']."</p>
                    <a href=".$showcase['github']." class=\"portfolioGithub\" id=\"github\" target=\"_blank\">
                        <img src=\"assets/contact/github.svg\">
                    </a>
                </div>
            </article>";
    }
    return $string;
}

/**
 * Gets all non-deleted projects
 *
 * @param PDO $db
 *
 * @return array of projects
 */
function getPortfolio(PDO $db):array {
    $query=$db->prepare("SELECT `portfolio`.`id`,`portfolio`.`name`,`images`.`path`, `images`.`alt`
                         FROM `portfolio`
                         LEFT JOIN `images`
                         ON `portfolio`.`ID`
                         =`images`.`portfolioItem`
                         WHERE `portfolio`.`deleted`=0
                         AND `images`.`deleted`=0
                         ORDER BY `portfolio`.`date` DESC;");
    $query->execute();
    return $query->fetchAll();
}

/**
 * Gets skills for selected project
 *
 * @param PDO $db
 * @param int $id user selection
 *
 * @return array project skills
 */
function getSkills(PDO $db,int $id):array {
    $query=$db->prepare("SELECT `skill`
                         FROM `skills`
                         WHERE `portfolioID` = $id
                         && `deleted`=0;");
    $query->execute();
    return $query->fetchAll();
}

/**
 * Builds list of skills to display as string
 *
 * @param PDO $db
 * @param int $id user selection
 *
 * @return string of skills
 */
function buildSkills(PDO $db,int $id):string {
    $string="";
    foreach(getSkills($db,$id) as $skill) {
        $string.=$skill['skill'].", ";
    }
    return substr($string, 0,-2);
}


/**
 * Builds HTML element for each project for display
 *
 * @param PDO $db
 *
 * @return string of HTML elements
 */
function buildPortfolio(PDO $db):string {
    $portfolio = getPortfolio($db);
    $string="";
    foreach($portfolio as $item) {
        $string.="<article class=\"portfolioOuter\">
                  <div class=\"portfolioItem\">
                  <img src=". $item['path'] ." alt=' ". $item['alt'] ."'>
                  <form method='get' action='focus.php'>
                    <input type='hidden' name='id' value=". $item['id']. ">
                    <input class='focusBuilder' type=\"submit\" value='". $item['name'] ."'>
                  </form>
                  <p class=\"skillList\">". buildSkills($db,$item['id']) ."
                  </p>
                  </div>
        </article>";
    }
    return $string;
}

/**
 * Build focus for selected project
 *
 * @param PDO $db
 * @param int $id user selection
 *
 * @return array of project data
 */
function buildFocus(PDO $db,int $id):array {
    $query=$db->prepare("SELECT `portfolio`.`id`,`portfolio`.`name`,`portfolio`.`description`,`images`.`path`, `images`.`alt`,`portfolio`.`github`,`portfolio`.`url`,`portfolio`.`date`
                         FROM `portfolio`
                         LEFT JOIN `images`
                         ON `portfolio`.`ID`
                         =`images`.`portfolioItem`
                         WHERE `portfolio`.`id`=$id
                         AND `images`.`deleted`=0;");
    $query->execute();
    return $query->fetch();
}
