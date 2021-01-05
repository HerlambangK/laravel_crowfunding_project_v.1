<template>
    <!-- App.vue -->

    <v-app>
        <alert></alert>
        <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            transition="scale-transition"
        >
            <search @closed="closeDialog" />
        </v-dialog>
        <v-navigation-drawer app v-model="drawer">
            <!-- -->

            <v-list>
                <v-list-item v-if="!guest">
                    <v-list-item-avatar>
                        <v-img
                            src="https://randomuser.me/api/portraits/men/78.jpg"
                        ></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title>Jhon chena</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <div class="pa-2" v-if="guest">
                    <v-btn block color="primary" class="mb-1">
                        <v-icon left>
                            mdi-lock
                        </v-icon>
                        login
                    </v-btn>
                    <v-btn block color="success">
                        <v-icon left>
                            mdi-account
                        </v-icon>
                        Register
                    </v-btn>
                </div>

                <v-divider></v-divider>

                <v-list-item
                    v-for="(item, index) in menus"
                    :key="`menu-` + index"
                    :to="item.route"
                >
                    <v-list-item-icon>
                        <v-icon left>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>
                            {{ item.title }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <template v-slot:append v-if="!guest">
                <div class="pa-2">
                    <v-btn block color="red" dark>
                        <v-icon left> mdi-lock</v-icon>
                        Logout
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <!-- //untuk home -->
        <v-app-bar app color="success" dark v-if="isHome">
            <!-- -->
            <!-- <h1>Header</h1> -->
            <v-app-bar-nav-icon @click.stop="drawer = !drawer">
            </v-app-bar-nav-icon>

            <v-toolbar-title>
                Donasi Kita
            </v-toolbar-title>

            <!-- pemisah konten -->
            <v-spacer></v-spacer>

            <v-btn icon>
                <v-badge color="orange" overlap v-if="transactions > 0">
                    <template v-slot:badge>
                        <span>
                            {{ transactions }}
                        </span>
                    </template>
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
                <v-icon v-else>mdi-cash-multiple</v-icon>
            </v-btn>

            <v-text-field
                slot="extension"
                hide-details
                append-icon="mdi-microphone"
                flat
                label="Cari"
                prepend-inner-icon="mdi-magnify"
                solo-inverted
                @click.stop="dialog = true"
            >
            </v-text-field>
        </v-app-bar>
        <!-- selain home -->
        <v-app-bar app color="success" dark v-else>
            <v-btn icon @click.stop="$router.go(-1)">
                <v-icon>mdi-arrow-left-circle</v-icon>
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn icon>
                <v-badge color="orange" overlap v-if="transactions > 0">
                    <template v-slot:badge>
                        <span>
                            {{ transactions }}
                        </span>
                    </template>
                    <v-icon>mdi-cash-multiple</v-icon>
                </v-badge>
                <v-icon v-else>mdi-cash-multiple</v-icon>
            </v-btn>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- If using vue-router -->
                <v-slide-y-transition>
                    <router-view></router-view>
                </v-slide-y-transition>
            </v-container>
        </v-main>

        <v-card>
            <v-footer absolute app>
                <!-- -->
                <v-card-text class="text-center">
                    &copy; {{ new Date().getFullYear() }} -
                    <strong>Donasi kita </strong>
                </v-card-text>
            </v-footer>
        </v-card>
    </v-app>
</template>

<script>
import { mapGetters } from "vuex";
import Alert from "./components/Alert.vue";
import Search from "./components/Search";
export default {
    components: { Alert, Search },
    name: "App",
    data: () => ({
        drawer: false,
        menus: [
            { title: "Home", icon: "mdi-home", route: "/" },
            { title: "Campaigns", icon: "mdi-hand-heart", route: "/campaigns" }
        ],
        guest: false,
        // snackbarStatus: false,
        // snackbarText: `Donasi Berhasil ditambahkan`
        dialog: false
    }),
    created() {
        console.log("component mounted app ");
    },
    computed: {
        isHome() {
            return this.$route.path === "/" || this.$route.path === "/home";
        },
        // transaction() {
        //     // console.log(this.$store);
        //     return this.$store.getters.transaction;
        // }
        ...mapGetters({
            transactions: "transaction/transactions"
        })
    },
    methods: {
        closeDialog(value) {
            this.dialog = value;
        }
    },

    mounted() {}
};
</script>

<style></style>
