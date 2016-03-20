@extends('frontend.shared.master')

@section('title', 'Ask DeRay')
@section('content')
    @include('frontend.shared.icons')
    <div id="app" class="wrapper">
        <header class="top">
            <!--<h1>Soapbox</h1> -->
            <button v-if="!loggedIn" class="ghost button" @click="showLoginModal = true">Login/Signup</button>
            <button v-if="loggedIn" class="ghost button button-logout" @click="logout">Logout</button>
            <div class="image-upload">
                <label for="file-input">
                    <img :src="user.picture"/>
                </label>

                <input id="file-input" type="file"/>
            </div>
        </header>
        <div class="main-column">
            <login-modal v-if="!loggedIn" :show.sync="showLoginModal"></login-modal>
            <div>
                <feature :user="recipient" :is-admin="isAdmin"></feature>
            </div>
            <div v-show="loggedIn">
                <ask :user.sync="user" :recipient="recipient"></ask>
            </div>
            <question v-for="question in questions" :question.sync="question"
                :recipient="recipient" :logged-in.sync="loggedIn" :is-admin="isAdmin"
                :base-url="baseUrl"></question>
        </div>
    </div>
    @include('frontend.vtemplates.question')
    @include('frontend.vtemplates.answer')
    @include('frontend.vtemplates.feature')
    @include('frontend.vtemplates.ask')
    @include('frontend.vtemplates.modal')
    @include('frontend.vtemplates.login')
    @include('frontend.vtemplates.fbshare')
    @include('frontend.vtemplates.tweet')
    <script src="frontend/js/app.js"></script>
@endsection
