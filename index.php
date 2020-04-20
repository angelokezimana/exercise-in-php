<?php

function loadClass($class)
{
    if(file_exists('Controller/'.$class.'.php')) {
        require 'Controller/'.$class.'.php';
    }
    elseif(file_exists('Model/'.$class.'.php')){
        require 'Model/'.$class.'.php';
    }
}

spl_autoload_register('loadClass');

$db = new PDO('mysql:host=localhost;dbname=learning_test;charset=utf8','root','');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$characterManager = new CharacterManager($db);

try {
    if(isset($_GET['actions'])) {
        if($_GET['actions'] == 'createOrUse') {
            if(isset($_POST['createCharacter'])) {
                $character = new Character(array(
                    'name' => $_POST['nameCharacter']
                ));

                if($characterManager->isExist($character->getName())) {
                    unset($character);
                    throw new Exception("Le nom existe déjà !");
                }

                $characterManager->add($character);
                require("View/home.php");
            }
        }
    }
    else {
        require("View/home.php");
    }
}
catch(Exception $e) {
    die("Erreur: ".$e);
}
