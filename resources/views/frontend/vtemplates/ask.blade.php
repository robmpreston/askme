<template id="ask-template">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="ask-container">
                <input type="text" placeholder="What do you want to ask DeRay?" v-model="question" v-show="!open" @click="toggle">
                <p v-show="open">Toggled</p>
            </div>
        </div>
    </div>
</template>
