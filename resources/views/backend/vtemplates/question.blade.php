<template id="question-template">
  <li class="list-group-item">
    <i class="fa fa-chevron-up" @click="upvote" :class="{disabled: upvoted}"></i>
    <span class="label label-primary">@{{ votes }}</span>
    <i class="fa fa-chevron-down" @click="downvote" :class="{disabled: downvoted}"></i>
    <a>@{{ question.text }}</p
  </li>
</template>
