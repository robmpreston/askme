@extends('frontend.shared.master')

@section('title', 'Ask DeRay')
@section('content')
    @include('frontend.shared.icons')
    <div id="app" class="wrapper">
        <header class="top">
            <input class="file-input" id="file-input" type="file" @change.stop="bindFile" v-el:file-input/>
            <!--<h1>Soapbox</h1> -->
            <img src="{{ env('S3_URL') }}images/derayformayor_logo.png" width="200" />
            <button v-if="!loggedIn" class="login ghost button" @click="showLoginModal = true">Login/Signup</button>
            <div class="user-menu-button" v-if="loggedIn">
                <button v-if="loggedIn" class="clear button button-logout">@{{ user.first_name }}</button>
                <label for="file-input">
                    <img :src="user.picture"/>
                </label>
                <i class="dropdown-toggle fa fa-angle-down"></i>
                <ul class="dropdown">
                    <li @click="showEditModal = true">Edit Profile</li>
                    <li @click="openFile">Change Picture</li>
                    <li @click="logout">Logout</li>
                </ul>
            </div>
        </header>
        <div class="main-column">
            <edit-user-modal v-if="loggedIn" :user="user" :show.sync="showEditModal"></edit-user-modal>
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
        <footer>
            <a href="http://madewithloveinbaltimore.org">Made with &hearts; in Baltimore</a>
        </footer>
    </div>
    @include('frontend.vtemplates.question')
    @include('frontend.vtemplates.answer')
    @include('frontend.vtemplates.feature')
    @include('frontend.vtemplates.ask')
    @include('frontend.vtemplates.modal')
    @include('frontend.vtemplates.login')
    @include('frontend.vtemplates.fbshare')
    @include('frontend.vtemplates.tweet')
    @include('frontend.vtemplates.youtube')
    @include('frontend.vtemplates.edituser')
    <script src="frontend/js/app.js"></script>
@endsection
