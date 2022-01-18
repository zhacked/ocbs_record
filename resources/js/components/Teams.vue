<template>
    <v-app>
        <v-container>
            <v-row class="mt-5 is-blurred" v-if="$gate.isAdmin()">
                <v-col class="col-md-12">
                    <v-card>
                        <v-card-title class="card-header">
                            Team Management
                            <v-spacer></v-spacer>
                            <v-card-actions class="card-tools">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="success"
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                            class="mx-2"
                                            @click.stop="openNewTeam"
                                        >
                                            <v-icon
                                                >mdi-account-multiple-plus</v-icon
                                            >
                                        </v-btn>
                                    </template>
                                    <span>Add New Team</span>
                                </v-tooltip>
                            </v-card-actions>
                        </v-card-title>

                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            class="mx-4"
                        ></v-text-field>

                        <v-data-table
                            :headers="headers"
                            :items-per-page="10"
                            :search="search"
                            :items="teams"
                            class="elevation-1 text-center"
                        >
                            <!-- <template v-slot:[`item.modify`]="{ item }">
                                    {{item.updated_at | myDate }}
                                </template> -->
                            <template v-slot:[`item.actions`]="{ item }" >
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="primary"
                                            class="mx-2"
                                            icon
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                            @click="editDialog(item)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </v-btn>
                                    </template>
                                    <span>Edit Team</span>
                                </v-tooltip>
                                |
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="red"
                                            dark
                                            icon
                                            v-bind="attrs"
                                            v-on="on"
                                            class="mx-2"
                                            @click="deleteDialog(item.id)"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </v-btn>
                                    </template>
                                    <span>Delete Team</span>
                                </v-tooltip>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-col>
            </v-row>

            <!-- Modal -->
            <v-dialog
                transition="dialog-bottom-transition"
                max-width="400"
                v-model="openDialog"
            >
                <v-card>
                    <v-toolbar elevation="0">
                          <v-toolbar-title class="text-h6 pl-0">
              Team
            </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn

                                    medium
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="openDialog = false"
                                >
                                    <v-icon medium>mdi-close</v-icon>
                                </v-btn>
                            </template>
                            <span>Close Modal</span>
                        </v-tooltip>
                    </v-toolbar>

                    <v-card-text>

                             <v-text-field
                                    v-model="team.name"
                                    label="Team Name"
                                    placeholder="Emerald"
                                    outlined
                                    required
                                     prepend-inner-icon="mdi-account-group"
                            ></v-text-field>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn color="success" @click="createNewTeam"><v-icon>mdi-plus</v-icon> Add</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            headers: [
                { text: "No", value: "id" },
                { text: "Name", value: "name" },
                { text: "", value: "actions", sortable: false },
            ],
            search: "",
            openDialog: false,
            team: {
                name: ''
            },
            teams:[],
        };
    },
    methods: {
        loadTeam(){
             axios.get('api/teams').then((data)=>{
                    console.log('teams',data);
                    this.teams = data.data;

                });
        },
        openNewTeam() {
            this.openDialog = true;
            // this.form.reset();
            // $('#addNew').modal('show');
        },
        createNewTeam(){
            console.log()
            axios.post("api/teams",this.team).then((data) => {
                 console.log(data)
                      Fire.$emit('AfterCreate');
                      Toast.fire({
                        icon: 'success',
                        title: 'Team Added in successfully'
                        })
                        this.openDialog = false
            })
        }

    },
    created() {
        this.loadTeam();
        Fire.$on("AfterCreate", () => {
            this.loadTeam();
        });
    },
};
</script>
