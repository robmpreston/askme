<template id="question-template">
    <div class="outer-question-container" id="question-@{{ question.id }}">
        <div class="vote-block">
            <div class="up vote" @click="upvote(question.id)" :class="{disabled: question.upvoted}">
            </div>
            <p>@{{ question.net_votes }}</p>
            <div class="down vote" @click="downvote(question.id)" :class="{disabled: question.downvoted}">
            </div>
        </div>
        <div class="qa-container">
            <div class="question container">
                <header>
                    <img :src="question.asker.picture">
                    <p>@{{ question.asker.first_name }} <span class="faded-text" v-if="question.asker.from != ''">from</span> @{{ question.asker.from }}</p>
                    <p class="date pull-right">@{{ question.created_at | moment "from" }}</p>
                </header>
                <article>
                    <p>@{{ question.text_response }}</p>
                </article>
                <article class="reply">
                    <a class="small ghost button" v-if="isAdmin && question.answer == null && !replyOpen" @click="reply">Reply</a>
                </article>
            </div>
            <answer v-if="question.answer != null" :answer="question.answer"
                :recipient="recipient" :logged-in.sync="loggedIn" :is-admin="isAdmin"></answer>
            <div v-if="replyOpen" class="answer container">
                <header>
                    <img :src="recipient.picture" />
                    <p><span class="faded-text">Reply from</span> @{{ recipient.first_name }}</p>
                </header>
                <article>
                    <textarea v-model="answerText" placeholder="Type your response"></textarea>
                    <input type="text" v-model="answerVideo" placeholder="Youtube video (i.e. https://www.youtube.com/watch?v=qffCO1b-7Js)">
                </article>
                <div class="like-block">
                    <p>
                        <a class="small ghost button" @click="submitAnswer">Submit</a>
                        <a class="small ghost button" @click="cancelAnswer">Cancel</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="social-container">
            <tweet :link="shareUrl" text="Ask me"></tweet>
            <fbshare :link="shareUrl" text="Ask me"></fbshare>
            <a class="social button" v-if="isAdmin" @click="hide">Hide</a>
        </div>
    </div>
</template>
