<?php

$db = new PDO('mysql:host=localhost;dbname=learning_test;charset=utf8','root','');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$characterManager = new CharacterManager($db);
$characterController = new CharacterController($characterManager);
