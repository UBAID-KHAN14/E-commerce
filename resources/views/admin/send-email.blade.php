<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
   
    @include('admin.css');
    <style>
    
        .email-form-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .email-form-title {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
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
        @include('admin.header')''
        <!-- partial -->

    <!-- body -->
    <div class="main-panel">
        <div class="content-wrapper">
           
<div class="container">
    <div class="email-form-container">
        <h2 class="email-form-title">Send an Email</h2>
        <form action="{{ url('send_user_email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="emailGreeting" class="form-label">Email Greeting</label>
                <input type="text" class="form-control" id="emailGreeting" name="emailGreeting" placeholder="Enter email greeting">
            </div>
            <div class="mb-3">
                <label for="emailFirstLine" class="form-label">Email First Line</label>
                <input type="text" class="form-control" id="emailFirstLine" name="emailFirstLine" placeholder="Enter the first line of the email">
            </div>
            <div class="mb-3">
                <label for="emailBody" class="form-label">Email Body</label>
                <textarea class="form-control" id="emailBody" name="emailBody" rows="4" placeholder="Enter the email body"></textarea>
            </div>
            <div class="mb-3">
                <label for="emailButtonName" class="form-label">Email Button Name</label>
                <input type="text" class="form-control" id="emailButtonName" name="emailButtonName" placeholder="Enter button name">
            </div>
            <div class="mb-3">
                <label for="emailLink" class="form-label">Email Link</label>
                <input type="url" class="form-control" id="emailLink" name="emailLink" placeholder="Enter email link">
            </div>
            <div class="mb-3">
                <label for="emailLastLine" class="form-label">Email Last Line</label>
                <input type="text" class="form-control" id="emailLastLine" name="emailLastLine" placeholder="Enter last line of the email">
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Email</button>
        </form>
    </div>
</div>

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

    <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>