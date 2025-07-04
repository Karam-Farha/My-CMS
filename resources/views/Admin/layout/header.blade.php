  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

      <div class="d-flex align-items-center justify-content-between ">

          <a href="index.html" class="logo d-flex align-items-center justify-content-center">
              <span class="d-none d-lg-block">Address Corporate</span>
              <img src="{{ asset('assets/niceAdmin/img/logo.png') }}" alt="">
          </a>
          <i class="bi bi-list toggle-sidebar-btn"></i>
      </div><!-- End Logo -->



      <nav class="header-nav me-auto">
          <ul class="d-flex align-items-center">

              <li class="nav-item d-block d-lg-none">
                  <a class="nav-link nav-icon search-bar-toggle " href="#">
                      <i class="bi bi-search"></i>
                  </a>
              </li><!-- End Search Icon-->

              @if (auth()->check())
                  <li class="nav-item dropdown pe-3">

                      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                          data-bs-toggle="dropdown">
                          <img src="{{ auth()->user()->originalImage ?? asset('assets/niceAdmin/img/profile-img.jpg') }}"
                              alt="Profile" class="rounded-circle"
                              style="width: 40px; max-width: 40px; max-height: 40px; height: 50px; margin-right: 10px;">
                          <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name ?? '' }}</span>
                      </a><!-- End Profile Iamge Icon -->

                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                          <li class="dropdown-header">
                              <h6>{{ auth()->user()->name ?? '' }}</h6>
                              <span>{{ auth()->user()->email ?? '' }}</span>
                          </li>
                          <li>
                              <hr class="dropdown-divider">
                          </li>

                          <li>
                            {{-- {{ route('user-profile') }} --}}
                              <a class="dropdown-item d-flex align-items-center" href="#">
                                  <i class="bi bi-person"></i>
                                  <span>{{ __('My Account') }}</span>
                              </a>
                          </li>
                          <li>
                              <hr class="dropdown-divider">
                          </li>

                          <li>
                              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                  <i class="bi bi-box-arrow-right"></i>
                                  <span>{{ __('Logout') }}</span>
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                  @csrf
                              </form>
                          </li>

                      </ul><!-- End Profile Dropdown Items -->
                  </li><!-- End Profile Nav -->
              @endif

              <li class="nav-item dropdown pe-3">

                  <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                      data-bs-toggle="dropdown">

                      <span class="d-none d-md-block dropdown-toggle ps-2"><i class="bi bi-globe"></i>
                          {{ __('Language') }} </span>
                  </a><!-- End Profile Iamge Icon -->

                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                      @foreach (config('languages') as $key => $value)
                          <li>
                              <a class="dropdown-item d-flex align-items-center"
                                  href="{{ route('localization', $value) }}"><span>{{ $key }}</span>
                              </a>
                          </li>
                          <li>
                              <hr class="dropdown-divider">
                          </li>
                      @endforeach

                  </ul><!-- End Profile Dropdown Items -->
              </li><!-- End Profile Nav -->


          </ul>
      </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
