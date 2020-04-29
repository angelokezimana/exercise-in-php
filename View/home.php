<?php ob_start(); ?>

<?php 
if(isset($character)) {
    $characters = $characterManager->getList($character->getName());

    $characterInUSe = new Character($characterManager->getOne($character->getName()));

    echo "<p>My Information:</p>";

    echo "Name: ".$characterInUSe->getName()."<br>Damage: ".$characterInUSe->getDamage();

    echo "<p>People to hit:</p>";

    if(empty($characters)) {
        echo "<p>No one to hit !</p>";
    }

    foreach($characters as $character) {
        echo "<p>
            <a href='".$_SERVER['PHP_SELF']."?actions=hit&id=".$character->getId()."'>".$character->getName()."</a>
            </p>";
    }
}
else {
    
    if(isset($error)) {
        echo $error;
    }
    ?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>?actions=createOrUse" method="post">
        <label for="nameCharacter">Nom:</label>
        <input type="text" name="nameCharacter" id="nameCharacter" <?php
            if(isset($error)) echo "value='".$_POST['nameCharacter']."'";  ?> >
        <input type="submit" value="Cr&eacute;er" name="createCharacter">
        <input type="submit" value="Utiliser" name="useCharacter">
    </form>

    <?php 
}
$content = ob_get_clean(); 
require("template.php");
?>