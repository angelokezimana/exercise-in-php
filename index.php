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

session_start();

if(isset($_GET['logout'])) {
    session_destroy();
    header("Location:.");
    exit();
}

if(isset($_SESSION['character'])) {
    $character = $_SESSION['character'];
}

$db = new PDO('mysql:host=localhost;dbname=learning_test;charset=utf8','root','');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$characterManager = new CharacterManager($db);

try {
    if(isset($_GET['actions'])) {
        if($_GET['actions'] == 'createOrUse' && isset($_POST['nameCharacter'])) {

            $character = new Character(array(
                'name' => $_POST['nameCharacter']
            ));

            if(isset($_POST['createCharacter'])) {

                if($characterManager->isExist($character->getName())) {
                    unset($character);
                    throw new Exception("Name already exist !");
                }

                $characterManager->add($character);
                require("View/home.php");
            }
            elseif(isset($_POST['useCharacter'])) {

                if($characterManager->isExist($character->getName())) {
                    
                    $character->hydrate($characterManager->getOne($character->getName()));
                    require("View/home.php");
                }
                else {
                    
                    unset($character);
                    throw new Exception("The character entered does not exist !");
                }
            }

            $_SESSION['character'] = $character;
        }
        elseif($_GET['actions'] == 'hit' && isset($_GET['name'])) {
            if($characterManager->isExist($_GET['name'])) {

                $characterHitted = new Character($characterManager->getOne($_GET['name']));
                $returnValue = $character->hit($characterHitted);
                if($returnValue == Character::MYSELF) {
                    
                    throw new Exception("You cannot hit yourself !");
                }
                elseif($returnValue == Character::KILLED || $returnValue == Character::STRUCK) {
                    
                    $characterManager->edit($characterHitted);
                    $info = ($characterHitted->getDamage() >= 100) ? 
                        $characterHitted->getName()." is killed !" : $characterHitted->getName()." is struck !";
                    require("View/home.php");
                }
            }
            else {
                
                throw new Exception("The name does not exist !");
            }
        }
        else {
            
            require("View/home.php");
        }
    }
    else {
        
        require("View/home.php");
    }
}
catch(Exception $e) {
    
    $error = $e->getMessage();
    require("View/home.php");
}
