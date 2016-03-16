<template id="feature-template">
    <div class="featured">
        <img v-bind:src="user.profile_image">
        <div class="info">
            <p>I am @{{ name }}, <span class="grey-text">@{{ title }}</span> <span class="faded-text">from</span> <span class="grey-text">@{{ user.location }}</span></p>
            <p>@{{ user.description }}</p>
        </div>
    </div>
</template>
