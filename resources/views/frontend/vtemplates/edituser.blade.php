<script type="x/template" id="login-modal-template">
    <modal :show.sync="show" :on-close="close">
        <div class="modal-body">
            <input v-model="user.first_name" type="text" placeholder="First Name">
            <input v-model="user.last_name" type="text" placeholder="Last Name">
            <input v-model="user.email" type="text" placeholder="Email">
            <input v-model="password" type="password" placeholder="Password">
            <button class="ghost button full-width" :disabled="!validated">
                Update
            </button>
            <a href="{{ url('/social-login/facebook') }}" class="ghost button facebook full-width">
                Signup using Facebook
            </a>
            <button class="clear button full-width" @click="toggle">
                or Login
            </button>
        </div>
        </div>
    </modal>
</script>
