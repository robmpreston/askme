<template id="answer-template">
    <div class="answer container">
        <header>
            <img :src="recipient.picture">
            <p><span class="faded-text">Reply from</span> @{{ recipient.first_name }}</p>
        </header>
        <article>
            <p>@{{ answer.text_response }}</p>
        </article>
        <div class="like-block">
            <p>
                <svg class="svg-icon thumbs-up" style="margin-right:1px" @click="like(answer.id)" v-show="answer.upvoted"><use xlink:href="#like-static-icon"></use></svg>
                <svg class="svg-icon thumbs-up" style="margin-left:1px" @click="like(answer.id)" v-show="!answer.upvoted"><use xlink:href="#like-focus-icon"></use></svg>
                @{{ answer.net_votes }}
                <a class="social button" v-if="isAdmin" @click="editAnswer" href="#">Edit</a>
            </p>
        </div>
    </div>
</template>
