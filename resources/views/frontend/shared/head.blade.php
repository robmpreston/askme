<head>
    <title>@yield('title')</title>
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
    <link href="{{ asset('frontend/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="{{ asset('bower_components/vue/dist/vue.min.js') }}"></script>
    <script src="{{ asset('bower_components/vue-resource/dist/vue-resource.min.js') }}"></script>
    <script>
        var recipient = <?php echo json_encode($recipient); ?>;
        var questions = <?php echo json_encode($questions); ?>;
        var loggedIn = <?php echo json_encode($logged_in); ?>;
        var user = <?php echo json_encode($user); ?>;
        var isAdmin = <?php echo json_encode($is_admin); ?>;
        var baseUrl = <?php echo json_encode($base_url); ?>;
        var featuredQuestion = <?php echo json_encode($featured_question); ?>;
    </script>
</head>
