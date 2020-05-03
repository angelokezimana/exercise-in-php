<?php

require("config.php");

class CharacterController
{
    private $characterManager;

    public function __construct(CharacterManager $characterManager)
    {
        $this->setCharacterManager($characterManager);
    }

    public function setCharacterManager(CharacterManager $characterManager)
    {
        $this->characterManager = $characterManager;
    }

    public function getCharacter(Character $character)
    {
        return new Character($this->characterManager->getOne($character->getName()));
    }

    public function getCharacters(Character $character)
    {
        return $this->characterManager->getList($character->getName());
    }

    public function numberCharacters()
    {
        return $this->characterManager->countCharacter();
    }

    public function create(Character $character)
    {
        if($this->characterManager->isExist($character->getName())) {
            
            throw new Exception("Name already exist !");
        }

        $this->characterManager->add($character);
        require("config.php");
        require("View/home.php");
    }

    public function use(Character $character)
    {
        if($this->characterManager->isExist($character->getName())) {
                    
            $character->hydrate($this->characterManager->getOne($character->getName()));
            require("config.php");
            require("View/home.php");
        }
        else {
            
            throw new Exception("The character entered does not exist !");
        }
    }

    public function hit(Character $character, $name)
    {
        if($this->characterManager->isExist($name)) {

            $characterHitted = new Character($this->characterManager->getOne($name));
            $returnValue = $character->hit($characterHitted);
            if($returnValue == Character::MYSELF) {
                
                throw new Exception("You cannot hit yourself !");
            }
            elseif($returnValue == Character::KILLED || $returnValue == Character::STRUCK) {
                
                $this->characterManager->edit($characterHitted);
                $info = ($characterHitted->getDamage() >= 100) ? 
                    $characterHitted->getName()." is killed !" : $characterHitted->getName()." is struck !";

                require("config.php");
                require("View/home.php");
            }
        }
        else {
            
            throw new Exception("The name does not exist !");
        }
    }
}
