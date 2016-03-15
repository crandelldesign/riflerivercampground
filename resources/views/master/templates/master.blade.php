<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        @include('master.templates.head')
    </head>
    <body>
        @yield('body')

        <script type="text/javascript" src="{{ elixir('js/master.js') }}"></script>
        
        @yield('scripts')
    </body>
    
</html>