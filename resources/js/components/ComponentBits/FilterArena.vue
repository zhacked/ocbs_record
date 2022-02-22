<template lang="">
    <v-col class="col-md-3">
        <v-select
            :items="arenaItemsSelection"
            label="Filter arena"
            dense
            outlined
            item-text="text"
            item-value="key"
            @change="handleSelectionFilterArena"
        ></v-select>
    </v-col>
</template>
<script>
export default {
    name: 'filter-arena',
    props: {
        arenaData: Array,
        soaLists: Function,
        importWithStatus: Function,
        dates: Array,
        tab: String,
        loadDateRange: Function
    },
    data: () => ({
           arenaItemsSelection: [
                {
                    key: "all",
                    text: "All",
                },
                {
                    key: "noArenaDetails",
                    text: "No Arena",
                },
            ],
    }),
    methods: {
        filterNoArenaDetails() {
            let arenaNoDetais = [];
            this.arenaData.forEach((arena) => {
                if (!arena.arena_details) {
                    arenaNoDetais.push(arena);
                }
            });
            this.arenaData.length = 0;
            this.arenaData.splice(0, Infinity, ...arenaNoDetais);

            this.$emit('newSetArrayArena', this.arenaData)
        },

        handleSelectionFilterArena(item) {
            console.log(item);
            item === "noArenaDetails"
                ? this.filterNoArenaDetails()
                : this.dates.length !== 0 ? this.loadDateRange(this.tab) : this.tab === 'ongoing' ? this.soaLists() : this.importWithStatus();
        },
    },
};
</script>
<style lang=""></style>
