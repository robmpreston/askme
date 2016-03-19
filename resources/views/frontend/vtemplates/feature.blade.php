<template id="feature-template">
    <div class="featured">
        <div class="row">
            <div class="col-md-1 text-right">
                <img :src="user.picture">
            </div>
            <div class="col-md-11">
                <div class="info">
                    <p>I am @{{ name }}, <span class="grey-text">@{{ user.profile.i_am_a }}</span> <span class="faded-text">from</span> <span class="grey-text">@{{ user.from }}</span></p>
                    <p class="description">@{{ user.profile.description }}</p>
                    <p>
                        <a v-if="user.profile.website_url != ''" :href="user.profile.website_url" target="_blank"><i class="fa fa-external-link"></i></a>
                        <a v-if="user.profile.facebook_url != ''" :href="user.profile.facebook_url" target="_blank"><i class="fa fa-facebook-official"></i></a>
                        <a v-if="user.profile.twitter_url != ''" :href="user.profile.twitter_url" target="_blank"><i class="fa fa-twitter"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
