<template lang="">
       <v-container>
             <v-dialog
                persistent
                v-model="viewTeam"
                fullscreen
                hide-overlay
                transition="dialog-bottom-transition"
                style="z-index: 20"
               
            >
                <v-card>
                    <v-toolbar elevation="0" dark color="primary" class="px-16">
                            <v-icon class="mr-4">mdi-group</v-icon>

                        <v-toolbar-title>{{selectedTeam && selectedTeam.name}}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark text @click.stop="closeViewTeam">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-card-text class="px-16">
                    <v-tabs
                        color="deep-purple accent-4"
                        right
                        flat
                       class="px-16"
                        >
                        <v-tab>Arenas</v-tab>
                        <v-tab>Members</v-tab>

                        <v-tab-item>
                      
                                <v-data-table :items="arenaTeams" :headers="headers">
                           
                                 <template v-slot:top>
                                                <v-toolbar
                                                    flat
                                                >
                                            
                                                    <v-spacer></v-spacer> 
                                                        <v-tooltip color="blue lighten-1" bottom>
                                                            <template v-slot:activator="{ on, attrs }">
                                                                <v-btn
                                                                    color="primary"
                                                                    dark
                                                                    
                                                                    v-bind="attrs"
                                                                    v-on="on"
                                                                    class="mx-2"
                                                                    @click="openArenaSelection"
                                                                    
                                                                >
                                                                    <v-icon>mdi-stadium-variant</v-icon>
                                                                    Add Arena
                                                                </v-btn>
                                                            </template>
                                                            <span>Add Arena to {{selectedTeam && selectedTeam.name}}</span>
                                                        </v-tooltip>
                                                </v-toolbar>
                                                  <v-dialog v-model="dialogRemoveItem" max-width="500px">
                                                    <v-card>
                                                    <v-card-title class="text-h6">Remove {{selectedArena && selectedArena.area_code}} from {{selectedTeam && selectedTeam.name}}?</v-card-title>
                                                
                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <v-btn color="blue darken-1" text @click="dialogRemoveItem = false">Cancel</v-btn>
                                                        <v-btn color="blue darken-1" text @click="removeItemConfirm">OK</v-btn>
                                                        <v-spacer></v-spacer>
                                                    </v-card-actions>
                                                    </v-card>
                                                </v-dialog>
                                    </template>

                                <template v-slot:[`item.team`]="{ item }">
                                    <v-edit-dialog
                                    :return-value.sync="item.team"
                                    large
                                     persistent
                                    @save="save(item)"
                                    @cancel="cancel"
                                    @open="open"
                                    @close="close"
                                    :default="item.team"
                                    >
                                     <div>{{ item.team }}</div>
                                        <template v-slot:input>
                                            <div class="mt-4 text-h6">
                                                Change Team
                                            </div>
                                        
                                            <v-select
                                                
                                                v-model="item.team"
                                                :items="teamsss"
                                                menu-props="auto"
                                                label="Edit"
                                                single-line
                                                counter
                                                autofocus
                                                item-text='name'
                                                item-value='name'
                                                @change="handleChanged"
                                                
                                            ></v-select>
                                            
                                        </template>
                                    </v-edit-dialog>
                                </template>
                              
                                  <template v-slot:[`item.actions`]="{ item }">

                                        <v-tooltip color="error" bottom>
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-btn
                                                    color="error"
                                                    dark
                                                    icon
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    class="mx-2"
                                                    @click="removeItem(item)"
                                                    
                                                >
                                                    <v-icon>mdi-playlist-remove</v-icon>
                                                </v-btn>
                                            </template>
                                            <span>Remove {{ item.name }}</span>
                                        </v-tooltip>
                                    </template>
                               
                            </v-data-table>
                         
                           
                        </v-tab-item>
                         <v-tab-item>
                            YOW
                        </v-tab-item>
                    </v-tabs>
                    </v-card-text>

                   
                 
                </v-card>
            </v-dialog>

             <v-dialog internal-activator v-model="addNewArenaItem" max-width="500px">
                <v-card>
                    <v-card-title class="text-h6">Add arena into {{selectedTeam && selectedTeam.name}} team</v-card-title>
                    
                    <v-card-text>
                        <span class="subtitle-2">Select arena that not yet selected to other team.</span>
                          <v-autocomplete
                            v-model="addSelectedTeamItem"
                            :items="arenaNoTeam"
                            color="white"
                            item-text="arena"
                            label="Arena"
                           
                            return-object
                        ></v-autocomplete>
                    </v-card-text>                           
                    <v-card-actions>
                        <v-spacer></v-spacer>                         
                            <v-btn color="blue darken-1" text >Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="addArenaToTeam">ADD</v-btn>
                            
                </v-card-actions>
             </v-card>
            </v-dialog>

            
              <v-snackbar
                v-model="snack"
                :timeout="2000"
                :color="snackColor"
                bottom
                right
                style="z-index: 9999;"
                >
                {{ snackText }}

            </v-snackbar>
        </v-container>
      
          
