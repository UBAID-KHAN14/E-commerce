<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Corona Admin</title>
    
    @include('admin.css');
    <style>
        .table-container {
          margin: 50px auto;
          max-width: 100%; /* Ensures the table fits the container */
          border-radius: 10px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          overflow-x: auto;
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

        .btn-approved {
        color: #28a745; /* Green text */
        border: 2px solid #28a745;
        background-color: transparent;
      }
      .btn-approved:hover {
        background-color: #28a745;
        color: #fff;
      }

      .btn-pending {
        color: #fd7e14; /* Orange text */
        border: 2px solid #fd7e14;
        background-color: transparent;
      }
      .btn-pending:hover {
        background-color: #fd7e14;
        color: #fff;
      }
      </style>
   
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar');
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        @include('admin.header');
        <!-- partial -->
        <!-- body -->
        <div class="main-panel">
            <div class="content-wrapper">
                @if (Session::has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ Session::get('success') }}
                </div>
            @endif

            <div class="container my-4">
              <form action="{{ url('search') }}" method="GET" class="d-flex justify-content-center align-items-center">
                <div class="input-group" style="max-width: 400px;">
                  <input type="search" name="search" id="search" class="form-control" placeholder="Search orders..." aria-label="Search orders">
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Search
                  </button>
                </div>
              </form>
            </div>
              
                <div class="container table-container">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Product Title</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Payment Status</th>
                                <th>Delivery Status</th>
                                <th>Action</th>
                                <th>PDF</th>
                                <th>Send Email</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <img src="/uploads/products/{{ $order->image }}" alt="Orders Image">
                                </td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->product_title }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->payment_status }}</td>
                                <td>{{ $order->delivery_status }}</td>
                                
                                <td>
                                    @if ($order->delivery_status == 'processing')
                                        <a href="{{ url('delivered', $order->id) }}" onclick="return confirm('Are you sure?')">
                                            <button class="btn btn-pending">Pending</button>
                                        </a>
                                    @else
                                    <button class="btn btn-approved">Approved</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('pdf', $order->id) }}">
                                        <button class="btn btn-primary">PDF</button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('send-email', $order->id) }}">
                                        <button class="btn btn-success">Send Email</button>
                                    </a>
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                              <td colspan="16">
                                <p>No Data Found</p>
                              </td>
                            </tr>
                            @endforelse

                        </tbody>
                        
                    </table>
        
        
      </div>
    </div>

    <!-- start-script-tag -->
   @include('admin.script');
    <!-- end-script-tag -->
  </body>
</html>