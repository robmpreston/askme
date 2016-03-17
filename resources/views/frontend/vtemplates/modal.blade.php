<script type="x/template" id="modal-template">
    <div class="modal-mask" @click="close" v-show="show" transition="modal">
        <div class="modal-container" @click.stop>
            <slot></slot>
        </div>
    </div>
</script>