</template>
<script>
export default {
  name: "team-management",
  props: {
    viewTeam: Boolean,
    selectedTeam: Object,
    arenaTeams: Array,
    teams: Array,
    getAllArenaPerTeam: Function,
  },
  data() {
    return {
      snack: false,
      snackColor: "",
      snackText: "",
      tab: null,
      headers: [
        { text: "Code", value: "area_code" },
        { text: "Arena", value: "arena" },
        { text: "Team", value: "team" },
        { text: "", value: "actions",sortable: false, },
      ],
      teamsss: this.teams,
      newSelectedTeam: "",
      dialogRemoveItem: false,
      selectedArena: {},
      addNewArenaItem: false,
      arenaNoTeam: [],
      addSelectedTeamItem: null
    };
  },
  methods: {
    closeViewTeam() {
      // this.viewTeam = false;
      // this.team.name = "";
      // this.arenaTeams = [];

      this.$emit("update:viewTeam", false);
      this.$emit("update:arenaTeams", []);
      this.$emit("update:selectedTeam", null);
    },
    
    async save(item) {
      this.snack = true;
      this.snackColor = "success";
      this.snackText = "Data saved";
 
       if(this.newSelectedTeam !== this.selectedTeam.name) {
           await axios.put('api/updateArenaTeam/'+item.area_code, { team: item.team})
             this.$emit("update:arenaTeams", this.arenaTeams.filter(function(v, i) {
                return (v.area_code !== item.area_code && v.team !== item.team);
            }));
        }
      
      
    },
    cancel() {
      this.snack = true;
      this.snackColor = "error";
      this.snackText = "Canceled";
    },
    open(item) {
        this.newSelectedTeam = item

        this.snack = true;
        this.snackColor = "info";
        this.snackText = "Dialog opened";
    
    },
    close () {
        console.log('Dialog closed')
      },
    handleChanged(item){
        console.log('xxx>>>>',item)
        this.newSelectedTeam = item
    },
    openArenaSelection(){
        this.addNewArenaItem = true;
        this.getArenasWithoutTeam()
    },
    removeItem(item){
        console.log('RI>>',item)
        this.selectedArena = item
        this.dialogRemoveItem = true
      
        
    },
    async removeItemConfirm(){
       
        const code = this.selectedArena.area_code
        this.$emit("update:arenaTeams", this.arenaTeams.filter(function(v, i) {
            console.log('CODE>>>',code)
                return (v.area_code !== code);
            }));
        await axios.put('api/updateArenaTeam/'+this.selectedArena.area_code, { team: null})
        this.dialogRemoveItem = false
            
    },
    async getArenasWithoutTeam(){
        const arena = await axios.get("api/arena");
        const arenaNoTeam = arena.data.filter(a => (a.team == null));
       
        this.arenaNoTeam = arenaNoTeam
    
    },
  
    async addArenaToTeam(){
        this.addSelectedTeamItem.team = this.selectedTeam.name
        await axios.put('api/updateArenaTeam/'+this.addSelectedTeamItem.area_code, { team: this.selectedTeam.name});
        this.addNewArenaItem = false;
        console.log(this.addSelectedTeamItem)
        let arrayArena = this.arenaTeams;
        arrayArena.push(this.addSelectedTeamItem);
      
        this.$emit("update:arenaTeams", arrayArena);
    }
     
  },
  computed: {
    viewingTeam: {
      get() {
        return this.viewTeam;
      },
      set(value) {
        this.$emit("input", value);
      },
    },
  },
 
};
</script>
<style lang="">
</style>