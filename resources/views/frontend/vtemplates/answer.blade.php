<template id="answer-template">
    <div class="answer-container">
        <header>
            <img :src="recipient.picture">
            <p><span class="faded-text">Reply from</span> @{{ recipient.first_name }}</p>
        </header>
        <article>
            <p>@{{ answer.text_response }}</p>
        </article>
        <div class="like-block">
            <p>
                <i class="fa fa-thumbs-o-up fa-2x like-btn-outline" @click="like(answer.id)" v-show="!liked"></i>
                <i class="fa fa-thumbs-up fa-2x like-btn" @click="like(answer.id)" v-show="liked"></i> @{{ votes }}
            </p>
        </div>
    </div>
</template>
