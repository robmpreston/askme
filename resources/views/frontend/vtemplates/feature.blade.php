<template id="feature-template">
    <img v-bind:src="feature.profile_image">
    <h1>{{ name }}</h1>
    <h2>{{ feature.location }}</h2>
    <p>{{ feature.description }}</p>
</template>
