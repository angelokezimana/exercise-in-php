<?php ob_start(); ?>

<?php
if(isset($error)) {
    echo $error;
}

if (isset($info)) {
    echo $info;
}

if(isset($character)) {
    
    $characters = $characterController->getCharacters($character);

    $characterInUSe = $characterController->getCharacter($character);

    echo "<p>My Information:</p>

        <p><a href='?logout'>Logout</a></p>

        <p>Name: ".htmlspecialchars($characterInUSe->getName())."<br>Damage: ".$characterInUSe->getDamage()."</p>

        <p>People to hit:</p>";

    if(empty($characters)) {
        echo "<p>No one to hit !</p>";
    }

    foreach($characters as $oneCharacter) {
        echo "<p>
            <a href='".$_SERVER['PHP_SELF']."?actions=hit&name=".htmlspecialchars($oneCharacter->getName())."'>".htmlspecialchars($oneCharacter->getName())."</a>
            </p>";
    }
}
else {
    
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