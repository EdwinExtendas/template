<template>
    <div>
        <section>
            <v-container py-0>
                <v-layout wrap>
                    <v-flex xs12 md4 >
                        <v-text-field
                                v-model="api.name"
                                :rules="validate.text"
                                label="Name"
                                required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4 >
                        <v-text-field
                                v-model="api.fo_api_code"
                                :rules="validate.text"
                                label="Fuel Office api code"
                                required
                        ></v-text-field>
                    </v-flex>


                    <v-flex xs12 md4 >
                        <v-text-field
                                v-model="api.payment_type"
                                :rules="validate.text"
                                label="Payment type"
                                required
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-container>
        </section>

        <section v-if="!api.id">
            <v-container py-0>
                <v-layout wrap>
                    <v-flex xs12 md6 >
                        <v-text-field
                                v-model="api.user_client_id"
                                :rules="validate.text"
                                label="MobyPay User client ID"
                                required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md6 >
                        <v-text-field
                                v-model="api.client_id"
                                :rules="validate.text"
                                label="MobyPay client ID"
                                required
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md6 >
                        <v-text-field
                                v-model="api.client_secret"
                                :rules="validate.text"
                                label="MobyPay client secret"
                                required
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12 md6 >
                        <v-text-field
                                v-model="api.grant_type"
                                :rules="validate.text"
                                label="MobyPay grant type"
                                required
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-container>
        </section>
    </div>
</template>

<script>
    import validation from "../../../utils/validation";

    export default {
        name: "Crud",
        data: () => ({
            validate: validation,
            api: {
                name: '',
                fo_api_code: '',
                payment_type: '',
                user_client_id: '',
                client_id: '',
                client_secret: '',
                grant_type: ''
            }
        }),
    }
</script>

<style scoped>

</style>
