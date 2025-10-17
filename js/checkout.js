// frontend/js/checkout.js
(async () => {
    const form = document.getElementById('payment-form');
    const msgEl = document.getElementById('payment-message');
  
    // 1) Create PaymentIntent on the backend
    const {clientSecret} = await fetch('/backend/api/create_payment_intent.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({total: <?= json_encode($total) ?>})
    }).then(r=>r.json());
  
    // 2) Mount Stripe Element
    const elements = stripe.elements();
    const cardEl = elements.create('card');
    cardEl.mount('#card-element');
  
    // 3) Handle form submit
    form.addEventListener('submit', async e => {
      e.preventDefault();
      const {error, paymentIntent} = await stripe.confirmCardPayment(clientSecret, {
        payment_method: {card: cardEl}
      });
      if (error) {
        msgEl.textContent = error.message;
        msgEl.classList.remove('hidden');
      } else if (paymentIntent.status === 'succeeded') {
        window.location.href = '/confirmation.php';
      }
    });
  })();
  