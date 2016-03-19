<template id="question-template">
    <div class="vote-block">
        <i class="fa fa-caret-up" @click="upvote(question.id)" :class="{disabled: upvoted}"></i>
        <p>@{{ votes }}</p>
        <i class="fa fa-caret-down" @click="downvote(question.id)" :class="{disabled: downvoted}"></i>
    </div>
    <div class="qa-container">
        <div class="question-container">
            <p><img :src="question.asker.picture"> Derek <span class="faded-text">from</span> Baltimore</p>
            <p>@{{ question.text_response }}</p>
        </div>
        <answer v-if="question.answer != null" :answer="question.answer" :recipient="recipient"></answer>
    </div>
</template>
