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
        <style>
.img-box img {
    height: 200px;
    object-fit: cover;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.card-title {
    font-weight: bold;
    font-size: 1.25rem;
}

.card-footer {
    background-color: #f8f9fa;
}

.btn-primary {
    background-color: #023047;
    border-color: #023047;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>

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
                  {{ Session::get('success') }}
              </div>
              @endif
     </div>
         <div class="col-sm-6 col-md-4 col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="img-box">
                    <img src="/uploads/products/{{ $products->image }}" class="card-img-top" alt="Product Image">
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center text-primary">{{ $products->title }}</h5>
        
                    @if ($products->discount_price != null)
                        <h6 class="text-danger text-center">
                            Discount Price: ${{ $products->discount_price }}
                        </h6>
                        <h6 class="text-center text-muted" style="text-decoration: line-through;">
                            Original Price: ${{ $products->price }}
                        </h6>
                    @else
                        <h6 class="text-center text-primary">
                            Price: ${{ $products->price }}
                        </h6>
                    @endif
        
                    <h6 class="text-secondary text-center">Category: {{ $products->catagory }}</h6>
                    <p class="text-muted text-center">{{ $products->description }}</p>
                    <h6 class="text-success text-center">Stock: {{ $products->quantity }}</h6>
                </div>
                <div class="card-footer text-center">
                    {{-- <a href="#" class="btn btn-primary btn-sm w-100">Add To Cart</a> --}}
                    <form action="{{ url('add_cart', $products->id) }}" method="POST" class="d-flex justify-content-between align-items-center">
                        @csrf
                        <input type="number" name="quantity" class="form-control form-control-sm me-2" placeholder="Qty" min="1" value="1" required>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        
    

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