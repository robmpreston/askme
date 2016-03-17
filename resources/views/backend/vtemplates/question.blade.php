<template id="question-template">
    <div class="list-group-item">
        <i class="fa fa-chevron-up" @click="upvote" :class="{disabled: upvoted}"></i>
        <span class="label label-primary">@{{ votes }}</span>
        <i class="fa fa-chevron-down" @click="downvote" :class="{disabled: downvoted}"></i>
        <p>@{{ question.text }}</p>
        <answer :answer="question.answer"></answer>
    </div>
</template>
