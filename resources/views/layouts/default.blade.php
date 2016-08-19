<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        @include('layouts.head')
    </head>
    <body>
        {!! Analytics::render() !!}
        @include('layouts.nav')
        @yield('subhead')
        <div class="page">
            @yield('content')
        </div>
        <script type="text/javascript">
            var base_url = '{{url()}}';
        </script>
        <script type="text/javascript" src="{{ elixir('js/default.js') }}"></script>
        @include('layouts.footer')
        @yield('scripts')
    </body>
    
</html>