<?php

class Character
{
    private $id, $name, $damage;

    const MYSELF = 1;
    const STRUCK = 2;
    const KILLED = 3;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data)
    {
        foreach($data as $key => $value) {
            $method = 'set'.ucfirst($key);

            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function setId($id)
    {
        $id = (int)$id;

        if($id > 0) {
            $this->id = $id;
        }
        else {
            throw new Exception("ID must be greater than 0 !");
        }
    }

    public function setName($name)
    {
        if(preg_match("#^[a-zA-Z][a-zA-Z0-9_-]{2,}$#", $name)) {
            $this->name = $name;
        }
        else {
            throw new Exception("The name '".$name."' is not valid !");
        }
    }

    public function setDamage($damage)
    {
        if($damage >= 0 && $damage < 100) {
            $this->damage = $damage;
        }
    }

    public function hit(Character $character)
    {
        if($this->id == $character->getId()) {
            return self::MYSELF;
        }

        return $character->receiveDamage();
    }

    public function receiveDamage()
    {
        $damage = (int)$this->damage;
        $damage += 5;
        
        $this->setDamage($damage);

        if($this->damage >= 100) {
            return self::KILLED;
        }
        return self::STRUCK;
    }
}
