<template id="ask-template">
    <div class="ask-input container" v-show="!open">
        <input type="text" placeholder="What do you want to ask @{{ recipient.first_name }}?" v-model="question" @click="toggle">
    </div>
    <div class="ask container open" v-show="open">
        <header>
            <img :src="user.picture">
            <p>@{{ user.first_name }} <span class="faded-text">from</span> @{{ user.from }}</p>
        </header>
        <textarea v-model="question_text" placeholder="What do you want to ask @{{ recipient.first_name }}?"></textarea>
        <button class="ghost button" :disabled="question_text == ''" @click="sendQuestion">Submit</button>
    </div>
</template>
