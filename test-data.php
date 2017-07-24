<?php

function myLoader($className) {
    $class = str_replace('\\', '/', $className);
    require($class . '.php');
}

spl_autoload_register('myLoader'); //en rajoutant ça on a comme un include


use data\DataDoggo;
use entities\SmallDoggo;


$data = new DataDoggo();

//on test tt les uns à la suite des autres et pr delete on voit 
//depuis le terminal si ds ma bdd un chien a bien été supp
//echo '<pre>';
//var_dump($data->getAllDoggo());
//echo '</pre>';

// pr tester la récupération
//echo '<pre>';
//var_dump($data->getDoggoById(1000000000));
//echo '</pre>';



//modification d'un chien
//$data->addDoggo(new SmallDoggo('test-data', 'test-data', new DateTime, true));
//$data->updateDoggo(new SmallDoggo('test-modif', 'test-modif', new DateTime, true, 1));

//suppression 
$data->deleteDoggo(new SmallDoggo('NULL', 'NULL', new DateTime(), false, 16));