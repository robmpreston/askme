<template id="question-template">
    <div class="row">
        <div class="col-md-1">
            <div class="vote-block">
                <i class="fa fa-caret-up" @click="upvote" :class="{disabled: upvoted}"></i>
                <p>@{{ votes }}</p>
                <i class="fa fa-caret-down" @click="downvote" :class="{disabled: downvoted}"></i>
            </div>
        </div>
        <div class="col-md-10">
            <div class="qa-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="question-container">
                            <p>@{{ question.text }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <answer :answer="question.answer"></answer>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
</template>
