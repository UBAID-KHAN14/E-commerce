<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{asset('extra/css/bootstrap.css')}}" />
      <!-- font awesome style -->
      <link href="{{asset('extra/css/font-awesome.min.css')}}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{asset('extra/css/style.css')}}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{asset('extra/css/responsive.css')}}" rel="stylesheet" />
      <style>
        .table-container {
          margin: 50px auto;
          max-width: 900px;
          border-radius: 10px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          overflow: hidden;
        }
        .table th {
          background-color: #023047;
          color: #fff;
          text-align: center;
        }
        .table td {
          vertical-align: middle;
          text-align: center;
        }
        .btn-remove {
          background-color: #d90429;
          color: #fff;
        }
        .btn-remove:hover {
          background-color: #bf021e;
          color: #fff;
        }
      </style>
   </head>
   <body>
      <div class="hero_area">

         <!-- header section strats -->
        @include('home.header');
         <!-- end header section -->

         <div class="container">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ session::get('success') }}
                </div>
            @endif
         </div>
       

         <div class="container table-container">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Product Title</th>
                        <th>Product Quantity</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalprice = 0; @endphp
                    @foreach ($carts as $cart)
                        @isset($cart->product_title)
                            @php $totalprice += $cart->price; @endphp
                            <tr>
                                <td>{{ $cart->product_title }}</td>
                                <td>{{ $cart->quantity }}</td>
                                <td>${{ $cart->price }}</td>
                                <td>
                                    <img src="/uploads/products/{{ $cart->image }}" class="rounded" alt="Product Image" style="width:200px">
                                </td>
                                <td>
                                    <a href="{{ url('remove_cart',$cart->id) }}" onclick="return confirm('Are you sure?')">
                                    <button class="btn btn-remove btn-sm">Remove</button>
                                </a>
                                </td>
                            </tr>
                        @endisset
                    @endforeach
                </tbody>
            </table>
            <!-- Display the total price -->
            <div class="total_deg mt-3">
                <h1>Total Price: ${{ $totalprice }}</h1>
            </div>
        </div>

        <div class="container text-center my-5">
            <div class="row g-3 justify-content-center">
                <div class="col-md-4">
                    <a href="{{ url('stripe',$totalprice) }}">
                        <button class="btn btn-primary btn-lg w-100 shadow-sm">
                            <i class="bi bi-bag-fill me-2"></i> Payment On Card
                        </button>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ url('check_order') }}">
                        <button class="btn btn-success btn-lg w-100 shadow-sm">
                            <i class="bi bi-cash-coin me-2"></i> Cash On Delivery
                        </button>
                    </a>
                </div>
            </div>
        </div>
        
        

      
      
      <!-- arrival section -->


      <!-- footer start -->
      @include('home.footer');
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>
      <!-- jQery -->
      <script src="extra/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="extra/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="extra/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="extra/js/custom.js"></script>
   </body>
</html>