<?php
// frontend/menu2.php
session_start();
include __DIR__.'/scripts/check-services.php';

if (isset($_SESSION['username'])) {
  include __DIR__.'/includes/header_user.php';
} else {
  include __DIR__.'/includes/header_guest.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Our Menu • Taste of the Caribbean</title>
  <link 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384‑…" crossorigin="anonymous">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/menu2.css">
</head>
<body>
  <div class="container py-5">
    <h1 class="display-4 mb-4">Our Menu</h1>
    <div id="menu-grid" class="row"></div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
          integrity="sha256‑…" crossorigin="anonymous"></script>
  <script>
    $(function(){
      $.getJSON('/backend/api/get_menu.php')
        .done(function(items){
          const $grid = $('#menu-grid').empty();
          items.forEach(function(i){
            $grid.append(`
              <div class="col-md-4 mb-4">
                <div class="card h-100">
                  <img src="${i.image_url}" class="card-img-top" alt="${i.item_name}">
                  <div class="card-body">
                    <h5 class="card-title">${i.item_name}</h5>
                    <p class="card-text">${i.description}</p>
                  </div>
                  <div class="card-footer text-right">
                    <strong>$${parseFloat(i.price).toFixed(2)}</strong>
                  </div>
                </div>
              </div>
            `);
          });
        })
        .fail(function(){
          $('#menu-grid').html(
            '<div class="col-12 text-danger">Unable to load menu. Please try again later.</div>'
          );
        });
    });

  </script>
</body>
</html>
