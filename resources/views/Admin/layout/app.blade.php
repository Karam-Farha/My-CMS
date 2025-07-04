<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  @include('admin.layout.dashboard-styles')
</head>

<body>


    @include('admin.layout.header')

    @include('admin.layout.sidebar')

    <main id="main" class="main">
      
      @isset($pageTitle)
        <div class="pagetitle">
          <h1>{{__($pageTitle['title']) ?? 'No Title'}}</h1>
          <nav>
            <ol class="breadcrumb">
              @foreach ($pageTitle['bread_crumbs'] as $item)
                <li class="breadcrumb-item"><a href="{{$item['link']}}">{{__($item['title'])}}</a></li>
              @endforeach
            </ol>
          </nav>
        </div><!-- End Page Title -->
      @endisset

      @session('success')
        @include('admin.partials.alert' , ['type' => 'success' , 'icon' => 'check-circle'])  
      @endsession

      @session('danger')
        @include('admin.partials.alert' , ['type' => 'danger' , 'icon' => 'exclamation-octagon']) 
      @endsession

      @session('info')
        @include('admin.partials.alert' , ['type' => 'info' , 'icon' => 'info-circle']) 
      @endsession

      @yield('content')
      
    </main>

    @include('admin.layout.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

   
    @include('admin.layout.dashboar-scripts')
</body>

</html>