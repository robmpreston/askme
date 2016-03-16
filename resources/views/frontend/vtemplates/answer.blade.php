<template id="answer-template">
    <div class="answer-container">
        <p>@{{ answer.text }}</p>
        <div class="like-block">
            <p><i class="fa fa-thumbs-o-up fa-2x like-btn-outline" @click="upvote" v-show="!upvoted"></i><i class="fa fa-thumbs-up fa-2x like-btn" @click="upvote" v-show="upvoted"></i> @{{ votes }}</p>
        </div>
    </div>
</template>
