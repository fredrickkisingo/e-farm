<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}"> {{ config('app.name', 'E-FARM') }}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/harvestlosses">Losses mitigation</a>
                  </li>
                
                  <li class="nav-item">
                      <a class="nav-link" href="/posts">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/maps">Map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/directions">Directions</a>
                    </li>
                
              
              </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest

                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                      </li>
                  @endif
                    @else
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }} <span class="caret"></span>
                      </a>
        
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="/dashboard" class="dropdown-item">Dashboard</a>
                            @if(Auth::user()->role_id==3)
                            <a href="/posts/create" class="dropdown-item">Add Product</a>
                            @endif
                            @if(Auth::user()->role_id==1)
                            <a href="/harvestlosses/create" class="dropdown-item">Add A blog post</a>
                            <a href="/admin/dashboard" class="dropdown-item">Go to Admin Panel</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                         </div>

                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/carts">Cart Items</a>
                  </li>
              @endguest
          </ul>
      </div>
  </div>
</nav>