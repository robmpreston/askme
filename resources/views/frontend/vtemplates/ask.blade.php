<template id="ask-template">
    <div class="ask container" v-show="!open">
        <input type="text" placeholder="What do you want to ask DeRay?" v-model="question" @click="toggle">
    </div>
    <div class="ask container open" v-show="open">
        <header>
            <img src="https://scontent-iad3-1.xx.fbcdn.net/hphotos-xpf1/t31.0-8/10958213_10102009617158085_40595606642539929_o.jpg">
            <p>John <span class="faded-text">from</span> Baltimore, MD</p>
        </header>
        <textarea v-model="question_text" placeholder="What do you want to ask DeRay?"></textarea>
        <button class="ghost button" :disabled="question_text == ''">Submit</button>
    </div>
</template>
