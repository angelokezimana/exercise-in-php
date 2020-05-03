<?php ob_start(); ?>

<?php
if(isset($error)) {
    echo "<p class='bg-danger text-center text-light'>".$error."</p>";
}

if (isset($info)) {
    echo "<p class='bg-success text-center text-light'>".$info."</p>";
}

if(isset($character)) {
    
    $characters = $characterController->getCharacters($character);

    $characterInUSe = $characterController->getCharacter($character);

    ?>
    <div class='row'>
        
        <h2 class='col-md-4'>My Information:</h2>
        <div class='col-md-8 text-right'><a href='?logout' class='btn btn-primary btn-lg'>Logout</a></div>

    </div>

    <table class='table table-bordered'>

        <thead>
            <tr>
                <th>Name</th>
                <th>Damage</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars($characterInUSe->getName()) ?></td>
                <td><?= $characterInUSe->getDamage() ?></td>
            </tr>
        </tbody>

    </table>

        <h2>People to hit:</h2>
    
    <?php

    if(empty($characters)) {
        echo "<p class='bg-info text-center text-light'>No one to hit !</p>";
    }
    else {
        echo "<table class='table table-bordered'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Damage</th>
                </tr>
            </thead>
            <tbody>";

        foreach($characters as $oneCharacter) {
            echo "<tr>
                    <td><a href='?actions=hit&name=".htmlspecialchars($oneCharacter->getName())."' class='btn btn-outline-primary'>".htmlspecialchars($oneCharacter->getName())."</a></td>
                    <td>".$oneCharacter->getDamage()."</td>
                    </tr>";
        }
        echo "</tbody></table>";
    }
}
else {
    
    ?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>?actions=createOrUse" method="post" class="form-inline">
        
        <label for="nameCharacter" class="mr-sm-2">Nom:</label>
        <input type="text" name="nameCharacter" class="form-control mr-sm-2" id="nameCharacter" <?php
            if(isset($_POST['nameCharacter'])) echo "value='".$_POST['nameCharacter']."'";  ?> >
        <input type="submit" value="Create" name="createCharacter" class="btn btn-primary btn-sm mr-sm-2">
        <input type="submit" value="Use" name="useCharacter" class="btn btn-primary btn-sm">
       
    </form>

    <?php 
}
$content = ob_get_clean(); 
require("template.php");
?>