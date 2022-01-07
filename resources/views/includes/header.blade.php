
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>مدونة مما قرأت  @yield('title')</title>

  <link rel = "icon" href ='{{ asset('img/icon.gif') }}'  
        type = "image/x-icon">
  

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}"> 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  

  <!-- Custom fonts for this template -->
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic')}}" rel='stylesheet' type='text/css'>
  <link href='"{{asset('https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800')}}" rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="{{asset('css/clean-blog.css')}}" rel="stylesheet">


 <!-- الحل اللي بيشغل dropdown -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


  <!-- Parsley -->
  <link href="{{asset('parsley.css')}}" rel="stylesheet"> 

  <!-- Scripts -->
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="{{ asset('parsley.min.js') }}" ></script>


  @yield('stylesheets')

  @yield('scripts')
  

</head>