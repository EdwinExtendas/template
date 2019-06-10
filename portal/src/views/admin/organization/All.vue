<template>
    <v-container
            fill-height
            fluid
            grid-list-xl
            v-if="loaded"
    >
        <v-layout
                justify-center
                wrap
        >
            <v-flex
                    md12
            >
                <material-card
                        color="blue"
                        title="Organization"
                        text="Here is a subtitle for this table"
                >
                    <v-card-title>
                        <v-btn color="blue" @click="create"><v-icon small>mdi-account-plus</v-icon>Create</v-btn>
                        <v-spacer></v-spacer>
                        <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                        ></v-text-field>
                    </v-card-title>
                    <v-data-table
                            :headers="headers"
                            :items="organization"
                            :search="search"
                    >
                        <template v-slot:items="props">
                            <td >{{ props.item.name }}</td>
                            <td >{{ props.item.fo_api_code }}</td>
                            <td >{{ props.item.payment_type }}</td>
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
            loaded: false,
            search: '',
            headers: [
                { text: 'Name', value: 'name' },
                { text: 'Fuel Office API', value: 'fo_api_code' },
                { text: 'Payment type', value: 'payment_type' },
                { text: 'Actions', value: 'name', sortable: false }
            ],
            organization: []
        }),
        mounted: function() {
            this.$http.get('/api/organization')
                .then(
                    (response) => {
                        this.organization = response.data;
                        this.loaded = true;
                    }
                );
        },
        methods: {
            create() {
                this.$router.push({name: 'admin_organization_create'});
            },
            editItem(item) {
                this.$router.push({name: 'admin_organization_edit', params: {id: item.id}})
            }
        }
    }
</script>
