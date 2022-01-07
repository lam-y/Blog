<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <!-- Search Box -->
      <div>
      <form action="{{ route('post.search') }}" method="GET" role="search">    
          <div class="input-group">
            <span class="input-group-btn mr-2" >
                <button class="btn btn-info" type="submit" title="Search" style="width: 35px; height:35px; text-align: center; padding: 0px; margin-right: 5px">
                    <span class="fas fa-search"></span>
                </button>
            </span>
            <input type="text" class="form-control mr-2" name="term" placeholder="Search" id="term">
         </div>
        </form>
      </div>

      <!-- Dropdown Categories -->
      <div class="navbar navbar-static-top" style="margin-top: 15px">
        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height: 40px; text-align: center; padding: 10px; margin-left:20px;">
          التصنيفات
        </button>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              @foreach ($dropCategories as $dropCategory)
              <a class="dropdown-item" href="{{ route('posts.category', $dropCategory->id) }}">{{ $dropCategory->name }}</a>
              @endforeach	
          </select>
        </div>      
      </div>

      
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="  navbar-nav navbar-right ml-auto">    
          
          <!-- Links for Admin Only  -->
          @if(Auth::user())
            <li class="nav-item">
              <a href="{{ route('logout') }}" class="nav-link" style="font-size: 18px"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"> تسجيل الخروج </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            </li>
            <li class="nav-item">
              <a class="nav-link" href='{{ route('home') }}' style="font-size: 18px" >لوحة التحكم</a>
            </li>

            <li class="nav-item">
             <a class="nav-link" href='{{ route('post.create')}}' style="font-size: 18px" >تدوينة جديدة</a>
            </li>            
          @endif

          <li class="nav-item">
            
          </li>                      

          <!-- Links for admin and guests  -->
          <li class="nav-item">
            <a class="nav-link" href="/contact" style="font-size: 18px" >اتصل بي</a>
          </li>          
          <li class="nav-item">
            <a class="nav-link" href="/about" style="font-size: 18px">من أنا</a>
          </li>   
          <li class="nav-item">
            <a class="nav-link" href="/" style="font-size: 18px">الرئيسية</a>
          </li>             
        </ul>
      </div>
    </div>
  </nav>

