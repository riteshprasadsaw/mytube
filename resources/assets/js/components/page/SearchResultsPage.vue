<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Search Results for :
                    </div>
    
                    <div class="panel-body">
                        <div class="row">
                            <div v-for="video in results" class="video-grid col-xs-6 col-sm-4 col-md-3">
                                <div class="video">
    
                                    <div class="thumbnail">
                                        <router-link :to="{ name: 'VideoDetailPage', params: { id: video.id, slug: $root.slug(video.title) }}">
                                            <img :src="video.thumbnail" :alt="video.title">
                                        </router-link>
                                    </div>
    
                                    <div class="caption">
                                        <h3>
                                            <router-link :to="{ name: 'VideoDetailPage', params: { id: video.id, slug: $root.slug(video.title) }}">
                                                {{ video.title }}
                                            </router-link>
                                        </h3>
                                        <p>
                                            <!--  <router-link :to="{ name: 'ChannelPage', params: {id: video.channel_id, slug: $root.slug(video.channel_id)}}">
                                                                    {{ video.channel_id }}
                                                                </router-link> -->
                                            <br> {{ video.views }} views &bull; {{ video.created_at }}</p>
                                    </div>
    
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    props: ['videos'],

    data() {
        return {

            results: []

        }
    },

    created() {
        this.$eventBus.$on('searchVideo', this.onReceive);

    },
    mounted() {
        console.log('Search Results page mounted');
        // bus.$on('searchVideo', function (videos) {
        //    console.log(this.videos);
        //    alert('seacrh oage');
        // })
    },

    methods: {

        onReceive(videos) {

            // alert('searrh'+videos);
            // console.log(text);
            this.results = videos;
            console.log(this.results);
        }

    }
}
</script>