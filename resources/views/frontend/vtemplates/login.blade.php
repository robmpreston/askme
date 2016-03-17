<script type="x/template" id="login-modal-template">
    <modal :show.sync="show" :on-close="close">
        <div class="modal-body">
            <input v-model="firstName" type="text" placeholder="First Name">
            <input v-model="lastName" type="text" placeholder="Last Name">
            <input v-model="email" type="text" placeholder="Email">
            <input v-model="password" type="password" placeholder="Password">
        </div>

        <div class="modal-footer text-right">
            <button class="modal-default-button" @click="savePost()">
                Login
            </button>
        </div>
    </modal>
</script>
