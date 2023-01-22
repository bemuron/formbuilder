<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>

  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Strong Minds</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link href="{{ asset('assets/lib/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/remixicon/remixicon.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  </head>
  <body>
    <!--show overlay loading spinner-->
    <div id="loader" class="lds-dual-ring hidden overlay"></div>
    <!--overlay loading spinner end-->

    <!-- <div class="hidden" id="custom-alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong id="alert-msg"></strong>
    </div> -->

    <div id="action-alert" class="modal h-auto fade show alert-dismissible" role="document">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <p class="fs-4 text-center mt-1" id="alert-msg"></p>
    </div>

    <div id="successAlert" class="modal alert-success h-auto  fade show alert-dismissible" role="document">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <p class="fs-4 text-center mt-2" id="success-msg"></p>
    </div>

    <div id="failedAlert" class="modal alert-danger h-auto fade show alert-dismissible" role="document">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <p class="fs-4 text-center mt-2" id="error-msg"></p>
    </div>

    <aside class="aside aside-fixed">
      <div class="aside-header">
        <a href="" class="aside-menu-link">
          <i data-feather="menu"></i>
          <i data-feather="x"></i>
        </a>
      </div>
      <div class="aside-body">
        @guest
          <script>
          // go to login page
          window.location.replace("/login");
          </script>
        @else
          @if (Auth::check())
          <div class="aside-loggedin">
            <div class="d-flex align-items-center justify-content-start">
            </div>
            <div class="aside-loggedin-user">
              <div class="d-flex align-items-center justify-content-between mg-b-2">
                  
                <h6 class="tx-semibold mg-b-0">{{ Auth::user()->name }}</h6>

                <a href="{{ route('logout') }}" data-toggle="tooltip" title="Log out"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    <i data-feather="log-out"></i>
                </a>
              </div>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
              <p class="tx-color-03 tx-12 mg-b-0"></p>
            </div>
          </div><!-- aside-loggedin -->
          @else
            <script>
            // go to home page if not admin
            window.location.replace("/login");
            </script>
          @endif
          
          @endguest

          <ul class="nav nav-aside">
            <li class="nav-label">Dashboard</li>
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link"><i data-feather="shopping-bag"></i> <span>Home</span></a></li>
          </ul>
      </div>
    </aside>

    <div class="content pd-0">

      <div class="content-body">
        <div class="container pd-x-0">

        @yield('content')
          

        </div>
      </div>

      </div>

    <div id="preloader"></div>

    <!-- JS Files -->
    <script src="{{ asset('assets/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/lib/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/lib/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/lib/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script> 
    <script src="{{ asset('assets/lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/lib/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery-steps/build/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>

    </body>
</html>