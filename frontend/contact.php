<?php
session_start();

// Check critical services FIRST (before anything else that depends on them)
include __DIR__ . '/scripts/check-services.php';

// Display form status messages if they exist
$formStatus = $_SESSION['form_status'] ?? '';
$formMessage = $_SESSION['form_message'] ?? '';
$formData = $_SESSION['form_data'] ?? [];

// Clear the session variables
unset($_SESSION['form_status']);
unset($_SESSION['form_message']);
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Taste of the Carribean</title>
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/navbar.css">
	<link rel="stylesheet" href="css/global.css">
	<link rel="stylesheet" href="css/footer.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,900;1,9..40,900&family=Faculty+Glyphic&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	
  </head>
  <body>
	<?php
		if (isset($_SESSION['username'])) {
			include __DIR__.'/includes/header_user.php';
		} else {
			include __DIR__.'/includes/header_guest.php';
		}
	?>

  	<div class="main-content">
		<h1>Catering</h1>
		<p>Let us cater your next big event! Send in a inquiry and we'll get back to you within 1-2 business days.</p>
		
		<?php if ($formStatus): ?>
			<div class="form-message <?php echo $formStatus; ?>">
				<?php echo $formMessage; ?>
			</div>
		<?php endif; ?>

		<div class="container">
			<form id="orderForm" action="scripts/process-catering.php" method="POST">
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="firstName" class="required">First Name</label>
							<input type="text" id="firstName" name="firstName" required 
								value="<?php echo htmlspecialchars($formData['firstName'] ?? ''); ?>">
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label for="lastName" class="required">Last Name</label>
							<input type="text" id="lastName" name="lastName" required
								value="<?php echo htmlspecialchars($formData['lastName'] ?? ''); ?>">
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="email" class="required">Email Address</label>
					<input type="email" id="email" name="email" required 
						pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
						value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>">
				</div>
				
				<div class="form-group">
					<label for="phone">Phone Number</label>
					<input type="tel" id="phone" name="phone" required
						value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>">
				</div>
				
				<div class="form-group">
					<label for="eventDate">Event Date</label>
					<input type="date" id="eventDate" name="eventDate"
						value="<?php echo htmlspecialchars($formData['eventDate'] ?? ''); ?>">
				</div>
				
				<div class="form-group">
					<label for="orderDetails" class="required">Order Details</label>
					<textarea id="orderDetails" name="orderDetails" 
							placeholder="Please specify what you would like to order and the quantities..." 
							required><?php echo htmlspecialchars($formData['orderDetails'] ?? ''); ?></textarea>
				</div>
				
				<div class="form-footer">
					<button type="submit" class="btn">Submit Order</button>
					<p class="notification">Fields marked with <span style="color:#e74c3c">*</span> are required</p>
				</div>
			</form>
		</div>
	</div>	
		<?php include __DIR__.'/includes/footer.php'; ?>

	<script>
		document.getElementById('orderForm').addEventListener('submit', function(e) {
			// Client-side validation
			const firstName = document.getElementById('firstName').value.trim();
			const lastName = document.getElementById('lastName').value.trim();
			const email = document.getElementById('email').value.trim();
			const phone = document.getElementById('phone').value.trim();
			const orderDetails = document.getElementById('orderDetails').value.trim();
			
			if (!firstName || !lastName || !email || !phone || !orderDetails) {
				e.preventDefault();
				alert('Please fill in all required fields.');
				return false;
			}
			
			// Validate email format
			const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
			if (!emailRegex.test(email)) {
				e.preventDefault();
				alert('Please enter a valid email address.');
				return false;
			}
		});
	</script>

</body>
</html>