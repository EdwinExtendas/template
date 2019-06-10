<template>
  <v-container
    fill-height
    fluid
    grid-list-xl
  >
    <v-layout
      justify-center
      wrap
    >
      <v-flex
        md12
      >
        <material-card
          color="green"
          title="Points of Service"
          text="Here is a subtitle for this table"
        >
          <v-card-title>
            <v-spacer></v-spacer>
            <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
            ></v-text-field>
          </v-card-title>
          <v-data-table
                  :headers="headers"
                  :items="point_of_service"
                  :search="search"
          >
            <template v-slot:items="props">
              <td >{{ props.item.name }}</td>
              <td >{{ props.item.address.city }}</td>
              <td >{{ props.item.address.zip_code }}</td>
              <td >
                <v-icon
                  small
                  class="mr-2"
                  @click="editItem(props.item)"
                >
                  mdi-pencil
                </v-icon>
              </td>
            </template>
            <template v-slot:no-results>
              <v-alert :value="true" color="error" icon="warning">
                Your search for "{{ search }}" found no results.
              </v-alert>
            </template>
          </v-data-table>
        </material-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    search: '',
    headers: [
      { text: 'Locatie naam', value: 'name' },
      { text: 'Stad', value: 'address.city' },
      { text: 'Zip code', value: 'address.zip_code' },
      { text: 'Actions', value: 'name', sortable: false }
    ],
    point_of_service: []
  }),
  mounted: function() {
    this.$http.get('/api/point_of_services')
      .then(
        (response) => {
          this.point_of_service = response.data;
        }
      );
  },
  methods: {
    editItem(item) {
      this.$router.push({name: 'point_of_service_edit', params: {id: item.id}})
    }
  }
}
</script>
