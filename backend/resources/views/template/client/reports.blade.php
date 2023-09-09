<!DOCTYPE html>
<html lang="en">
   @include('template.header')
   <style>
   </style>
   <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      @include('template.client.segments.navbar')
      <div class="content-wrapper">

         <div class="container-fluid">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
               <a href="{{ route('user_report') }}" target="_blank">USERS REPORTS</a>
               <p>
               Provides a concise view of users based on document uploads. Lists users in descending upload count order.</p>
               </li>
            </ol>

         </div>
         <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
      @include('template.footer')
   </body>
</html>