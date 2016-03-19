<script type="x/template" id="login-modal-template">
    <modal :show.sync="show" :on-close="close">
        <div class="modal-body" v-if="!login">
            <input v-model="firstName" type="text" placeholder="First Name">
            <input v-model="lastName" type="text" placeholder="Last Name">
            <input v-model="email" type="text" placeholder="Email">
            <input v-model="password" type="password" placeholder="Password">
            <button class="default-btn full-width-btn">
                Signup
            </button>
            <button class="default-btn full-width-btn">
                Signup using Facebook
            </button>
            <button class="default-btn no-border-btn full-width-btn" @click="toggle">
                or Login
            </button>
        </div>
        <div class="modal-body" v-if="login">
            <input v-model="email" type="text" placeholder="Email">
            <input v-model="password" type="password" placeholder="Password">
            <button class="default-btn full-width-btn">
                Login
            </button>
            <button class="default-btn full-width-btn">
                Login using Facebook
            </button>
            <button class="default-btn no-border-btn full-width-btn" @click="toggle">
                or Signup
            </button>
        </div>
    </modal>
</script>
