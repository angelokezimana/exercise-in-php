<?php

class Character
{
    private $id, $name, $damage;

    const MYSELF = 1;
    const HITTED = 2;
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
            throw new Exception("L'id doit être supérieur à 0");
        }
    }

    public function setName($name)
    {
        if(!empty($name) && is_string($name)) {
            $this->name = $name;
        }
        else {
            throw new Exception("Le nom n'est pas valide");
        }
    }

    public function setDamage($damage)
    {
        $damage = (int)$damage;

        if($damage >= 0 && $damage < 100) {
            $this->damage = $damage;
        }
    }

    public function hit(Character $character)
    {
        if($this->id == $character->id) {
            return self::MYSELF;
        }

        return $character->receiveDamage();
    }

    public function receiveDamage()
    {
        $this->damage += 5;

        if($this->damage >= 100) {
            return self::KILLED;
        }
        return self::HITTED;
    }
}