<html>
    <head>
        <title>@yield('title')</title>
        <link href="/css/app.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    </head>
    <body>
        <div id="app">
            <question v-for="question in questions" :question="question"></question>
        </div>
        <template id="question-template">
          <li class="list-group-item">
            <i class="glyphicon glyphicon-chevron-up" @click="upvote" :class="{disabled: upvoted}"></i>
            <span class="label label-primary">@{{ votes }}</span>
            <i class="glyphicon glyphicon-chevron-down" @click="downvote" :class="{disabled: downvoted}"></i>
            <a>@{{ text }}</a>
          </li>
      </template>
        <script src="js/app.js"></script>

    </body>
</html>
