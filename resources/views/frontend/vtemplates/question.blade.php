<template id="question-template">
    <div class="vote-block">
        <i class="fa fa-caret-up" @click="upvote(question.id)" :class="{disabled: upvoted}"></i>
        <p>@{{ votes }}</p>
        <i class="fa fa-caret-down" @click="downvote(question.id)" :class="{disabled: downvoted}"></i>
    </div>
    <div class="qa-container">
        <div class="question container">
            <header>
                <img :src="question.asker.picture">
                <p>Derek <span class="faded-text">from</span> Baltimore</p>
            </header>
            <article>
                <p>@{{ question.text_response }}</p>
            </article>
        </div>
        <answer v-if="question.answer != null" :answer="question.answer" :recipient="recipient"></answer>
        <div class="social-container">
            <a class="social button" href="https://twitter.com" target="_blank"><i class="fa fa-twitter"></i> Tweet</a>
            <a class="social button" href="https://facebook.com" target="_blank"><i class="fa fa-facebook-official"></i> Share</a>
        </div>
    </div>
</template>
