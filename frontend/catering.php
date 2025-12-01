<?php
// frontend/catering.php
session_start();
include __DIR__ . '/scripts/check-services.php';

// Determine which sub-section to show
$view = $_GET['view'] ?? 'menu'; // default = Catering Menu
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Catering • Taste of the Caribbean</title>

    <link rel="stylesheet" href="css/gstyles.css">
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Faculty+Glyphic&display=swap">
</head>

<body>

<?php
// Load correct header
if (isset($_SESSION['username'])) {
    include __DIR__ . '/includes/header_user.php';
} else {
    include __DIR__ . '/includes/header_guest.php';
}
?>

<div class="main-content">

    <!-- SUB-TAB NAV (IDENTICAL TO MENU CATEGORY NAV) -->
    <nav class="category-nav">
        <a href="catering.php?view=menu"
            class="<?= ($view === 'menu') ? 'active' : '' ?>">
            Catering Menu
        </a>

        <a href="catering.php?view=request"
            class="<?= ($view === 'request') ? 'active' : '' ?>">
            Catering Request
        </a>
    </nav>

    <!-- CONTENT AREA -->
    <div class="container py-4" >
<?php
echo "<!-- View: $view -->";

if ($view === 'menu') {
    echo "<!-- Loading Catering Menu -->";
    include __DIR__ . '/catering_menu.php';

} else if ($view === 'request') {
    echo "<!-- Loading Catering Request -->";
    include __DIR__ . '/catering_request.php';

} else {
    echo "<p class='text-danger'>Unknown view.</p>";
}
?>
</div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
