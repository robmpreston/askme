<template id="ask-template">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="ask-container" v-show="!open">
                <input type="text" placeholder="What do you want to ask DeRay?" v-model="question" @click="toggle">
            </div>
            <div class="ask-container ask-open" v-show="open">
                <p><img src="/"> Derek <span class="faded-text">from</span> Baltimore, MD</p>
                <textarea v-model="question_text" placeholder="What do you want to ask DeRay?"></textarea>
                <button class="default-btn" :disabled="question_text == ''">Submit</button>
            </div>
        </div>
    </div>
</template>
