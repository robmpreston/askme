<template id="feature-template">
    <div class="featured">
        <div class="row">
            <div class="col-md-1 text-right">
                <img v-bind:src="user.profile_image">
            </div>
            <div class="col-md-11">
                <div class="info">
                    <p>I am @{{ name }}, <span class="grey-text">@{{ user.title }}</span> <span class="faded-text">from</span> <span class="grey-text">@{{ user.location }}</span></p>
                    <p class="description">@{{ user.description }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
