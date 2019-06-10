<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap >
            <v-flex xs12 md12 >
                <material-card color="blue" title="Organization" text="Create an Organization">

                    <v-form ref="form" lazy-validation>
                        <v-container py-0>

                            <crud ref="crud"></crud>

                            <v-btn
                                color="blue"
                                @click="submit"
                            >
                                Create
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
        name: "Create",
        components: {Crud},
        methods: {
            submit () {
                if (!this.$refs.form.validate()) {
                    return;
                }
                console.log(this.$refs.crud.api);
                this.$http.post('/api/organization', JSON.stringify(this.$refs.crud.api))
                    .then((response) => {
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
