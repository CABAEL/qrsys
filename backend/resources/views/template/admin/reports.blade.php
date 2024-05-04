<!DOCTYPE html>
<html lang="en">
   @include('template.header')
   <style>
   </style>
   <body class="fixed-nav sticky-footer bg-dark" id="page-top">
      @include('template.admin.segments.navbar')
      <div class="content-wrapper">

         <div class="container-fluid">
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
               <a href="{{ route('client_report') }}" target="_blank">CLIENT REPORTS</a>
               <p>
               Provides a concise view of clients based on document uploads. Lists clients in descending upload order</p>
               </li>
            </ol>

         </div>
         <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
      @include('template.footer')
      @include('template.admin.segments.custom.script_adminaccounts')
   </body>
</html>