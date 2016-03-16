@extends('backend.shared.master')

@section('title', 'Ask DeRay')

@section('content')
    <div id="app">
        <question v-for="question in questions" :question="question"></question>
    </div>
    <template id="question-template">
      <li class="list-group-item">
        <i class="fa fa-chevron-up" @click="upvote" :class="{disabled: upvoted}"></i>
        <span class="label label-primary">@{{ votes }}</span>
        <i class="fa fa-chevron-down" @click="downvote" :class="{disabled: downvoted}"></i>
        <a>@{{ question.text }}</a>
      </li>
    </template>

@endsection
