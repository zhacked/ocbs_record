<template lang="">

          
            
       
                <v-card class="pa-8">
                    <v-banner class="h4">SIGNATORY</v-banner>
                    <v-row>
                        <v-col>
                        
                            <v-row>
                                <sign-box
                                    titleKey="Prepared by"
                                    :check.sync="prepared"
                                    assignedSign="prepared"
                                    :noOfSign="1"
                                ></sign-box>
                            </v-row>
                            <v-divider></v-divider>
                            <v-row>
                                <sign-box
                                    titleKey="Checked by"
                                    :check.sync="checkSetOne"
                                    assignedSign="checkSetOne"
                                    :noOfSign="2"
                                ></sign-box>
                            </v-row>
                            <v-divider></v-divider>
                            <v-row>
                                <sign-box
                                    titleKey="Checked by"
                                    :check.sync="checkSetTwo"
                                    assignedSign="checkSetTwo"
                                    :noOfSign="2"
                                ></sign-box>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-card>
        
  
</template>
<script>
import SignBox from "./Sign/SignBox.vue";
export default {
    components: {
        SignBox,
    },
    data() {
        return {
            checkSetOne: false,
            checkSetTwo: false,
            prepared: false,
        };
    },
};
</script>
