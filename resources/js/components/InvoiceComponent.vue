<template>
    <div class="overflow-auto">
        <div class="mt-3 mb-3">
            <div class="d-inline-block mr-3">
                <b-button variant="success" v-b-modal.create-modal>Create</b-button>
            </div>
            <div class="d-inline-block"><p>Current Page: {{ currentPage }}</p></div>
        </div>
        <div class="bg-success mb-3 px-3 py-1" v-bind:class="{'d-none': !success_message}"><h3 class="m-0" ref="success_message"></h3></div>
        <b-modal id="create-modal" ref="create-modal" title="Create Invoice" @ok="createInvoice">
            <form ref="createInvoiceForm">
                <div class="form-group">
                    <label for="createNumber">Number</label>
                    <input type="number" class="form-control" id="createNumber" name="number" min="1" v-model="form_number">
                    <span class="error text-danger" ref="form_number_error" v-bind:class="{'d-none': !form_number_error}">Please correct the error</span>
                </div>
                <div class="form-group">
                    <label for="nipBuyer">Nip Buyer</label>
                    <input type="text" class="form-control" id="nipBuyer" name="nip_buyer" v-model="form_nip_buyer">
                    <span class="error text-danger" ref="form_nip_buyer_error" v-bind:class="{'d-none': !form_nip_buyer_error}">Please correct the error</span>
                </div>
                <div class="form-group">
                    <label for="nipSeller">Nip Seller</label>
                    <input type="text" class="form-control" id="nipSeller" name="nip_seller" v-model="form_nip_seller">
                    <span class="error text-danger" ref="form_nip_seller_error" v-bind:class="{'d-none': !form_nip_seller_error}">Please correct the error</span>
                </div>
                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" class="form-control" id="productName" name="product_name" v-model="form_product_name">
                    <span class="error text-danger" ref="form_product_name_error" v-bind:class="{'d-none': !form_product_name_error}">Please correct the error</span>
                </div>
                <div class="form-group">
                    <label for="netPrice">Net Price</label>
                    <input type="number" class="form-control" id="netPrice" name="net_price" min="0.01" step="0.01" placeholder="0.01" v-model="form_net_price">
                    <span class="error text-danger" ref="form_net_price_error" v-bind:class="{'d-none': !form_net_price_error}">Please correct the error</span>
                </div>
            </form>
        </b-modal>

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
            form_number: null,
            form_nip_buyer: null,
            form_nip_seller: null,
            form_product_name: null,
            form_net_price: null,

            form_number_error: false,
            form_nip_buyer_error: false,
            form_nip_seller_error: false,
            form_product_name_error: false,
            form_net_price_error: false,

            success_message: false,
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

        },
        createInvoice(bvModalEvt){
            bvModalEvt.preventDefault();
            axios.post('/create', {
                'number': this.form_number,
                'nip_buyer': this.form_nip_buyer,
                'nip_seller': this.form_nip_seller,
                'product_name': this.form_product_name,
                'net_price': this.form_net_price
            }).then(response => {
                    // console.log(response);
                // this.$nextTick(() => {
                //     this.$bvModal.hide('create-modal');
                // })
                this.$refs['create-modal'].hide();
                this.resetErrors();
                this.clearForm();
                this.$refs['success_message'].innerHTML = 'Added new Invoice !';
                this.success_message = true;
            }).catch(error => {
                this.resetErrors();
                if (typeof error.response != 'undefined') {
                    console.log(error.response.data.errors);
                    Object.keys(error.response.data.errors).forEach(key => {
                        this.$refs['form_' + key + '_error'].innerHTML = error.response.data.errors[key];
                        this['form_' + key + '_error'] = true;
                    });
                }
                this.$refs['success_message'].innerHTML = '';
                this.success_message = false;
                })
        },
        resetErrors(){
            this.form_number_error = false;
            this.form_nip_buyer_error = false;
            this.form_nip_seller_error = false;
            this.form_product_name_error = false;
            this.form_net_price_error = false;
        },
        clearForm(){
            this.form_number = null;
            this.form_nip_buyer = null;
            this.form_nip_seller = null;
            this.form_product_name = null;
            this.form_net_price = null;
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
