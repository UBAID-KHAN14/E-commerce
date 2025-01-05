<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Corona Admin</title>
    
    @include('admin.css');
   
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
                <!-- form -->
                <div class="container mt-5 product-container">
                  <h2 class="text-center mb-4">Add New Item</h2>
                  <form action="{{ url('/update_product',$product->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                
                
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" value="{{ $product->title }}" id="title" name="title" 
                               class="form-control" 
                               placeholder="Enter item title" required>
                    </div>
                
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" 
                                  class="form-control " 
                                  placeholder="Enter item description" rows="4" required>{{ $product->description }}</textarea>
                    </div>
                
                    <div class="mb-3">
                        <label for="catagory_name" class="form-label">Category</label>
                        <select id="catagory_name" name="catagory_name" 
                                class="form-select " required>
                            <option value="" disabled selected>Select a category</option>
                            @foreach($catagories as $catagory)
                                <option value="{{ $catagory->id }}">
                                    {{ $catagory->catagory_name }}
                                </option>
                            @endforeach
                        </select>
                        
                    </div>
                
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" id="quantity" name="quantity" 
                                   class="form-control " 
                                   placeholder="Enter quantity" value="{{ $product->quantity }}" required>
                         
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" id="price" name="price" 
                                   class="form-control " 
                                   placeholder="Enter price" value="{{ $product->price }}" step="0.01" required>
                            
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="discount_price" class="form-label">Discount Price</label>
                            <input type="number" id="discount_price" name="discount_price" 
                                   class="form-control " 
                                   placeholder="Enter discount price" value="{{ $product->discount_price }}" step="0.01">
                           
                        </div>
                    </div>
                
                    <div class="mb-3">
                        <img src="/uploads/products/{{ $product->image }}" width="50">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" id="image" name="image" 
                               class="form-control " 
                               accept="image/*" required>
                       
                    </div>
                
                    <button type="submit" class="btn btn-primary w-100">Add Item</button>
                </form>
                
              </div>
                <!-- form -->
            </div>
        </div>
        <!-- body -->
        
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    <!-- start-script-tag -->
   @include('admin.script');
    <!-- end-script-tag -->
  </body>
</html>