<html>
    @include('backend.shared.head')
    <body>
        @include('backend.shared.sidebar')

        @yield('content')

        @include('backend.shared.footer')
    </body>
</html>
