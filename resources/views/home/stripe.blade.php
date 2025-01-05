<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .payment-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            gap: 20px;
        }
        .summary-section {
            background-color: #232a34;
            color: white;
            padding: 20px;
            border-radius: 10px;
            width: 30%;
        }
        .summary-section h5 {
            margin-bottom: 10px;
        }
        .summary-item {
            margin-bottom: 15px;
        }
        .summary-item span {
            display: block;
            font-size: 0.9rem;
            color: #a7b1c0;
        }
        .total-price {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #ff6b6b;
        }
        .total-price h4 {
            color: #ff6b6b;
        }
        .form-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-section h5 {
            margin-bottom: 20px;
        }
        .payment-icons img {
            width: 50px;
            margin-right: 10px;
        }
        .btn-submit {
            background-color: #ff6b6b;
            color: white;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #e05656;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        
            
       
        <!-- Payment Summary -->
        <div class="summary-section">
            <h5>Payment Summary</h5>
            @foreach ($carts as $cart)
            <div class="summary-item">
                <strong>{{ $cart->product_title }}</strong>
                <span style="color: red">${{ $cart->price }}</span>
                <span>{{ $cart->created_at->format('Y-m-d H:i:s') }}</span>
            </div>
            @endforeach

            <div class="total-price">
                <h4>Total Price: ${{ $totalprice }}</h4>
                <p>Price includes all taxes</p>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="form-section">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <button class="close" type="button" aria-hidden="true" data-dismiss="alert">x</button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            <h5>Payment Method</h5>
            <div class="payment-icons">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6a/Mastercard-logo.svg" alt="MasterCard">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">
            </div>
            <form 
                action="{{ route('stripe.post',$totalprice) }}" 
                method="post" 
                class="require-validation" 
                data-cc-on-file="false"
                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                id="payment-form">
                @csrf

                <div class='form-row row'>
                    <div class='col-xs-12 form-group required'>
                        <label class='control-label'>Name on Card</label>
                        <input class='form-control' name="name" size='4' type='text' required>
                    </div>
                </div>

                <div class='form-row row'>
                    <div class='col-xs-12 form-group card required'>
                        <label class='control-label'>Card Number</label>
                        <input autocomplete='off' class='form-control card-number' name="card_number" size='20' type='text' required>
                    </div>
                </div>

                <div class='form-row row'>
                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                        <label class='control-label'>CVC</label>
                        <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' name="cvc" type='text' required>
                    </div>
                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                        <label class='control-label'>Expiration Month</label>
                        <input class='form-control card-expiry-month' placeholder='MM' size='2' name="exp_month" type='text' required>
                    </div>
                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                        <label class='control-label'>Expiration Year</label>
                        <input class='form-control card-expiry-year' placeholder='YYYY' size='4' name="exp_year" type='text' required>
                    </div>
                </div>

                <div class='form-row row'>
                    <div class='col-md-12 error form-group hide'>
                        <div class='alert-danger alert'>Please correct the errors and try again.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <button class="btn btn-submit btn-lg btn-block" type="submit">Pay Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');
    
        const form = document.getElementById('payment-form');
    
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const { paymentMethod, error } = await stripe.createPaymentMethod('card', card);
    
            if (error) {
                // Display error.message in #card-errors
                document.getElementById('card-errors').textContent = error.message;
            } else {
                // Append the payment method ID to the form and submit
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method_id');
                hiddenInput.setAttribute('value', paymentMethod.id);
                form.appendChild(hiddenInput);
    
                form.submit();
            }
        });
    </script>
</body>
</html>
