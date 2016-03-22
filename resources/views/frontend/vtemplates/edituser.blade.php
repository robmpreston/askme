<script type="x/template" id="edit-user-modal-template">
    <modal :show.sync="show" :on-close="close">
        <div class="modal-body">
            <input v-model="user.first_name" type="text" placeholder="First Name">
            <input v-model="user.last_name" type="text" placeholder="Last Name">
            <input v-model="user.from" type="text" placeholder="Location (ex: Baltimore, MD)">
            <input v-model="user.email" type="text" placeholder="Email">
            <input v-model="password" type="password" placeholder="Password">
            <button class="ghost button full-width" :disabled="!validated" @click="updateUser">
                Update
            </button>
        </div>
        </div>
    </modal>
</script>
