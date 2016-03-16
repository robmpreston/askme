<template id="answer-template">
  <li class="list-group-item">
    <i class="fa fa-chevron-up" @click="upvote" :class="{disabled: upvoted}"></i>
    <span class="label label-primary">@{{ votes }}</span>
    <p>@{{ answer.text }}</p>
  </li>
</template>
