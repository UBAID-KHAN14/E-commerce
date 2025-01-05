<section class="product_section layout_padding">
    <div class="container">
       <div class="heading_container heading_center">
          <h2>
             Our <span>products</span>
          </h2>
       </div>

       <div class="container my-3">
        <form action="{{ url('search_product') }}" method="GET">
            <div class="input-group">
                <input
                    type="search"
                    name="search"
                    class="form-control"
                    placeholder="Search a product"
                    aria-label="Search"
                    required
                />
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>

    {{-- <div class="container">
        <div class="dropdown mb-4">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Select Category
            </button>
            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
               
                @foreach ($catagories as $catagory)
                <li><a class="dropdown-item" href="{{ url('filter_by_category', $catagory->id) }}">{{ $catagory->catagory_name }}</a></li>
            @endforeach
              
            </ul>
        </div> --}}
    
        
    
    
       
       <div class="row">
          @foreach ($products as $product)
          <div class="col-sm-6 col-md-4 col-lg-4">
             <div class="box">
                <div class="option_container">
                   <div class="options">
                      <a href="{{ url('products_details',$product->id) }}" class="option1">
                        Products Details
                      </a>

                      <form action="{{ url('add_cart', $product->id) }}" method="POST" class="d-flex justify-content-between align-items-center">
                        @csrf
                        <input type="number" name="quantity" class="form-control form-control-sm me-2" placeholder="Qty" min="1" value="1" required>
                        <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
                    </form>

                   </div>
                </div>
                <div class="img-box">
                   <img src="/uploads/products/{{ $product->image }}" alt="">
                </div>
                <div class="detail-box">
                  <h5>
                     {{ $product->title }}
                   </h5>

                   @if ($product->discount_price != null)

                   <h6 style="color: red;">
                     Discount Price
                     <br>
                     ${{ $product->discount_price }}
                   </h5>

                   <h6 style="text-decoration: line-through;color:blue;">
                     ${{  $product->price }}
                  </h6>

                   @else
                      
                   <h6 style="color: blue">
                     ${{  $product->price }}
                  </h6>
                   @endif
                  
                </div>
             </div>
          </div>

          @endforeach
          
          <!-- Custom Pagination -->
<div class="pagination">
   @if ($products->onFirstPage())
       <span class="disabled">Previous</span>
   @else
       <a href="{{ $products->previousPageUrl() }}">Previous</a>
   @endif

   @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
       @if ($page == $products->currentPage())
           <span class="active">{{ $page }}</span>
       @else
           <a href="{{ $url }}">{{ $page }}</a>
       @endif
   @endforeach

   @if ($products->hasMorePages())
       <a href="{{ $products->nextPageUrl() }}">Next</a>
   @else
       <span class="disabled">Next</span>
   @endif
</div>
        
        
         
      </div>
                  
 </section>
 <style>
   .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 20px;
}
.pagination a {
    padding: 5px 10px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 3px;
}
.pagination a:hover {
    background-color: #0056b3;
}
.pagination .active {
    font-weight: bold;
    color: #000;
}
.pagination .disabled {
    color: #ccc;
}
 </style>