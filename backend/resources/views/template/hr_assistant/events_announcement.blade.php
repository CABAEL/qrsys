<!DOCTYPE html>
<html lang="en">
@include('template.hr_assistant.segments.header')
  <body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include('template.hr_assistant.segments.navbar')
    <style>
      .announcement_div{
        width: 100%;
        height: auto;
        background: #ace;
        border-radius: 5px;
        padding: 5px;
        margin-top:20px;
        border: solid 1px #ccc;
      }
      .event_div{
        width: 100%;
        height: auto;
        background: #fff7a3;
        border-radius: 5px;
        padding: 5px;
        margin-top:20px;
        border: solid 1px #ccc;
      }
      .post_decriptions{
        background-color:#fff;
        padding: 5px;
      }
      #events_cont,#announcement_cont{
        height:500px;
        background:#fff;
        overflow-Y:scroll;
        padding:2px;
      }
      #event-form{
        padding: 5px;
      }
    </style>
    <div class="content-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xl-12 col-sm-12 mb-12">
            <center><h3>Events</h3></center>
            <hr>
          </div>
          <div class="col-xl-6 col-sm-6 mb-6">
            <form id="event-form">
              <input type="hidden" id="event_id" name="event_id" value=""/>
              Title:<input type="text" name="event_name" id="event_name" class="form-control">
              Event date:<input type="datetime-local" name="event_date" id="event_date" class="form-control">
              <br>
              <textarea id="event_description" name="event_description" cols="30" rows="10"></textarea>
            </form>
            <br>
            <button class="btn btn-sm" id="eventBtn">Add Event</button>
            <button class="btn btn-sm btn-warning" style="visibility:hidden" id="cancelEventUpdate">Cancel Update</button>
            <br>
          </div>
          <div class="col-xl-6 col-sm-6 mb-6">
            <div class="" id="events_cont" style="">
              <!--<h3>Events</h3><br>
              <table class="table table-bordered" width="100%" id="events-table" cellspacing="0">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Created at</th>
                        <th>---</th>
                    </tr>
                </thead>
                <tbody id="events_tbody"></tbody>
              </table>-->
            </div>

          </div>
        </div>
        <div class="row">
          <hr style="background: #eee;width:100%;height:20px;">
        </div>
        <div class="row">
          <div class="col-xl-12 col-sm-12 mb-12">
            <center><h3>Announcements</h3></center>
            <hr>
          </div>
          <div class="col-xl-6 col-sm-6 mb-6">
            <form id="annoucement" style="">
              <input type="hidden" name="announcement_id" id="announcement_id" value="">
              Title:<input type="text" name="announcement_name" id="announcement_name" class="form-control">
              <br>
              <textarea name="announcement_description" id="announcement_description" cols="30" rows="10"></textarea>
            </form> 
            <br>
            <button class="btn btn-sm" id="announcementBtn">Add Announcement</button>
            <button class="btn btn-sm btn-info" style="visibility:hidden;" id="cancelUpdateannouncementBtn">Cancel Update</button>
            <br>
          </div>
          <div class="col-xl-6 col-sm-6 mb-6">
            <div class="" id="announcement_cont">

            </div>
          </div>


        </div>
        <br>

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->
  @include('template.hr_assistant.segments.footer')
  <script src="{{ asset('js/custom/page/hr_head/job_vacancy.js') }}"></script>
  </body>

</html>
