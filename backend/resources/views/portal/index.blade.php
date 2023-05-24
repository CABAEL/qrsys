<!doctype html>
<html class="no-js" lang="">
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
          <li><a href="#AboutUs">AboutUs</a></li>
          <li><a href="#Files">Files</a></li>
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
        <h1>Intellidocs</h1>
        <p></p>
        <nav role="navigation"> <a href="#services" class="banner-btn"><img src="images/down-arrow.png" alt=""></a></nav>
      </div>
      <!-- banner text --> 
    </div>
  </div>
</section>
<!-- header section --> 
<!-- about section -->


<section id="AboutUs" class="">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
    asdasd
      </div>
      <div class="col-md-6">

      </div>
    </div>
  </div>
</section>

<section id="Files" class="">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
      <button onclick="tableLoad()">save</button>
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
          <p>Copyright © {{env('YEAR')}} {{env('APP_NAME')}} </p>
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

 tableLoad = async () => {
    let data = await fetch('https://reqres.in/api/users?page=2');
     console.log(await data.json());
  }

  

</script>
</body>
</html>
