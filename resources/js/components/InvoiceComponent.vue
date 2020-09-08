<template>
    <div class="overflow-auto">
        <p class="mt-3">Current Page: {{ currentPage }}</p>
        <b-table
            id="my-table"
            :items="items"
            :per-page="perPage"
            :current-page="currentPage"
            small
        ></b-table>
        <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="my-table"
        ></b-pagination>
    </div>
</template>

<script>
export default {
    data() {
        return {
            perPage: 10,
            currentPage: 1,
            items: [],
            rows: 1,
        }
    },
    // computed: {
    //     rows() {
    //         return this.items.length
    //     },
    // },
    methods: {
        getAll: function (){
            axios.get('/get-all')
                .then(response => {
                    console.log(response);
                    this.currentPage = response.data.current_page;
                    this.items = response.data.data;
                    this.perPage = response.data.per_page;
                    this.rows = response.data.total;
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    },
    mounted(){
        this.getAll();

    }
}
</script>
