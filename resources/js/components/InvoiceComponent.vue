<template>
    <div class="overflow-auto">
        <p class="mt-3">Current Page: {{ currentPage }}</p>
        <b-table
            id="my-table"
            :items="items"
            :per-page="0"
            :current-page="currentPage"
            :fields="fields"
            small
        >
            <template v-slot:cell(number)="data">
                {{ "F/"+data.value }}
            </template>
            <template v-slot:cell(net_price)="data">
                {{ data.value+"zł" }}
            </template>
            <template v-slot:cell(created_at)="data">
                {{ data.value | formatDate}}
            </template>
            <template v-slot:cell(updated_at)="data">
                {{ data.value | formatDate}}
            </template>
            <template v-slot:cell(id)="data">
                <button class="btn-sm btn-danger">DELETE</button>
                <button class="btn-sm btn-info">EDIT</button>
            </template>
        </b-table>
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
            fields: [
                {
                    key: 'number',
                    sortable: false
                },
                {
                    key: 'nip_buyer',
                    sortable: false
                },
                {
                    key: 'nip_seller',
                    sortable: false
                },
                {
                    key: 'product_name',
                    sortable: false
                },
                {
                    key: 'net_price',
                    sortable: false
                },
                {
                    key: 'created_at',
                    sortable: false
                },
                {
                    key: 'updated_at',
                    sortable: false
                },
                {
                    key: 'id',
                    label: 'Action',
                    sortable: false
                },
            ],
        }
    },
    // computed: {
    //     rows() {
    //         return this.items.length
    //     },
    // },
    methods: {
        getAll(){
            axios.get('/get-all?page='+this.currentPage)
                .then(response => {
                    console.log(response);
                    // console.log(response.data.data);
                    this.currentPage = response.data.current_page;
                    this.items = response.data.data;
                    this.perPage = response.data.per_page;
                    this.rows = response.data.total;
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        delete(id){
            axios.delete('/delete/'+id)
                .then(response => {
                    this.getAll();
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        update(){

        }
    },
    mounted(){
        this.getAll();
    },
    watch: {
        currentPage: function (){
            this.getAll();
        }
    }
}
</script>
