<html>
    @include('backend.shared.head)
    <body>
        @section('sidebar')

        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
