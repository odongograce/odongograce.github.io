<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
            if(isset($page_title)){
                echo $page_title;
            }else{
                echo _SITE_TITLE;
            }
        ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header id="header">
        <div class="container ">
            <div class="logo">
                <a href="./index.php"><?php echo _SITE_TITLE; ?></a>
            </div>
            <nav>
                <ul class="nav-links flex">
                    <li><a href="./index.php" class="nav-link">Home</a></li>
                    <li><a href="./index.php#about" class="nav-link">About</a></li>
                    <li><a href="./index.php#services" class="nav-link">Services</a></li>
                    <li><a href="./index.php#contact" class="nav-link">Contact</a></li>
                    <?php
                        if(isset($_SESSION['user_id'])){
                            ?>
                                <li><a href="./appointments.php" class="nav-link">My Appointments</a></li>
                                <li><a href="./account.php" class="nav-link">Account</a></li>
                                <li><a href="./logout.php" onclick="alert('Are you sure you want to log out!')" class="nav-link cta">Logout</a></li>
                            <?php
                        }else{
                            ?>
                                <li><a href="./login.php" class="nav-link cta">Login / Sign up</a></li>
                            <?php
                        }
                    ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
