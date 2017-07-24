<?php

function myLoader($className) {
    $class = str_replace('\\', '/', $className);
    require($class . '.php');
}

spl_autoload_register('myLoader'); //en rajoutant ça on a comme un include

use entities\SmallDoggo;



try {
$db = new PDO('mysql:host=localhost;dbname=first_db', 'admin', 'simplon');

//pour afficher les erreurs de mysql rajouter cette ligne cf dessous
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//cree un objet pdo statement
$query = $db->query('SELECT * FROM small_doggo');
//$query->execute(); pas besoin d'execute car query execute directement la requête
$chiens = [];
while($ligne = $query->fetch()) { //fetch = le suivant
//créer des instances de chien à partir des lignes
//echo $ligne['name'];
    //affiche les chiens sous forme de ul>li
        /*echo '<ul>';
        echo '<li>' . $ligne['id'] . '</li>';
        echo '<li>' . $ligne['name'] . '</li>';
        echo '<li>' . $ligne['race'] . '</li>';
        echo '<li>' . $ligne['birthdate'] . '</li>';
        echo '<li>' . $ligne['is_good'] . '</li>';
        echo '</ul>';*/
    
    $chien = new SmallDoggo($ligne['name'],$ligne['race'], new DateTime($ligne['birthdate']), $ligne['is_good'], $ligne['id']);
   $chiens[] = $chien;

    
}
/*echo '<pre>';
 var_dump($chiens);
 echo '</pre>';*/

$id=1;
$queryId = $db->prepare('SELECT * FROM small_doggo WHERE id =:id');
$queryId->bindParam('id', $id, PDO::PARAM_INT);
$queryId->execute();
if($queryId->rowCount() == 1) { //optionnel
$ligneId= $queryId->fetch();
$chien = new SmallDoggo($ligneId['name'],$ligneId['race'], new DateTime($ligneId['birthdate']), $ligneId['is_good'], $ligneId['id']);
var_dump($chien);
}
/* ou alors comme yaya
$id=1;
$queryId = $db->query('SELECT * FROM small_doggo WHERE="' .$id. ' " ');

var_dump($id);
var_dump($chiens);*/
$name = 'test';
    $race = 'test';
    $birthdate = '2015-10-10';
    $isGood = true;
    //On prepare notre requête avec ses paramètres en placeholder
    $queryInsert = $db->prepare('INSERT INTO small_doggo '
            . '(name,race,birthdate,is_good) '
            . 'VALUES (:name,:race,:birthdate,:isGood)');
    //On assigne les paramètres
    $queryInsert->bindValue('name', $name, PDO::PARAM_STR);
    $queryInsert->bindValue('race', $race, PDO::PARAM_STR);
    $queryInsert->bindValue('birthdate', $birthdate, PDO::PARAM_STR);
    $queryInsert->bindValue('isGood', $isGood, PDO::PARAM_BOOL);
    //On exécute
    $queryInsert->execute();
    //on récupère l'id de la ligne qui vient d'être ajoutée
    echo $db->lastInsertId();
} catch (PDOException $exception) {
    echo $exception->getMessage();
}