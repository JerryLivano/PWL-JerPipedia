<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['registered_user'])) {
        $_SESSION['registered_user'] = false;
    }
    include_once 'db_utility/user_function.php';
    include_once 'db_utility/util_function.php';
    include_once 'db_utility/genre_function.php';
    include_once 'db_utility/book_function.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JerPipedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
    if ($_SESSION['registered_user']) {
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="padding-left: 30px;">
        <img src="asset/jerpip.png" width="50" alt="">
        <a class="navbar-brand ms-2">Jer<span style="color: #F9004D;">Pipedia</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="?menu=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?menu=book">Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?menu=genre">Genre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?menu=logout">Logout</a>
                </li>
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li> -->
            </ul>
        </div>
    </nav>
    <div class="container mt-3">

    </div>
    <main>
        <?php
            $navigation = filter_input(INPUT_GET, 'menu');
            switch ($navigation) {
                case 'home':
                    include_once 'pages/home.php';
                    break;
                case 'genre':
                    include_once 'pages/genre.php';
                    break;
                case 'book':
                    include_once 'pages/book.php';
                    break;
                case 'genre_update':
                    include_once 'pages/genre_edit.php';
                    break;
                case 'book_update':
                    include_once 'pages/book_edit.php';
                    break;
                case 'image':
                    include_once 'pages/image.php';
                    break;
                case 'logout':
                    session_unset();
                    session_destroy();
                    header('location:index.php');
                    break;
                default:
                    include_once 'pages/home.php';
                    break;
            }
        ?>
    </main>
    <?php
    } else {
        include_once 'pages/login.php';
    }
    ?>
</body>
</html>
