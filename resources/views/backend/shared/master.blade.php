<html>
    @include('backend.shared.head')
    <body>
        @include('backend.shared.sidebar')

        <div class="container">
            @yield('content')
        </div>

        @include('backend.shared.footer')
    </body>
</html>
