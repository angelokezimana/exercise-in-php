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

require("config.php");

try {
    if(isset($_GET['actions'])) {
        if($_GET['actions'] == 'createOrUse' && isset($_POST['nameCharacter'])) {

            $character = new Character(array(
                'name' => $_POST['nameCharacter']
            ));

            if(isset($_POST['createCharacter'])) {

                $characterController->create($character);
            }
            elseif(isset($_POST['useCharacter'])) {

                $characterController->use($character);
            }

            $_SESSION['character'] = $character;
        }
        elseif($_GET['actions'] == 'hit' && isset($_GET['name'])) {
            
            if(isset($character)) {

                $characterController->hit($character, $_GET['name']);
            }
            else {
                throw new Exception("you have to log in to hit someone !");
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
    
    unset($character);
    $error = $e->getMessage();
    require("View/home.php");
}
