<template id="feature-template">
    <div class="featured">
        <img v-bind:src="user.profile_image">
        <h1>@{{ name }}</h1>
        <h2>@{{ user.location }}</h2>
        <p>@{{ user.description }}</p>
    </div>
</template>
