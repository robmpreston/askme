<template id="question-template">
  <li class="list-group-item">
    <i class="glyphicon glyphicon-chevron-up" @click="upvote" :class="{disabled: upvoted}"></i>
    <span class="label label-primary">@{{ votes }}</span>
    <i class="glyphicon glyphicon-chevron-down" @click="downvote" :class="{disabled: downvoted}"></i>
    <a>@{{ text }}</p
  </li>
</template>
