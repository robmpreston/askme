@extends('backend.shared.master')

@section('title', 'Ask me')

@section('content')

<div id="app">

    <ul class="list-group">
      <question v-for="question in questions" :question="question"></question>
    </ul>

    @include('backend.vtemplates.question')
</div>

@endsection
