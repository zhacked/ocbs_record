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
                                <template v-slot:item.team="{item}">
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
                            </v-data-table>
                        </v-tab-item>
                         <v-tab-item>
                            YOW
                        </v-tab-item>
                    </v-tabs>
                    </v-card-text>

                   
                 
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
        { text: "code", value: "area_code" },
        { text: "Arena", value: "arena" },
        { text: "team", value: "team" },
      ],
      teamsss: this.teams,
      newSelectedTeam: ""
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
      console.log('NEW SELECTE',this.newSelectedTeam)
      console.log('SELECTED>>>',this.selectedTeam)
      console.log(this.newSelectedTeam !== this.selectedTeam.name)
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