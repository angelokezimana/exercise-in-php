<?php ob_start(); ?>

<?php 
if(isset($character)) {
    $characters = $characterManager->getList($character->getName());

    echo "<p>Les personnes &agrave; frapper:</p>";

    foreach($characters as $character) {
        echo "<p>".$character->getName()."</p>";
    }
}
else {
    ?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>?actions=createOrUse" method="post">
        <label for="nameCharacter">Nom:</label>
        <input type="text" name="nameCharacter" id="nameCharacter">
        <input type="submit" value="Cr&eacute;er" name="createCharacter">
        <input type="submit" value="Utiliser" name="useCharacter">
    </form>

    <?php 
}
$content = ob_get_clean(); 
require("template.php");
?>