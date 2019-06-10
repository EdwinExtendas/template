<template>
    <v-app id="inspire">
        <v-content>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-12">
                            <v-toolbar dark color="primary">
                                <v-toolbar-title>Login form</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-tooltip bottom>
                                    <span>Source</span>
                                </v-tooltip>
                            </v-toolbar>
                            <v-card-text>
                                <v-alert
                                    :value="this.error.status"
                                    type="error"
                                >
                                    <strong>Uw gebruikersnaam of wachtwoord is onjuist.</strong><br>
                                    {{this.error.message}}
                                </v-alert>
                                <v-form>
                                    <v-text-field v-model="username" prepend-icon="mdi-account" name="login" label="Login" type="text"></v-text-field>
                                    <v-text-field v-model="password" prepend-icon="mdi-lock-outline" name="password" label="Password" id="password" type="password"></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="green" @click="signIn">Login</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>

<!--            <span class="x10-copyright-child">-->
<!--                &copy; {{year}} <strong>LekkerOpWeg</strong> Powered by <a href="http://www.extendas.com" target="_blank">Extendas</a>-->
<!--            </span>-->
</template>
<script>
    import CookieHelper from "../helpers/CookieHelper";

    export default {
        name: 'Login',
        data: function () {
            return {
                username: 'test',
                password: 'test',
                error: {
                    status: false,
                    message: ''
                },
                year:(new Date()).getFullYear()
            };
        },
        methods: {
            signIn: function () {
                this.$http.post(
                    'token/portal/login',
                    {username: this.username, password: this.password}
                ).then((response) => {
                    console.log(response);
                    this.$store.commit('setAuth', true);
                    this.$store.commit('setAdmin', CookieHelper.checkAdmin())
                    this.$router.push('dashboard');
                }).catch((error) => {
                    console.log(error.response);
                    this.error.status = true;
                    this.error.message = error.response.data.message;
                })
            }
        }
    }
</script>

<style>
</style>
