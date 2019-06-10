<template>
    <div>
        <p>hi
            {{point_of_service.name}}</p>
        <v-btn @click="test"></v-btn>
    </div>
</template>

<script>
    export default {
        name: "Edit",
        data() {
          return {
              point_of_service: {}
          }
        },
        mounted: function() {
            this.$http.get(`/api/point_of_services/${this.$route.params.id}`)
            .then(
                (response) => {
                    this.point_of_service = response.data;
                }
            )
            .catch(
                (error) => {
                    this.$toasted.global.error(error.response.data.message);
                    this.$router.push({name:'point_of_service'});
                }
            );

        },
        methods: {
            test: function() {
                this.$toasted.global.success(`You've successfully updated the Point of Service`);
            }
        }
    }
</script>

<style scoped>

</style>
