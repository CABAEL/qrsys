<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{env('APP_NAME')}}</title>
<link rel="stylesheet" href="{{asset('portal/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('portal/css/flexslider.css')}}">
<link rel="stylesheet" href="{{asset('portal/css/jquery.fancybox.css')}}">
<link rel="stylesheet" href="{{asset('portal/css/main.css')}}">
<link rel="stylesheet" href="{{asset('portal/css/responsive.css')}}">
<link rel="stylesheet" href="{{asset('portal/css/animate.min.css')}}">
<link rel="stylesheet" href="{{asset('portal/css/font-icon.css')}}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<style>
  .announcement_div{
    width: 100%;
    height: auto;
    background: #ace;
    border-radius: 5px;
    padding: 10px;
    margin-top:20px;
    border: solid 1px #ccc;
  }
  .event_div{
    width: 100%;
    height: auto;
    background: #fff7a3;
    border-radius: 5px;
    padding: 10px;
    margin-top:20px;
    border: solid 1px #ccc;
  }
  .post_decriptions{
    background-color:#fff;
    padding: 5px;
  }
  .events_cont,.announcement_cont{
    height:500px;
    background:#fff;
    overflow-Y:scroll;
    padding:20px;
  }
  #event-form{
    padding: 5px;
  }
</style>
</head>

<body>
<!-- header section -->
<section class="banner" role="banner"> 
  <!--header navigation -->
  <header id="header">
    <div class="header-content clearfix"> <a class="logo" href="#"><img src="images/logo.png" alt=""></a>
      <nav class="navigation" role="navigation">
        <ul class="primary-nav">
          <li><a href="#Events">Events & Announcements</a></li>
          <!--<li><a href="#Announcements">Announcements</a></li>-->
          <li><a href="{{route('login')}}">Login</a></li>

        </ul>
      </nav>
      <a href="#" class="nav-toggle">Menu<span></span></a> </div>
  </header>
  <!--header navigation --> 
  <!-- banner text -->
  <div class="container">
    <div class="col-md-10 col-md-offset-1">
      <div class="banner-text text-center">
        <h1>HRMS</h1>
        <p></p>
        <nav role="navigation"> <a href="#services" class="banner-btn"><img src="images/down-arrow.png" alt=""></a></nav>
      </div>
      <!-- banner text --> 
    </div>
  </div>
</section>
<!-- header section --> 
<!-- about section -->
<hr>
<center>------------------ *** Whiteboard *** ------------------</center>
<hr>
<section id="Events" class="">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 events_cont container">
        
      </div>
      <div class="col-md-6 announcement_cont container">
       
      </div>
    </div>
  </div>
</section>

<section id="Announcements" class="">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
   
      </div>
      <div class="col-md-6">

      </div>
    </div>
  </div>
</section>
<!-- about section --> 
<!-- services section --> 

<!-- Footer section -->
<footer class="footer">
  <div class="footer-top section">
    <div class="container">
      <div class="row">
        <div class="footer-col col-md-6">
          <h5>The Team</h5>
          <p>Amit, Roderick D.<br>
            Ballos, Mark Jerome V.<br>
            Francis Rey I. Paradero<br>
            Lala Renz Abdulaziz P.
          </p>
          <p>Copyright © 2022 {{env('APP_NAME')}} </p>
        </div>
        <div class="footer-col col-md-3">
          <h5></h5>
          <p>
          <ul>
            <!--<li><a href="#">Digital Strategy</a></li>
            <li><a href="#">Websites</a></li>
            <li><a href="#">Videography</a></li>
            <li><a href="#">Social Media</a></li>
            <li><a href="#">User Experience</a></li>-->
          </ul>
          </p>
        </div>
        <div class="footer-col col-md-3">
          <!--<h5>Share with Love</h5>
          <ul class="footer-share">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
          </ul>-->
        </div>
      </div>
    </div>
  </div>
  <!-- footer top --> 
  
</footer>
<!-- Footer section --> 
<!-- JS FILES --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script src="{{asset('portal/js/bootstrap.min.js')}}"></script> 
<script src="{{asset('portal/js/jquery.flexslider-min.js')}}"></script> 
<script src="{{asset('portal/js/jquery.fancybox.pack.js')}}"></script> 
<script src="{{asset('portal/js/retina.min.js')}}"></script> 
<script src="{{asset('portal/js/modernizr.js')}}"></script> 
<script src="{{asset('portal/js/main.js')}}"></script>

<script src="{{ asset('js/custom/custom.js') }}"></script>

<script>
  $.ajax({
    url: base_url('portal_event'),
    type: 'get',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret){
       console.log(ret);
       var eventdiv = '<center><h4>Events</h4></center>';
       if(ret == ''){
        eventdiv += "<br><br><center>No event posted.</center>";
       }else{
       $.each(ret,function(event_k,event_v) {
       
       var d1 = new Date(event_v.date);
       var d2 = new Date(event_v.created_at);
       var datestring1 = d1.toLocaleString('en-US', { timeZone: 'Asia/Manila' });
       var datestring2 = d2.toLocaleString('en-US', { timeZone: 'Asia/Manila' });
       
        eventdiv += "<div class='event_div'>";
        //eventdiv += "<i class='fa fa-fw fa-close pull-right close DeleteEvent' data-id='"+event_v.id+"'></i>";
        eventdiv += '<h6><b>'+event_v.title+' <span style="color:red;">(Event Date: '+datestring1+')</span></b></h6>';
        eventdiv += '<p style="font-size:12px;">Posted on: '+datestring2+'</p>';
        eventdiv += '<hr>';
        eventdiv += '<div class="post_decriptions">'+event_v.description+'</div>';
        //eventdiv += '<br><button><i class="fa fa fa-edit close updateEvent" data-id="'+event_v.id+'"></i></button><br>';
        eventdiv += "</div>";
  
       });
       }
       

  
       $('.events_cont').html(eventdiv);

       //$('#events-table').DataTable();
    },
    error: function(e){
  
      alert('Error on events table!');
  
    }
  });
  
  $.ajax({
    url: base_url('portal_announcement'),
    type: 'get',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(ret){
       console.log(ret);

       var announcementdiv = '<center><h4>Announcements</h4></center>';
      
       if(ret == ''){
        announcementdiv += "<br><br><center>No announcement posted.</center>";
       }else{

       
       $.each(ret,function(announcement_k,announcement_v){
        var d = new Date(announcement_v.created_at);
        var datestring = d.toLocaleString('en-US', { timeZone: 'Asia/Manila' });
  
        announcementdiv += "<div class='announcement_div'>";
        //announcementdiv += "<i class='fa fa-fw fa-close pull-right close DeleteAnnouncement' data-id='"+announcement_v.id+"'></i>";
        announcementdiv += '<center><h6><b>'+announcement_v.title+'</b></h6>';
        announcementdiv += '<p style="font-size:12px;">Posted on: '+datestring+'</p></center>';
        announcementdiv += '<hr>';
        announcementdiv += '<div class="post_decriptions">'+announcement_v.description+'</div>';
        //announcementdiv += '<br><button><i class="fa fa fa-edit close updateAnnouncement" data-id="'+announcement_v.id+'"></i></button><br>';
        announcementdiv += "</div>";
  
       });

       }
  

  
       $('.announcement_cont').html(announcementdiv);

    },  
    error: function(e){
  
      alert('Error on events table!');
  
    }
  });

</script>
</body>
</html>
