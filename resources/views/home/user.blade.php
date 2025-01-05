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
          .comment-box {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 5px;
      padding: 15px;
      margin-bottom: 15px;
    }
    .reply-box {
      margin-left: 40px;
      border-left: 2px solid #dee2e6;
      padding-left: 15px;
    }
    .comment-header {
      font-weight: bold;
      margin-bottom: 5px;
    }
    .comment-time {
      font-size: 0.9rem;
      color: #6c757d;
    }
       </style>
   </head>
   <body>
      <div class="hero_area">

         <!-- header section strats -->
        @include('home.header');
         <!-- end header section -->

         <!-- slider section -->
         @include('home.slider');
         <!-- end slider section -->

      </div>

      <!-- why section -->
      @include('home.why');
      <!-- end why section -->
      
      
      <!-- arrival section -->
      @include('home.new_arrival');
      <!-- end arrival section -->
      
      <!-- product section -->
      @include('home.product');

      <!-- comment section -->
      <div class="container my-5">
         <h2 class="text-center mb-4">Comment Section</h2>
     
         <!-- Add Comment -->
         <form action="{{ url('add_comment') }}" method="POST">
          @csrf
         <div class="mb-3">
           <textarea class="form-control" name="comment" placeholder="Add a comment..." rows="3"></textarea>
           
           <input type="submit" value="Post Comment" class="btn btn-primary mt-2">
           
         </div>
        </form>
     
         <!-- Comments Section -->
         @foreach ($comments as $comment)
           
         
         <div class="comment-box">
           <div class="comment-header">
             {{ $comment->name }} <span class="comment-time">- 2 hours ago</span>
           </div>
           <p>{{ $comment->comment }}</p>
           <a class="btn btn-link btn-sm" href="javascript::void(0)" onclick="reply(this)" data-Commentid="{{ $comment->id }}">Reply</a>
           
          
           
           @foreach ($replies as $reply)
             
           @if ($reply->comment_id == $comment->id)
             
           
           <!-- Replies -->
           <div class="reply-box">
             <div class="comment-header">
               {{ $reply->name }} <span class="comment-time"></span>
             </div>
             <p>{{ $reply->reply }}</p>
             {{-- <button class="btn btn-link btn-sm" onclick="reply(this)">Reply</button> --}}
           </div>
           
           @endif
           @endforeach
         </div>


         @endforeach
     
        

         <div class="mb-3 replyDiv" style="display: none">

          <form action="{{ url('add_reply') }}" method="POST">
           @csrf
            <input type="hidden" name="commentId" id="commentId">
          <textarea class="form-control" placeholder="Add a comment..." rows="3" name="reply"></textarea>
          
          <button type="submit" class="btn btn-primary mt-2">Reply</button>
          <a class="btn btn-primary mt-2" href="javascript::void(0)" onclick="reply_close(this)">Close</a> 
        </form>
        </div>
       </div>

      
      <!-- comment section -->
      
      <!-- end product section -->

      <!-- subscribe section -->
      @include('home.subscribe');
      <!-- end subscribe section -->

      <!-- client section -->
      @include('home.client');
      <!-- end client section -->

      <!-- footer start -->
      @include('home.footer');
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>

      <script type="text/javascript">
      function reply(caller){
        document.getElementById('commentId').value = $(caller).attr('data-commentid');
        $('.replyDiv').insertAfter($(caller));
        $('.replyDiv').show();
      }
      function reply_close(caller){
        
        $('.replyDiv').hide();
      }
      </script>

<script>
  document.addEventListener("DOMContentLoaded", function(event) { 
      var scrollpos = localStorage.getItem('scrollpos');
      if (scrollpos) window.scrollTo(0, scrollpos);
  });

  window.onbeforeunload = function(e) {
      localStorage.setItem('scrollpos', window.scrollY);
  };
</script>
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