<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?=$title?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="jokes.css" rel="stylesheet">
    </head>
    <body>
        <header><h1>Internet Joke Database</h1></header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="jokes.php">Joke List</a></li>
                <li><a href="addjoke.php">Add new joke</a></li>
            </ul>
        </nav>
        <main>
            <?=$output?>
        </main>
        <footer>
            &copy; IJDB2023
        </footer>
    </body>
</html>
