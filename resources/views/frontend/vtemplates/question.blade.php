<template id="question-template">
    <div id="question-@{{ question.id }}">
        <div class="vote-block">
            <div class="up vote">
                <svg class="svg-icon static"><use xlink:href="#up-static-icon"></use></svg>
                <svg class="svg-icon focus"><use xlink:href="#up-focus-icon"></use></svg>
                <svg class="svg-icon hover"><use xlink:href="#up-hover-icon"></use></svg>
            </div>
            <p>@{{ votes }}</p>
            <div class="down vote">
                <svg class="svg-icon static"><use xlink:href="#down-static-icon"></use></svg>
                <svg class="svg-icon focus"><use xlink:href="#down-focus-icon"></use></svg>
                <svg class="svg-icon hover"><use xlink:href="#down-hover-icon"></use></svg>
            </div>
        </div>
        <div class="qa-container">
            <div class="question container">
                <header>
                    <img :src="question.asker.picture">
                    <p>@{{ question.asker.first_name }} <span class="faded-text">from</span> @{{ question.asker.from }}</p>
                </header>
                <article>
                    <p>@{{ question.text_response }}</p>
                </article>
                <article>
                    <a class="social button" v-if="isAdmin" @click="editProfile" href="#">Reply</a>
                </article>
            </div>
            <answer v-if="question.answer != null" :answer="question.answer"
                :recipient="recipient" :logged-in.sync="loggedIn" :is-admin="isAdmin"></answer>
            <div class="social-container">
                <tweet :link="shareUrl" text="Ask me"></tweet>
                <fbshare :link="shareUrl" text="Ask me"></fbshare>
                <a class="social button" v-if="isAdmin" @click="hide" href="#">Hide</a>
            </div>
        </div>
    </div>
</template>
