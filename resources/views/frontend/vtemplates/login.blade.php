<script type="x/template" id="login-modal-template">
    <modal :show.sync="show" :on-close="close">
        <div class="modal-body" v-if="!login">
            <input v-model="firstName" type="text" placeholder="First Name">
            <input v-model="lastName" type="text" placeholder="Last Name">
            <input v-model="email" type="text" placeholder="Email">
            <input v-model="password" type="password" placeholder="Password">
            <button class="ghost button full-width">
                Signup
            </button>
            <a href="{{ url('/social-login/facebook') }}" class="ghost button facebook full-width">
                Signup using Facebook
            </a>
            <button class="clear button full-width" @click="toggle">
                or Login
            </button>
        </div>
        <div class="modal-body" v-if="login">
            <input v-model="email" type="text" placeholder="Email">
            <input v-model="password" type="password" placeholder="Password">
            <button class="ghost button full-width" @click="emailLogin">
                Login
            </button>
            <a href="{{ url('/social-login/facebook') }}" class="ghost button facebook full-width">
                Login using Facebook
            </a>
            <button class="clear button full-width" @click="toggle">
                or Signup
            </button>
        </div>
    </modal>
</script>
