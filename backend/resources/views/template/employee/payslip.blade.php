<!DOCTYPE html>
<html lang="en">
@include('template.employee.segments.header')
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include('template.employee.segments.navbar')


    <div class="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs -->
<br>

        <table class="table table-bordered" width="100%" id="payslip-table" cellspacing="0">
          <thead>
              <tr>
                  <th>from</th>
                  <th>to</th>
                  <th>---</th>
              </tr>
          </thead>
          <tbody id="PayslipListBody"></tbody>
      </table>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
    
  @include('template.employee.segments.footer')

  <script>
      //payslip ajax
      var user_id = "{{Auth::user()->id;}}";

      $.ajax({
        url: base_url('get_payslip/')+user_id,
        type: 'get',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(ret) {
      
          var div = '';
      
          $.each(ret.data, function( index, value ) {

            div +='<tr>'; 
            div +='<td>'+value.from+'</td>';
            div +='<td>'+value.to+'</td>';
            div +='<td><a href="../../upload/payslip/'+value.filename+'" target="_blank">View Payslip</a></td>';
            div +='</tr>';
            $('#PayslipListBody').html(div);
          });
          
          $( "#payslip-table").DataTable();
      
        },
        error: function(e){
      
        }
      });
  </script>

  </body>

</html>
