<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
    <link href="frontend/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="bower_components/vue/dist/vue.min.js"></script>
    <script src="bower_components/vue-resource/dist/vue-resource.min.js"></script>
    <script>
        var recipient = <?php echo json_encode($recipient); ?>;
        var questions = <?php echo json_encode($questions); ?>;
        var loggedIn = <?php echo json_encode($logged_in); ?>;
        var user = <?php echo json_encode($user); ?>;
        var isAdmin = <?php echo json_encode($is_admin); ?>;
        var baseUrl = <?php echo json_encode($base_url); ?>;
    </script>
</head>
