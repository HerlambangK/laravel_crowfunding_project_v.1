<template>
    <div v-if="campaign.id">
        <v-img :src="campaign.image" class="blue--text" max-height="500px">
            <v-card-title class="fill-height align-end" v-text="campaign.title">
            </v-card-title>
        </v-img>

        <v-card-text>
            <v-simple-table dense>
                <tbody>
                    <tr>
                        <td><v-icon>mdi-home-city</v-icon>Alamat</td>
                        <td>{{ campaign.address }}</td>
                    </tr>
                    <tr>
                        <td><v-icon>mdi-hand-heart</v-icon>Terkumpul</td>
                        <td class="blue--text">
                            Rp {{ campaign.collected.toLocaleString("id-ID") }}
                        </td>
                    </tr>
                    <tr>
                        <td><v-icon>mdi-cash</v-icon>Dibutuhkan</td>
                        <td class="orange--text">
                            Rp {{ campaign.required.toLocaleString("id-ID") }}
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>
            Description:<br />
            {{ campaign.description }}
        </v-card-text>
        <v-card-actions>
            <v-btn
                block
                color="primary"
                @click="donate"
                :disabled="campaign.collected >= campaign.required"
            >
                <v-icon>mdi-money</v-icon> &nbsp; DONATE
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
import { mapActions, mapMutations } from "vuex";
export default {
    data: () => ({
        campaign: {}
    }),

    created() {
        this.go();
    },

    methods: {
        go() {
            let { id } = this.$route.params;
            let url = "/api/campaign/" + id;
            // console.log(this.$route.params);
            axios
                .get(url)
                .then(response => {
                    let { data } = response.data;
                    console.log(data);
                    this.campaign = data.campaign;
                    console.log(this.campaign);
                    console.log(data.campaign);
                })

                .catch(error => {
                    let { response } = error;
                    console.log(response);
                });
        },
        // donate() {
        //     this.$store.commit("insert");
        // }
        // ...mapMutations({
        //     donate: "transaction/insert"
        // }),
        ...mapMutations({
            tambahTransaksi: "transaction/insert"
        }),
        ...mapActions({
            setAlert: "alert/set"
        }),

        donate() {
            this.tambahTransaksi();
            this.setAlert({
                status: true,
                color: "success",
                text: "Transaksi berhasil ditambahkan"
            });
        }
    }
};
</script>

<style></style>
