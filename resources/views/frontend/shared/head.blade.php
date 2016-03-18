<head>
    <title>@yield('title')</title>
    <link href="frontend/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="bower_components/vue/dist/vue.min.js"></script>
    <script src="bower_components/vue-resource/dist/vue-resource.min.js"></script>
    <script src="bower_components/vue-router/dist/vue-router.min.js"></script>
    <script>
        var recipient = <?php echo json_encode($recipient); ?>;
        var questions = <?php echo json_encode($questions); ?>;
    </script>
</head>
