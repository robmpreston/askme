@extends('frontend.shared.master')

@section('title', 'Ask DeRay')
@section('content')
    @include('frontend.shared.icons')
    <div id="app" class="wrapper" v-cloak>
        <header class="top">
            <input class="file-input" id="file-input" type="file" @change.stop="bindFile" v-el:file-input/>
            <h1 v-if="recipient.id != 5">Soapbox</h1>
            <img class="logo" v-if="recipient.id == 5" src="{{ env('S3_URL') }}images/derayformayor_logo.png" width="200" />
            <button v-if="!loggedIn" class="login ghost button" @click="showLoginModal = true">Login/Signup</button>
            <div class="user-menu-button" v-if="loggedIn">
                <button v-if="loggedIn" class="clear button button-logout">@{{ user.first_name }}</button>
                <img :src="user.picture"/>
                <i class="dropdown-toggle fa fa-angle-down"></i>
                <ul class="dropdown">
                    <!--<li><a href="http://www.soapbox.cc/@{{ user.slug }}" target="_blank">My Soapbox</a></li>-->
                    <li @click="showEditModal = true">Edit Profile</li>
                    <li @click="openFile">Change Picture</li>
                    <li @click="logout">Logout</li>
                </ul>
            </div>
        </header>
        <div class="main-column">
            <edit-user-modal v-if="loggedIn" :user="user" :show.sync="showEditModal"></edit-user-modal>
            <login-modal v-if="!loggedIn" :show.sync="showLoginModal" :userLocation="userLocation"></login-modal>
            <div>
                <feature :user="recipient" :topic="topic" :is-admin="isAdmin"></feature>
            </div>
            <ask :user.sync="user" :recipient="recipient" :logged-in.sync="loggedIn" :topic="topic"></ask>
            <div v-show="featuredQuestion != null && featuredShowing">
                <ul class="sorting">
                    <li><a href="#" @click="toggleFeatured" class="active">Show All Questions</a></li>
                </ul>
                <question :question.sync="featuredQuestion"
                    :recipient="recipient" :logged-in.sync="loggedIn" :is-admin="isAdmin"
                    :base-url="baseUrl"></question>
            </div>
            <div v-show="(featuredQuestion != null && !featuredShowing) || featuredQuestion == null">
                <sorting :sort-type="sortType"></sorting>
                <question v-for="question in questions" :question.sync="question"
                    :recipient="recipient" :logged-in.sync="loggedIn" :is-admin="isAdmin"
                    :base-url="baseUrl"></question>
            </div>
        </div>
        <footer>
            <p><a href="http://madewithloveinbaltimore.org">Made with &hearts; in Baltimore</a></p>
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
    @include('frontend.vtemplates.sorting')
    <script src="{{ asset('frontend/js/app.js') }}"></script>
@endsection
