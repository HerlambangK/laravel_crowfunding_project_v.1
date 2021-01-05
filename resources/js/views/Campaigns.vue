<template>
    <div>
        <v-container class="ma-0 pa-0" grid-list-sm>
            <v-subheader>
                All Campaigns
            </v-subheader>

            <v-layout wrap>
                <v-flex
                    v-for="campaign in campaigns"
                    :key="`campaign-` + campaign.id"
                    xs6
                >
                    <!-- <v-card :to="'/campagin/' + campaign.id">
                        <v-img
                            :src="campaign.image"
                            class="black--text"
                            max-height="350px"
                        >
                            <v-card-title
                                class="fill-height align-end"
                                v-text="campaign.title"
                            >
                            </v-card-title>
                        </v-img>
                    </v-card> -->
                    <campagin-item :campaign="campaign" />
                </v-flex>
            </v-layout>
            <v-pagination
                v-model="page"
                class="mt-12"
                @input="go"
                :length="lenghtPage"
                :total-visible="6"
            >
            </v-pagination>
        </v-container>
    </div>
</template>

<script>
export default {
    data: () => ({
        campaigns: [],
        page: 0,
        lenghtPage: 0
    }),

    components: {
        CampaginItem: () => import("../components/CampaignItem.vue")
    },
    created() {
        this.go();
    },

    methods: {
        go() {
            let url = "api/campaign/?page=" + this.page;
            axios
                .get(url)
                .then(response => {
                    let { data } = response.data;
                    console.log(data);
                    this.campaigns = data.campaigns.data;
                    this.page = data.campaigns.current_page;
                    this.lenghtPage = data.campaigns.last_page;
                    console.log(data.campaigns);
                })

                .catch(error => {
                    let { response } = error;
                    console.log(response);
                });
        }
    }
};
</script>

<style></style>
