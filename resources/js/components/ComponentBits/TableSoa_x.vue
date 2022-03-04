<template>
  <div class="">
    <h1 style="text-align: center;">Datatable with 3rd Party API</h1>
    <v-data-table
        :page="page"
        :pageCount="numberOfPages"
        :headers="headers"
        :items="arenaData"
        :server-items-length="totalArenaData"
        @pagination="handlePaginate"
        class="elevation-1"
    >
  
    </v-data-table>
    <!-- <ul class="d-flex">
        <v-btn v-for="link in links" :key="link.label" :href="link.url">{{link.label}}</v-btn>
    </ul> -->
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "DatatableComponent",
  data() {
    return {
      page: 0,
      totalArenaData: 0,
      numberOfPages: 0,
      arenaData: [],
      loading: true,
      options: {},
      headers: [
         { text: "Date", value: "date_of_soa" },
            { text: "CODE", value: "areaCode" },
            { text: "ref", value: "refNo" },
            { text: "Arena Name", value: "arena_name" },
            { text: "", value: "actions", sortable: false },
      
      ],
      links: []
    };
  },
  //this one will populate new data set when user changes current page. 

  methods: {
    async soa(page = 1) {
        const {data} = await axios.get(`api/import?page=${page}`);
  
        const newArray = [];
        data.data.forEach((dObj) => {
            const arenaName =
                dObj.arena_name.indexOf("~") > -1
                    ? dObj.arena_name.replace(/\~/g, "/")
                    : dObj.arena_name;

            const obj = {
                ...dObj,
                arena_name: arenaName,
            };
            newArray.push(obj);
        });

       this.arenaData = newArray
       this.page = data.current_page
       this.totalArenaData = data.total
       this.numberOfPages = data.last_page
       this.links = data.links
    },
    handlePaginate(e){
        this.$emit('loading', true)
        this.soa(e.page);
        this.$emit('loading', false)
    }
  },
  //this will trigger in the onReady State
  mount() {
    this.soa();
  },
};
</script>
<style lang=""></style>
