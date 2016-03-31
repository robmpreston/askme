<template id="ask-template">
    <div id="ask-container">
        <div class="ask-input container" v-show="!open && !asked">
            <input type="text" placeholder="What do you want to ask @{{ recipient.first_name }}?" v-model="question" @click="toggle">
        </div>
        <div class="asked">
            <header>
                <p v-show="asked">Your question has been submitted!</p>
            </header>
        </div>
        <div id="open-ask" class="ask container open" v-show="open">
            <header>
                <img :src="user.picture">
                <p>@{{ user.first_name }} <span class="faded-text">from</span> @{{ user.from }}</p>
            </header>
            <textarea v-model="question_text" v-el:question-text placeholder="What do you want to ask @{{ recipient.first_name }}?"></textarea>
            <p class="error-text" v-if="errorText != ''">@{{{ errorText }}}</p>
            <button class="ghost button" :disabled="question_text == ''" @click="sendQuestion">Submit</button>
            <button class="ghost button" @click="close">Cancel</button>
        </div>
    </div>
</template>
