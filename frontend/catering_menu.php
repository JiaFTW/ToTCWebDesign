<head>
  <link rel="stylesheet" href="css/gstyles.css">
</head>
<div class="container py-5 catering-wrapper">
  <h1 class="catering-title">Catering Menu</h1>
  <div id="catering-grid" class="row"></div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
  $(function(){
      const url = '/backend/api/get_menu.php?category=Catering';

      $.getJSON(url)
        .done(items => {
          const $grid = $('#catering-grid').empty();

          if (!items.length) {
            return $grid.html(`
              <div class="col-12" style="text-align:center; color:#777;">
                No catering items available at the moment.
              </div>
            `);
          }

          items.forEach(i => {
            $grid.append(`
              <div class="col-md-4 mb-4">
                <a href="item.php?item_id=${i.item_id}" class="text-decoration-none text-dark">
                  <div class="card h-100">
                    <img src="/images/${i.image_name}" 
                         class="card-img-top" 
                         alt="${i.item_name}">
                    <div class="card-body">
                      <h5 class="card-title">${i.item_name}</h5>
                      <p class="card-text">${i.description}</p>
                    </div>
                    <div class="card-footer" style="text-align:right;">
                      <strong>$${parseFloat(i.price).toFixed(2)}</strong>
                    </div>
                  </div>
                </a>
              </div>
            `);
          });
        })
        .fail(() => {
          $('#catering-grid').html(`
            <div class="col-12" style="text-align:center; color:#A30000;">
              Unable to load catering items. Please try again later.
            </div>
          `);
        });
  });
</script>
