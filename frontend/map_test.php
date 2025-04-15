<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
include __DIR__ . '/scripts/check-services.php';

if (isset($_SESSION['username'])) {
  include 'includes/header_user.php';
} else {
  include 'includes/header_guest.php';
}
?>



<html>
<head>
  <style>
    #cubaImage {
      display: none;
      position: absolute;
      width: 300px; /* Set width to 300px */
      height: 300px; 
      z-index: 1000;
    }

    #cubaText {
      display: none;
      position: absolute;
      background-color: black; 
      color: white; 
      padding: 10px;
      font-size: 20px;
      z-index: 1001; 
    }
  </style>
</head>
<body>

<h2>Maps test</h2>

<img src="images/map.jpg" alt="Workplace" usemap="#test" width="1596" height="924">

<map name="test">
  <area shape="circle" coords="589,345,44" alt="Cuba" href="images/cuba.jpg" onmouseover="showCubaImage(event, 589, 345)" onmouseout="hideCubaImage()" id="cubaArea">
  <area shape="circle" coords="540,477,44" alt="Jamaica" href="images/jamaica.jpg" id="jamaicaArea">
</map>

<img id="cubaImage" src="images/cuba.jpg" alt="Cuba">
<div id="cubaText">Test Cuba</div>

<script>
  let cubaImageVisible = false;

  function showCubaImage(event, x, y) {
    if (!cubaImageVisible) {
      const cubaImage = document.getElementById('cubaImage');
      const cubaText = document.getElementById('cubaText');
      const imageWidth = 300; // Width of the image
      const imageHeight = 300; // Height of the image

     
      cubaImage.style.left = `${x - imageWidth / 2}px`; 
      cubaImage.style.top = `${y - imageHeight - 10}px`; 

      // Where text shows up
      cubaText.style.left = `${x - 70}px`;
      cubaText.style.top = `${y - 50}px`; 
      // Display the image and text
      cubaImage.style.display = 'block';
      cubaText.style.display = 'block';
      cubaImageVisible = true;
    }
  }

  function hideCubaImage() {
    document.getElementById('cubaImage').style.display = 'none';
    document.getElementById('cubaText').style.display = 'none';
    cubaImageVisible = false;
  }
</script>

</body>
</html>