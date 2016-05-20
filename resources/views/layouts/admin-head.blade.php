<title>{{isset($title) ? $title.' | ' : ''}}Rifle River Campground Admin</title>
<meta name="description" content="{{isset($description) ? $description : ''}}">

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="stylesheet" type="text/css" href="{{ elixir('css/admin.css') }}" />
<link rel="stylesheet" type="text/css" href="{{url('/css/summernote/summernote.css') }}" />

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="{{url('/')}}/js/html5shiv.min.js"></script>
    <script src="{{url('/')}}/js/respond.min.js"></script>
    <style>
    </style>
<![endif]-->

@yield('head')