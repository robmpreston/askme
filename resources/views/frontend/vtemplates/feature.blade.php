<template id="feature-template">
    <div class="featured" v-if="!editing">
        <div class="info">
            <div class="avatar-container">
                <img class="avatar" :src="user.picture">
            </div>
            <article>
                <p class="info">@{{ name }}, <span class="grey-text">@{{ user.profile.i_am_a }}</span> <span class="faded-text">from</span> <span class="grey-text">@{{ user.from }}</span></p>
                <p class="description">@{{ user.profile.description }}</p>
            </article>
        </div>
        <div class="ama-topic">
            <p>Next AMA: Friday, April 1st<!-- @{{ topic.opens_at | moment "dddd, MMM Do h:mm a" }}--></p>
            <p>Topic will be @{{ topic.name }}</p>
        </div>
        <!--
        <div class="ama-topic" v-else>
            <p>@{{ user.first_name }} is live taking your questions!</p>
            <p>Today's topic is @{{ topic.name }}</p>
        </div>
        -->
        <div class="social-container">
            <a class="social button website" v-if="user.profile.website_url != ''" :href="user.profile.website_url" target="_blank"><i class="fa fa-external-link"></i> Website</a>
            <a class="social button" v-if="user.profile.twitter_url != ''" :href="user.profile.twitter_url" target="_blank"><i class="fa fa-twitter"></i> Twitter</a>
            <a class="social button" v-if="user.profile.facebook_url != ''" :href="user.profile.facebook_url" target="_blank"><i class="fa fa-facebook-official"></i> Facebook</a>
            <a class="social button" v-if="isAdmin" @click="editProfile">Edit Profile</a>
        </div>
    </div>
    <div class="featured" v-if="editing == true">
        <div class="info">
            <div class="avatar-container">
                <img class="avatar" :src="user.picture">
                <p class="edit-text">Change</p>
            </div>
            <article>
                <div class="row">
                    <div class="half column padding">
                        <input type="text" v-model="user.first_name" placeholder="First name">
                    </div>
                    <div class="half column padding">
                        <input class="fifty" type="text" v-model="user.last_name" placeholder="Last name">
                    </div>
                </div>
                <div class="row">
                    <div class="half column padding">
                        <input type="text" v-model="user.profile.i_am_a" placeholder="I am a">
                    </div>
                    <div class="half column padding">
                        <input class="fifty" type="text" v-model="user.from" placeholder="I am from">
                    </div>
                </div>
                <textarea v-model="user.profile.description" placeholder="Description"></textarea>
            </article>
        </div>
        <div class="social-container">
            <a class="social button website" v-if="user.profile.website_url != ''" :href="user.profile.website_url" target="_blank"><i class="fa fa-external-link"></i> Website</a>
            <a class="social button" v-if="user.profile.twitter_url != ''" :href="user.profile.twitter_url" target="_blank"><i class="fa fa-twitter"></i> Twitter</a>
            <a class="social button" v-if="user.profile.facebook_url != ''" :href="user.profile.facebook_url" target="_blank"><i class="fa fa-facebook-official"></i> Facebook</a>
            <a class="social button" v-if="isAdmin" @click="saveProfile">Save Profile</a>
        </div>
    </div>
</template>
