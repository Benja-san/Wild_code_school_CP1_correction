<?php
require_once __DIR__ . "/../src/functions.php";
require_once __DIR__ . "/../src/briberyForm.php";

//Get all names and payents, then order'em by name
//check if GET array
if($_GET){
    $bribes = getBribesByLetter($_GET["letter"]);
} else {
    $bribes = getBribes();
}
usort($bribes, function ($name1, $name2) {
    return $name1['name'] <=> $name2['name'];
});

//initialize total value
$totalPayment = 0;

//Initialize alphabet array to display
$alphabeticalArray = range("a", "z");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/book.css">
    <title>Checkpoint PHP 1</title>
</head>
<body>

<?php include 'header.php'; ?>

<main class="container">

    <nav class="alphabeticalNav">
        <ul>
            <?php foreach($alphabeticalArray as $letter) : ?>
                <li>
                    <a href="/book.php?letter=<?= $letter ?>">
                        <?= $letter ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </nav>

    <section class="desktop">
        <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
        <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>

        <div class="pages">
            <div class="page leftpage">
                Add a bribe
                <form method="post">
                    <div>
                        <label for="name"> Name </label>
                        <input id="name" name="name" type="text" placeholder="Name goes here" maxlength="255"/>
                        <?php if($errors["name"]) : ?>
                            <p>
                                <?= $errors["name"] ?>
                            </p>
                        <?php endif ?>
                    </div>
                    <div>
                        <label for="payment"> Payment </label>
                        <input id="payment" name="payment" type="text" placeholder="Payment goes here" />
                        <?php if($errors["payment"]) : ?>
                            <p>
                                <?= $errors["payment"] ?>
                            </p>
                        <?php endif ?>
                    </div>
                    <button type="submit">Add bribe</button>
                </form>
            </div>

            <div class="page rightpage">
                <table class="bribesContainer">
                    <tbody>
                        <thead>
                            <tr>
                                <td>
                                    <?php if($_GET) : ?>
                                        <?= $_GET['letter'] . " :" ?>
                                    <?php else : ?>
                                        <?= "All Bribes by name" ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                        </thead>
                        <?php foreach($bribes as $bribe) : ?>
                        <tr>
                            <td><?= $bribe["name"] ?></td>
                            <td><?= $bribe["payment"] ?></td>
                        </tr>
                        <?php 
                            //Increment total value
                            $totalPayment += $bribe["payment"] 
                        ?>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><?= "Total : $totalPayment" ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <img src="image/inkpen.png" alt="an ink pen" class="inkpen" id="inkpen"/>
    </section>
</main>
</body>
</html>
