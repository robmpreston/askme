<template id="answer-template">
    <div class="answer container">
        <header>
            <img :src="recipient.picture">
            <p><span class="faded-text">Reply from</span> @{{ recipient.first_name }}</p>
        </header>
        <article>
            <p>@{{ answer.text_response }}</p>
            <div class="video-embed">
                <youtube v-if="answer.is_video" :video-id="answer.video_url"></youtube>
            </div>
        </article>
        <div class="like-block">
                <p class="like-icon">
                    <span v-show="!answer.liked">
                        <svg class="svg-icon thumbs-up static" style="margin-right:1px" @click="like(answer.id)" ><use xlink:href="#like-static-icon"></use></svg>
                        <svg class="svg-icon thumbs-up hover" style="margin-left:1px" @click="like(answer.id)"><use xlink:href="#like-hover-icon"></use></svg>
                    </span>
                    <svg class="svg-icon thumbs-up active" style="margin-left:1px" @click="like(answer.id)" v-show="answer.liked"><use xlink:href="#like-focus-icon"></use></svg>
                </p>
                <p class="votes">@{{ answer.net_votes }}</p>
                <p class="edit">
                    <a class="small ghost button" v-if="isAdmin" @click="editAnswer" href="#">Edit</a>
                </p>
            </p>
        </div>
    </div>
</template>
