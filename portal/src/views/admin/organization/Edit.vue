<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap >
            <v-flex xs12 md12 >
                <material-card color="blue" title="Organization" text="Edit an Organization">

                    <v-form ref="form" lazy-validation>
                        <v-container py-0>

                            <crud ref="crud"></crud>

                            <v-btn
                                    color="blue"
                                    @click="submit"
                            >
                                Update
                            </v-btn>
                        </v-container>
                    </v-form>
                </material-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import Crud from "./Crud";

    export default {
        name: "Edit",
        components: {Crud},
        mounted: function() {
            this.$http.get(`/api/organization/${this.$route.params.id}`)
                .then(
                    (response) => {
                        this.$refs.crud.api = response.data;
                    }
                )
                .catch(
                    (error) => {
                        this.$toasted.global.error(error.response.data.message);
                        this.$router.push({name:'admin_organization'});
                    }
                );
        },
        methods: {
            submit () {
                if (!this.$refs.form.validate()) {
                    return;
                }

                let api_data = this.$refs.crud.api;
                this.$http.post(
                    `/api/organization/${this.$refs.crud.api.id}`,
                    JSON.stringify({name: api_data.name, fo_api_code: api_data.fo_api_code, payment_type: api_data.payment_type})
                )
                .then((response) => {
                    console.log(response);
                    this.$toasted.global.success(response.data.message);
                    this.$router.push({name: 'admin_organization'})
                })
                .catch((error) => {
                    this.$toasted.global.error(error.response.data.message);
                })
            }
        }
    }
</script>

<style scoped>

</style>
