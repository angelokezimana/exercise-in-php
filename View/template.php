<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Game in PHP</title>
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <p class="bg-secondary text-white text-center"> 
                Number of characters:
                <?= $characterController->numberCharacters() ?>
            </p>

            <div class="bg-light">
                
                <?= $content ?>
            </div>
        </div>
    </div>
    <div class='text-center'>
        Made by <a href='https://angelokezimana.carrd.co/' class='btn btn-link'>k.a.a</a> with ❤️.
    </div>
</body>
</html>