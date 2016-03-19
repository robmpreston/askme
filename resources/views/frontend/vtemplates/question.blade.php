<template id="question-template">
    <div class="vote-block">
        <i class="fa fa-caret-up" @click="upvote(question.id)" :class="{disabled: upvoted}"></i>
        <p>@{{ votes }}</p>
        <i class="fa fa-caret-down" @click="downvote(question.id)" :class="{disabled: downvoted}"></i>
    </div>
    <div class="qa-container">
        <div class="row">
            <div class="col-md-12">
                <div class="question-container">
                    <p><img src="/"> Derek From Baltimore</p>
                    <p>@{{ question.text_response }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <answer v-if="question.answer != null" :answer="question.answer"></answer>
            </div>
        </div>
    </div>
</template>
