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
     
      <div class="container my-5">
        <h2 class="text-center mb-4">Product Details</h2>
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
              <tr>
                <th>Product Title</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Payment Status</th>
                <th>Delivery Status</th>
                <th>Image</th>
                <th>Cancel Order</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    
               
              <tr>
                <td>{{ $order->product_title }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->price }}</td>
                <td><span class="badge bg-success">{{ $order->payment_status }}</span></td>
                <td><span class="badge bg-info text-dark">{{ $order->delivery_status }}</span></td>
                <td><img src="/uploads/products/{{ $order->image }}" alt="Product Image" class="img-fluid rounded" style="width: 50px"></td>

                @if ($order->delivery_status == 'processing')
                <td><a onclick="return confirm('Are You Sure You Want To Cancel This Order');" href="{{ url('cancel_order',$order->id) }}" class="btn btn-danger">Cancel</a></td>
                @else
                <td>
                <p class="text-warning">Not Allowed</p>
            </td>
                @endif
              </tr>
              @endforeach
             
            </tbody>
          </table>
        </div>
      </div>

      </div>


    
      <!-- jQery -->
      <script src="extra/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="extra/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="extra/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="extra/js/custom.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   </body>
</html>