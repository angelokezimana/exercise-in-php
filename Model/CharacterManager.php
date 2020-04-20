<?php

class CharacterManager
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;

    }

    public function add(Character $character)
    {
        $request = $this->db->PREPARE("INSERT INTO characters(name) VALUES (:name)");
        $request->execute(array(
            ':name'=>$character->getName()
        ));

        $character->hydrate(array(
            'id' => $this->db->lastInsertId(),
            'damage' => 0
        ));
    }

    public function edit(Character $character)
    {
        $request = $this->db->PREPARE("UPDATE characters INTO damage=:damage WHERE id=:id");
        $request->execute(array(
            ':damage'=>$character->getDamage(),
            ':id'=>$character->getId()
        ));
    }

    public function delete(Character $character)
    {
        $request = $this->db->PREPARE("DELETE FROM characters WHERE id=:id");
        $request->execute(array(
            ':id'=>$character->getId()
        ));
    }

    public function isExist($character)
    {
        if(is_int($character)) {
            $request = $this->db->PREPARE("SELECT * FROM characters WHERE id=:id");
            $request->execute(array(
                ':id'=>$character
            ));

            $data = $request->fetchAll();

            return (bool)$data;
        }
        $request = $this->db->PREPARE("SELECT * FROM characters WHERE name=:name");
        $request->execute(array(
            ':name'=>$character
        ));

        $data = $request->fetchAll();

        return (bool)$data;
    }

    /*public function isNameValid($character)
    {
        $request = $this->db->PREPARE("SELECT * FROM characters WHERE nom=:nom");
        $request->execute(array(
            ':nom'=>$character
        ));

        $data = $request->fetch();

        return (bool)$data;
    }*/


    public function getOne($character)
    {
        if(is_int($character)) {
            $request = $this->db->PREPARE("SELECT * FROM characters WHERE id=:id");
            $request->execute(array(
                ':id'=>$character
            ));

            return new Character($request->fetch());
        }
        $request = $this->db->PREPARE("SELECT * FROM characters WHERE nom=:nom");
        $request->execute(array(
            ':nom'=>$character
        ));

        return new Character($request->fetch());
    }

    public function getList($name)
    {
        $characters = array();
        $request = $this->db->PREPARE("SELECT * FROM characters WHERE name <> :name");
        $request->execute(array(
            ':name' => $name
        ));

        while($data = $request->fetch()) {
            $characters[] = new Character($data);
        }

        return $characters;
    }

    public function countCharacter():int
    {
        $request = $this->db->query("SELECT * FROM characters");
        
        return $request->rowCount();
    }
}