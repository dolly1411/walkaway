
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin</title>
 
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/perfect-scrollbar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/flag-icon.min.css') }}">>
  <link href="{{ asset('css/style_admin.css') }}" rel="stylesheet">
  <link rel="shortcut icon" ref="{{ asset('images/favicon.png') }}"> 
  
</head>

<body>
  <div class=" container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
       <div class="bg-white text-center navbar-brand-wrapper">
        <a class="navbar-brand brand-logo" href="index.html"><img src="{{ asset('images/icons/logo_star_black.png') }}" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ asset('images/icons/logo_star_mini.jpg') }} alt=""></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler d-none d-lg-block navbar-dark align-self-center mr-3" type="button" data-toggle="minimize">
          <span class="navbar-toggler-icon"></span>
        </button>
        
        <ul class="navbar-nav ml-lg-auto d-flex align-items-center flex-row">
          
        </ul>
        <button class="navbar-toggler navbar-dark navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>

    <!-- partial -->
    <div class="container-fluid">
      <div class="row row-offcanvas row-offcanvas-right">
        <!-- partial:partials/_sidebar.html -->
        <nav class="bg-white sidebar sidebar-offcanvas" id="sidebar">
          <div class="user-info">
            <p class="name"></p>
            <p class="designation">{{ $name}}</p>
            <span class="online"></span>
          </div>
          <ul class="nav">
            <li class="nav-item active">
              <a class="nav-link" href="#">
                <img src={{ asset('images/icons/1.png') }} alt="">
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <img src={{ asset('images/icons/2.png') }} alt="">
                <span class="menu-title">Widgets</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <img src={{ asset('images/icons/005-forms.png') }} alt="">
                <span class="menu-title">Forms</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <img src={{ asset('images/icons/4.png') }} alt="">
                <span class="menu-title">Buttons</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <img src="images/icons/5.png" alt="">
                <span class="menu-title">Tables</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <img src="images/icons/6.png" alt="">
                <span class="menu-title">Charts</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <img src="images/icons/7.png" alt="">
                <span class="menu-title">Icons</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <img src="images/icons/8.png" alt="">
                <span class="menu-title">Typography</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#" aria-expanded="false" aria-controls="sample-pages">
                <img src="images/icons/9.png" alt="">
                <span class="menu-title">Sample Pages<i class="fa fa-sort-down"></i></span>
              </a>
              <div class="collapse" id="sample-pages">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      Blank Page
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      Login
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      Register
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      404
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">
                      500
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <img src="images/icons/10.png" alt="">
                <span class="menu-title">Settings</span>
              </a>
            </li>
          </ul>
        </nav>

        <!-- partial -->
        @yield('content')
          
        <!-- partial:partials/_footer.html -->
        <footer class="footer2">
          <div class="container-fluid clearfix">
            <span class="float-right">
                <a href="#">Star Admin</a> &copy; 2017
            </span>
            
          </div>
        </footer>

        <!-- partial -->
      </div>
    </div>

  </div>
 <script src="{{ asset('js/jquery.min.js') }}"></script>
 <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('js/Chart.min.js') }}"></script>
 <script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>
 <script src="{{ asset('https://maps.googleapis.com/maps/api/js?key=AIzaSyB5NXz9eVnyJOA81wimI8WYE08kW_JMe8g&callback=initMap" async defer') }}"></script>
 <script src="{{ asset('js/off-canvas.js') }}"></script>
 <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
 <script src="{{ asset('js/misc.js') }}"></script>
 <script src="{{ asset('js/chart.js') }}"></script>
 <script src="{{ asset('') }}"></script>
 <script src="{{ asset('js/maps.js') }}"></script>

</body>

</html>
