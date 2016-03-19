@extends('frontend.shared.master')

@section('title', 'Ask DeRay')
<!--
<button class="default-btn"><p>Button</p></button>
<p>Testing testing testing testing</p>
<p class="faded-text">Testing testing testing testing</p>
<button class="default-btn no-border-btn"><p>Button</p></button>
-->
@section('content')
    @include('frontend.shared.icons')
    <div id="app" class="wrapper">
        <header class="top">
            <h1>Soapbox</h1>
            <button v-if="!loggedIn" class="ghost button" @click="showLoginModal = true">Login/Signup</button>
            <button v-if="loggedIn" class="ghost button" @click="logout">Logout</button>
        </header>
        <div class="main-column">
            <login-modal v-if="!loggedIn" :show.sync="showLoginModal"></login-modal>
            <div>
                <feature :user="recipient"></feature>
            </div>
            <div v-show="loggedIn">
                <ask :user.sync="user" :recipient="recipient"></ask>
            </div>
            <question v-for="question in questions" :question.sync="question" :recipient="recipient" :logged-in.sync="loggedIn"></question>
        </div>
    </div>
    @include('frontend.vtemplates.question')
    @include('frontend.vtemplates.answer')
    @include('frontend.vtemplates.feature')
    @include('frontend.vtemplates.ask')
    @include('frontend.vtemplates.modal')
    @include('frontend.vtemplates.login')

    <script src="frontend/js/app.js"></script>
@endsection
