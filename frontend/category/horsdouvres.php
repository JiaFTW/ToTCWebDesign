<?php
session_start();
if (isset($_SESSION['username'])) {
  include '../includes/header_user.php';
} else {
  include '../includes/header_guest.php';
}
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <title>Taste of the Carribean</title>
        <link rel="stylesheet" href="../css/category.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
    </head>
    <body> 
        <!-- <div class="navbar">
            <ul>
                <div class="nav-left">
                    <li><img src="../images/TOC_Logo.png" /></li>
                    <li><a href="#home"><h1>Taste of the Caribbean<h1></a></li>
                </div>
                <div class="nav-right">
                    <li><a href="home.html">Home</a></li>
                    <li><a href="#contact">Catering</a></li>
                    <li><a href="#about">Hours and Location</a></li>
                    <li><a href="#about">About</a></li>
                </div>
            </ul>
        </div> -->

        <div>
            <a class="return" href="../menu.html">Back to selecting Categories?</a>
            <div class="categoryid">
                <div class="horsitems">
                    <div class="fooditem">
                        <p>Jerk Meatballs</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Coconut Shrimp</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Cocktail Beef Patty</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Cocktail Vegetablle Patty</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Cocktail Beef Empanadas</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Cocktail Chicken Empanadas</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Charcuterie Cups</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Fruit Cups</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Grilled Fig & Goat Cheese Crostini</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Jerk Chicken Wings</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Tropical Chicken Wings</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Impossible Meatballs</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Slab Bacon Skewer with Vanilla bourbon sauce</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Calzone Cheese</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                    <div class="fooditem">
                        <p>Short Rib and Roquefort Hand Pie</p>
                        <div class="plus"><img src="../images/Plus_Sign.png"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>