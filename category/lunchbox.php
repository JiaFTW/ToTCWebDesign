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
            <div class="categorygrid">
                <div class="headcategory">
                    <p class="headname">Meat</p>
                    <div class="dineinitems">
                        <div class="fooditem">
                            <p>Chicken Salad</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Bacon</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Turkey</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Roast Beef</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Ham</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Salami</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Tuna</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Pastrami</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Jerk Chicken</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                    </div>
                </div>
                <div class="headcategory">
                    <p class="headname">Cheese</p>
                    <div class="dineinitems">
                        <div class="fooditem">
                            <p>American</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Cheddar</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Cream Cheese</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Feta Cheese</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Goat Cheese</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Havarti</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Provolone</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Swiss</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                    </div>
                </div>
                <div class="headcategory">
                    <p class="headname">Vegetables</p>
                    <div class="dineinitems">
                        <div class="fooditem">
                            <p>Avocado</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Cucumber</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Lettuce</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Marinated Grilled Vegetables</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Marimated Mushrooms</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>PB & J</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Pepperoncini</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Pickle</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                    </div>
                </div>
                <div class="headcategory">
                    <p class="headname">Salads</p>
                    <div class="dineinitems">
                        <div class="fooditem">
                            <p>Arugula</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Caesar</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Coleslaw</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Fruit Salad</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Mixed Greens</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Spinach</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                    </div>
                </div>
                <div class="headcategory">
                    <p class="headname">Breads/Wrap</p>
                    <div class="dineinitems">
                        <div class="fooditem">
                            <p>9-Grain</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Hoagle</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Rye</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Sourdough</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Tomato Basil</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>White</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Wrap Chili Lime</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Whrap Garlic and Herb</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Wrap Gluten Free</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Wrap Sun-Dried Tomato Basil</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Wrap Whole Wheat</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                    </div>
                </div>
                <div class="headcategory">
                    <p class="headname">Salad Dressing</p>
                    <div class="dineinitems">
                        <div class="fooditem">
                            <p>Ceasar Dressing</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Italian Dressing</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Italian Dressing Lite</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Balsamic Vinaigrette</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Balsamic</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Raspberry Lite</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Italian Dressing Fat-Free</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Raspberry Vinaigrette Fat-Free</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                        <div class="fooditem">
                            <p>Caribbean Mango Vinaigrette</p>
                            <div class="plus"><img src="../images/Plus_Sign.png"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>