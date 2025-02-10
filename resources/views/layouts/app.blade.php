<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{asset('favicon.ico')}}">
  <title>Dashboard - CARIFY</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
 @include('styles')
@yield('style')
</head>

<body class="vertical  light rtl ">
  <div class="wrapper">
    @include('header')
    {{-- @include('sidebar') --}}

    <main role="main" class="main-content">
      <div class="container-fluid">
          <div class="row">
            <div style="width:90%;  margin: 0 auto;
   gap:30px;">
    @if(request()->segment(1) != 'dashboard')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item current_link" ><a href="{{ route('dashboard') }}">الرئيسية</a></li>
        <li class="breadcrumb-item current_link" id="prev_title" style="display: none"><a href="" id="prev_link"></a></li>
        <li class="breadcrumb-item active" aria-current="page" id="title"></li>
      </ol>
    </nav> 
    @endif
          @yield('content')
          @include('modal')
            </div>
        </div>
      </div>
    </main>

    @include('scripts')
    @yield('scripts')
</body>

</html>