<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        @include('master.templates.head')
    </head>
    <body>
        {!! Analytics::render() !!}
        @include('master.templates.nav')
        @yield('subhead')
        <div class="page">
            @yield('body')
        </div>

        <script type="text/javascript" src="{{ elixir('js/master.js') }}"></script>
        @include('master.templates.footer')
        @yield('scripts')
    </body>
    
</html>