<template id="feature-template">
    <div class="featured">
        <div class="info">
            <div class="avatar-container">
                <img class="avatar" :src="user.picture">
            </div>
            <article>
                <p class="info">@{{ name }}, <span class="grey-text">@{{ user.profile.i_am_a }}</span> <span class="faded-text">from</span> <span class="grey-text">@{{ user.from }}</span></p>
                <p class="description">@{{ user.profile.description }}</p>
            </article>
        </div>
        <div class="social-container">
            <a class="social button website" v-if="user.profile.website_url != ''" :href="user.profile.website_url" target="_blank"><i class="fa fa-external-link"></i> Website</a>
            <a class="social button" v-if="user.profile.twitter_url != ''" :href="user.profile.twitter_url" target="_blank"><i class="fa fa-twitter"></i> Twitter</a>
            <a class="social button" v-if="user.profile.facebook_url != ''" :href="user.profile.facebook_url" target="_blank"><i class="fa fa-facebook-official"></i> Facebook</a>
        </div>
    </div>
</template>
