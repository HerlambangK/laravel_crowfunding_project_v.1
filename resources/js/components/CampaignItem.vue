<template>
    <div>
        <v-card :to="'/campagin/' + campaign.id">
            <v-img
                :src="campaign.image"
                class="black--text"
                max-height="300px"
                min-height="137px"
            >
                <v-card-title
                    class="fill-height align-end"
                    v-text="campaign.title"
                >
                </v-card-title>
            </v-img>
            <v-card-actions>
                <v-progress-linear
                    color="light-blue"
                    height="7"
                    v-model="progress"
                    striped
                ></v-progress-linear>
            </v-card-actions>
            <v-card-actions>
                <v-icon>mdi-cash</v-icon>
                <span>Rp {{ campaign.required.toLocaleString("id-ID") }}</span>
                <v-spacer></v-spacer>
                <span>{{ progress }}%</span>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "campagin-item",
    props: ["campaign"],
    computed: {
        progress() {
            return (this.campaign.collected / this.campaign.required) * 100;
        }
    },
    mounted() {
        console.log(this.campaign.id);
    }
};
</script>

<style>
.v-card__title {
    font-size: 12px;
    text-decoration: unset;
}
</style>
