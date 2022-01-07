<template>
     <v-row>
                                                        <v-col>
                                                            <v-row>
                                                                <div
                                                                    class="
                                                                        sign-wrapper
                                                                    "
                                                                >
                                                                    <span class="signedBy"
                                                                        >Computed
                                                                        by:</span
                                                                    >
                                                                    <div
                                                                        class="
                                                                            sign-container
                                                                        "
                                                                    >
                                                                       <span class="select-field_container  " :class="{'editmode-span': editmode}">
                                                                            <select class="sign-name select-field_report computation" name="computed" disabled @change="handleComputedBy($event)">
                                                                                <!-- <option>Ralph Redoquerio</option> -->
                                                                                <option v-for="computed_by in userPrepared.computed" :value="`${computed_by.name} | ${computed_by.position}`" :key="computed_by.id">{{computed_by.name}}</option>
                                                                            </select>
                                                                        </span>


                                                                        <span class="signed-title">
                                                                            
                                                                           {{computedPosition || userPrepared.computed[0].position || "Quality Assurance Staff" }}
                                                                           
                                                                        </span >
                                                                    </div>
                                                                </div>
                                                            </v-row>
                                                            <v-row>
                                                                <div
                                                                    class="
                                                                        sign-wrapper
                                                                        scbottom
                                                                    "
                                                                >
                                                                    <span class="signedBy"
                                                                        >Prepared
                                                                        by:</span
                                                                    >
                                                                    <div class="sign-container">
                                                                         <span class="select-field_container" :class="{'editmode-span': editmode}">
                                                                            <select class="sign-name select-field_report computation" name="prepared" disabled @change="handlePreparedBy($event)">
                                                                                <!-- <option>Clarise A. Valles</option> -->
                                                                                <option v-for="prepared_by in userPrepared.prepared"  :value="`${prepared_by.name} | ${prepared_by.position}`" :key="prepared_by.id">{{prepared_by.name}}</option>
                                                                            </select>
                                                                        </span>
                                                                        

                                                                        <span class="signed-title">
                                                                           {{preparedPosition || userPrepared.prepared[0].position || " Finance Assistant - Kiosk" }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </v-row>
                                                        </v-col>
                                                        <v-col>
                                                            <v-row>
                                                                <div
                                                                    class="
                                                                        sign-wrapper
                                                                    "
                                                                >
                                                                    <span class="signedBy"
                                                                        >Checked
                                                                        by:</span
                                                                    >
                                                                    <div class="sign-container">
                                                                         <span class="select-field_container" :class="{'editmode-span': editmode}">
                                                                            <select class="sign-name select-field_report computation" name="checkedOne" disabled @change="handleCheckedOneBy($event)">
                                                                                <!-- <option default>Ma. Lourdes Anoba/Leo Tampilic Jr.</option> -->
                                                                                <option v-for="checked_by in userPrepared.checked" :value="`${checked_by.name} | ${checked_by.position}`" :key="checked_by.id">{{checked_by.name}}</option>
                                                                            </select>
                                                                        </span>
                                                                        

                                                                        <span class="signed-title">
                                                                            {{checkedOnePosition || userPrepared.checked[0].position || "QA - Team Leader"}}
                                                                        </span >
                                                                    </div>
                                                                </div>
                                                            </v-row>
                                                            <v-row>
                                                                <div class="sign-wrapper scbottom">
                                                                    <span class="signedBy">Checked by:</span>
                                                                    <div class="sign-container">
                                                                        
                                                                         <span class="select-field_container" :class="{'editmode-span': editmode}">
                                                                            <select class="sign-name select-field_report computation" name="checkedTwo" disabled @change="handleCheckedTwoBy($event)">
                                                                                <!-- <option>Mariel Pilotos/Jonalyn Bonares</option> -->

                                                                                <option v-for="checked_by in userPrepared.checked" :value="`${checked_by.name} | ${checked_by.position}`" :key="checked_by.id">{{checked_by.name}}</option>
                                                                            </select>
                                                                        </span>
                                                                        

                                                                        <span class="signed-title">
                                                                           {{checkedTwoPosition || userPrepared.checked[1].position ||"Supervisor - Arena/OCBS"}}
                                                                        </span >
                                                                    </div>
                                                                </div>
                                                            </v-row>
                                                        </v-col>
                                                    </v-row>
</template>
<script>
    export default {
        name: "PreparedChecked",
        props: {
            userPrepared: Object,
            editmode: Boolean
        },
        data(){
            return{
              
                preparedPosition: "",
                computedPosition: "",
                checkedOnePosition: "",
                checkedTwoPosition: "",
            
            }
        },
        methods: {
            handlePreparedBy(event){
               
                const positionPrepared = event.target.value.split(" | ");
             
                this.preparedPosition =  positionPrepared && positionPrepared[1] || "";
               
                
            },
            handleComputedBy(event){
        
             
                const positionComputed = event.target.value.split(" | ");
               
             
                this.computedPosition = positionComputed && positionComputed[1] || "";
              
                
            },
            handleCheckedOneBy(event){
                const positionCheckedOne = event.target.value.split(" | ");
                this.checkedOnePosition = positionCheckedOne && positionCheckedOne[1] || "";
            },
            handleCheckedTwoBy(event){
               
                const positionCheckedTwo = event.target.value.split(" | ");

                this.checkedTwoPosition = positionCheckedTwo && positionCheckedTwo[1] || "";
                
            }
        }
        
        
    }
</script>