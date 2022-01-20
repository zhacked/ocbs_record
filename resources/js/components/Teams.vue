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
                                            @click.stop="viewTeam = true"
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
                            <template v-slot:[`item.actions`]="{ item }">
                                <v-tooltip color="primary" bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="primary"
                                            class="mx-2"
                                            icon
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                            @click="openViewTeam(item)"
                                        >
                                            <v-icon>mdi-view-column</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>View {{ item.name }}</span>
                                </v-tooltip>

                                <v-tooltip color="yellow darken-4" bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="yellow darken-4"
                                            class="mx-2"
                                            icon
                                            dark
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </v-btn>
                                    </template>
                                    <span>Edit {{ item.name }}</span>
                                </v-tooltip>

                                <v-tooltip color="error" bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="error"
                                            dark
                                            icon
                                            v-bind="attrs"
                                            v-on="on"
                                            class="mx-2"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </v-btn>
                                    </template>
                                    <span>Delete {{ item.name }}</span>
                                </v-tooltip>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-col>
            </v-row>
            <!-- <v-dialog
                v-model="viewTeam"
                fullscreen
                hide-overlay
                transition="dialog-bottom-transition"
                style="z-index: 9999"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" dark v-bind="attrs" v-on="on">
                        Open Dialog
                    </v-btn>
                </template>
                <v-card>
                    <v-toolbar dark color="primary">
                        <v-btn icon dark @click="closeViewTeam">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title>{{team.name}}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark text @click="closeViewTeam">
                                Save
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-list three-line subheader>
                        <v-subheader>User Controls</v-subheader>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title
                                    >Content filtering</v-list-item-title
                                >
                                <v-list-item-subtitle
                                    >Set the content filtering level to restrict
                                    apps that can be
                                    downloaded</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title>Password</v-list-item-title>
                                <v-list-item-subtitle
                                    >Require password for purchase or use
                                    password to restrict
                                    purchase</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                 
                </v-card>
            </v-dialog> -->
            <team-management :viewTeam.sync="viewTeam" :selectedTeam.sync="selectedTeam" :arenaTeams.sync="arenaTeams" :teams="teams" :getAllArenaPerTeam="getAllArenaPerTeam"></team-management>
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
                        <v-btn color="success" @click="createNewTeam"
                            ><v-icon>mdi-plus</v-icon> Add</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </v-app>
</template>

<script>
import TeamManagement from './Team/Management.vue'
export default {
    components: {TeamManagement},
    data() {
        return {
            headers: [
                { text: "No", value: "id" },
                { text: "Name", value: "name" },
                { text: "", value: "actions", sortable: false },
            ],
            search: "",
            openDialog: false,
            viewTeam: false,
            team: {
                name: "",
            },
            teams: [],
            arenaTeams: [],
            selectedTeam: {
                name: ""
            }
        };
    },
    methods: {
        loadTeam() {
            axios.get("api/teams").then(({data}) => {
                data.forEach(d => {
                   this.teams.push({ ...d,
                    name: d.name.toUpperCase()})
                })
              
            });
        },
        openNewTeam() {
            this.openDialog = true;
           
        },
         async getAllArenaPerTeam(){
            const arenaTeams = await axios.get('api/getArenaTeam/'+this.selectedTeam.name);
            arenaTeams.data.forEach(a => {
                this.arenaTeams.push({ ...a, team: a.team.toUpperCase()})
            })
        
        },
        openViewTeam(item){
            this.viewTeam = true;
            this.selectedTeam = item
            this.getAllArenaPerTeam(item)
        },
      
        createNewTeam() {
           
            axios.post("api/teams", this.team).then((data) => {
                console.log(data);
                Fire.$emit("AfterCreate");
                Toast.fire({
                    icon: "success",
                    title: "Team Added in successfully",
                });
                this.openDialog = false;
            });
        },
        
    },
    created() {
        this.loadTeam();
        // Fire.$on("AfterCreate", () => {
        //     this.loadTeam();
        // });
    },
};
</script>
