<template lang="">
    <v-col class="col-md-4" v-show="$gate.isAdmin()">
        <v-file-input
            outlined
            dense
            v-model="fileUpload"
            color="deep-purple accent-4"
            label="File input"
            placeholder="Select your file"
            :clearable="false"
            counter
            append-icon="mdi-file-import"
            :show-size="1000"
            @change="onFileChange($event)"
        >
            <template v-slot:append>
                <v-tooltip bottom color="success">
                    <template v-slot:activator="{ on }">
                        <v-icon
                            large
                            :disabled="!isExcel"
                            v-on="on"
                            color="green darken-3"
                            style="cursor: pointer"
                            @click="proceedAction"
                        >
                            mdi-file-import
                        </v-icon>
                    </template>
                    <span>Import File</span>
                </v-tooltip>
            </template>
            <template v-slot:selection="{ index, text }">
                <v-chip
                    v-if="index < 2"
                    color="deep-purple accent-4"
                    dark
                    label
                    close
                    @click:close="clearFile"
                >
                    {{ text }}
                </v-chip>
            </template>
        </v-file-input>
       <loading-progress :loading="loading" />
    </v-col>
</template>
<script>
import { readSoa } from "../../methods";

export default {
  name: "soa-input",
  data: () => ({
    isExcel: false,
    ocbsArrayFiltered: [],
    fileUpload: null,
    loading: false
  }),
  methods: {
    async onFileChange(event) {
        if(event) {
            this.loading = true
            setInterval(() => {this.loading = false}, 3000)
        }
        const { arenaReportFiltered, isExcel } = await readSoa(event, this.isExcel);
        this.ocbsArrayFiltered = arenaReportFiltered;
        this.isExcel = isExcel;
        
    },

    proceedAction() {
      this.$Progress.start();
      if (
        $("#importData").val() === "" ||
        !this.fileUpload.name.includes("xlsx")
      ) {
        Toast.fire({
          icon: "warning",
          title: "Make sure you insert correct excel data!",
        });
      } else {
        this.loading = true
        axios
          .post("api/import", this.ocbsArrayFiltered)
          .then(({ data }) => {
            this.loading = false
            $("#importData").val("");

            Toast.fire("Successfully!", "Excel Imported", "success");
            this.$Progress.finish();
            this.fileUpload = null;
            this.isExcel = false;
            
          })
          .catch((error) => {
            this.loading = false
            swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
              footer: error,
            });
          });
      }
    },
    clearFile(file) {
      console.log(file);
      this.isExcel = false;
      this.fileUpload = null;
    },
  },
};
</script>
<style lang="">
</style>