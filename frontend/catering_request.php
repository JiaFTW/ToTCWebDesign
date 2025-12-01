<div class="catering-form-wrapper">

    <!-- Header bar -->
    <div class="catering-header-bar">
        <h2>Contact Us for Catering</h2>
        <p>Let us cater your next event! Submit your request and we’ll get back to you within 1–2 business days.</p>
    </div>

    <!-- Form container -->
    <div class="catering-form-box">
        <form action="/backend/api/send_catering_request.php" method="POST">

            <label>Your First Name:</label>
            <input type="text" name="first_name" required>

            <label>Your Last Name:</label>
            <input type="text" name="last_name" required>

            <label>Your Email:</label>
            <input type="email" name="email" required>

            <label>Your Phone Number:</label>
            <input type="text" name="phone" required>

            <label>Event Date:</label>
            <input type="date" id="event_date" name="event_date" required>

            <label>Order Details:</label>
            <textarea name="details" required></textarea>

            <button type="submit" class="catering-submit-btn">Submit Request</button>

        </form>
    </div>
</div>

<!-- AUTO +2 DAYS DATE LOGIC -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById("event_date");

    function setMinDate() {
        let d = new Date();
        d.setDate(d.getDate() + 2);

        let year = d.getFullYear();
        let month = ("0" + (d.getMonth() + 1)).slice(-2);
        let day = ("0" + d.getDate()).slice(-2);

        let formatted = `${year}-${month}-${day}`;
        dateInput.min = formatted;
        dateInput.value = formatted;
    }

    setMinDate();

    dateInput.addEventListener("change", () => {
        if (new Date(dateInput.value) < new Date(dateInput.min)) {
            setMinDate();
        }
    });
});
</script>

<!-- MATCH EXACT CONTACT PAGE STYLE -->
<style>
/* Wrapper centers everything */
.catering-form-wrapper {
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    margin-top: 20px;
    margin-bottom: 50px;
}

/* Teal header bar */
.catering-header-bar {
    background: var(--teal);
    color: var(--white);
    padding: 30px;
    border-radius: 10px 10px 0 0;
}

.catering-header-bar h2 {
    font-size: 32px;
    font-weight: 700;
    margin: 0 0 10px 0;
}

.catering-header-bar p {
    margin: 0;
    font-size: 18px;
}

/* Beige form box identical to contact form */
.catering-form-box {
    background: var(--beige);
    border-radius: 0 0 10px 10px;
    padding: 40px;
    border: 1px solid #e5d3b0;
}

/* Inputs styled identical to Contact Us */
.catering-form-box label {
    font-weight: 600;
    color: var(--text);
    margin-top: 15px;
}

.catering-form-box input,
.catering-form-box textarea {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border: 2px solid #f2dcb8;
    border-radius: 8px;
    font-size: 16px;
    background: #fff;
}

.catering-form-box textarea {
    height: 140px;
    resize: vertical;
}

/* Submit button same as contact page */
.catering-submit-btn {
    margin-top: 20px;
    background: var(--teal);
    color: white;
    padding: 12px 25px;
    border: none;
    font-size: 18px;
    font-weight: 600;
    border-radius: 30px;
    cursor: pointer;
}

.catering-submit-btn:hover {
    background: #006973;
}
</style>
