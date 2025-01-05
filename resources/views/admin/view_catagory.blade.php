<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    @include('admin.css');
    <style>
 

        .catagory {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            margin: 0 auto
        }

        .catagory h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .catagory {
            margin-bottom: 15px;
        }

        .catagory .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .catagory .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            outline: none;
            background: rgba(255, 255, 255, 0.8);
        }

        .catagory .form-group input[type="text"]:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
        }

        .catagory .form-group button {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            color: #fff;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .catagory .form-group button:hover {
            background: linear-gradient(to right, #feb47b, #ff7e5f);
        }

        /* table */
        .catagory-table table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        .catagory-table th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #8d8d8d;
        }
        .catagory-table th {
            background-color: #258400;
        }
        .catagory-table button {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .catagory-table .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .catagory-table .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .catagory-table button:hover {
            opacity: 0.8;
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
        <div class="main-panel">
            <div class="content-wrapper">
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ Session::get('success') }}
                    </div>
                @endif

               <!-- form -->
               <div class="form-container catagory">
                <h2>Add Category</h2>
                <form action="{{ url('add_catagory') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" id="catagory_name" name="catagory_name" placeholder="Enter catagory name" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Submit</button>
                    </div>
                </form>
                <!-- end form -->

                <div class="container catagory-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category_Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                           @foreach ($catagories as $catagory)
                               
                           
                            <tr>
                                <td>{{ $catagory->id }}</td>
                                <td>{{ $catagory->catagory_name }}</td>
                                <td>
                                    <button href="#" class="edit-btn">Edit</button>
                                    <form action="{{ url('delete_catagory', $catagory->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete?')" class="delete-btn">Delete</button>
                                    </form>
                                    
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    <!-- start-script-tag -->
   @include('admin.script');
    <!-- end-script-tag -->
  </body>
</html>