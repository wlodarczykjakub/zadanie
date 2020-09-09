<template>
    <div class="overflow-auto">
        <div class="mt-3 mb-3">
            <div class="d-inline-block mr-3">
                <button class="btn btn-success" @click="showModalCreate()">Create</button>
            </div>
            <div class="d-inline-block"><p>Current Page: {{ currentPage }}</p></div>
        </div>
        <div class="bg-success mb-3 px-3 py-1" v-bind:class="{'d-none': !success_message}"><h3 class="m-0" ref="success_message"></h3></div>
        <b-modal id="create-modal" ref="create-modal" :title="modal_title" @ok="doAction">
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

        <b-modal id="delete-modal" ref="delete-modal" title="Delete Invoice" @ok="deleteInvoice">
            <h3 class="my-4">Delete invoice F/{{delete_invoice_number}} ?</h3>
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
            <template v-slot:cell(nip_buyer)="data">
                {{ data.value}}
            </template>
            <template v-slot:cell(nip_seller)="data">
                {{ data.value}}
            </template>
            <template v-slot:cell(product_name)="data">
                {{ data.value}}
            </template>
            <template v-slot:cell()="data">
                <button class="btn-sm btn-danger" @click="showModalDelete(data)">DELETE</button>
                <button class="btn-sm btn-info" @click="showModalUpdate(data)">EDIT</button>
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
            form_id: null,
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

            modal_title: 'Create Invoice',
            action: 'create',

            delete_invoice_id: null,
            delete_invoice_number: null,
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
        deleteInvoice(bvModalEvt){
            bvModalEvt.preventDefault();
            axios.post('/delete', {
                'id': this.delete_invoice_id
            })
                .then(response => {
                    this.$refs['delete-modal'].hide();
                    this.$refs['success_message'].innerHTML = 'Deleted Invoice F/'+this.delete_invoice_number+' !';
                    this.success_message = true;
                    this.getAll();
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        createInvoice(){
            axios.post('/create', {
                'number': this.form_number,
                'nip_buyer': this.form_nip_buyer,
                'nip_seller': this.form_nip_seller,
                'product_name': this.form_product_name,
                'net_price': this.form_net_price
            }).then(response => {
                this.hideModal();
                this.resetErrors();
                this.clearForm();
                this.$refs['success_message'].innerHTML = 'Added new Invoice !';
                this.success_message = true;
                this.getAll();
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
        updateInvoice(){
            axios.put('/update', {
                'id': this.form_id,
                'number': this.form_number,
                'nip_buyer': this.form_nip_buyer,
                'nip_seller': this.form_nip_seller,
                'product_name': this.form_product_name,
                'net_price': this.form_net_price
            }).then(response => {
                this.hideModal();
                this.resetErrors();
                this.clearForm();
                this.$refs['success_message'].innerHTML = 'Invoice Updated !';
                this.success_message = true;
                this.getAll();
            }).catch(error => {
                this.resetErrors();
                if (typeof error.response != 'undefined') {
                    // console.log(error.response.data.errors);
                    Object.keys(error.response.data.errors).forEach(key => {
                        this.$refs['form_' + key + '_error'].innerHTML = error.response.data.errors[key];
                        this['form_' + key + '_error'] = true;
                    });
                }
                this.$refs['success_message'].innerHTML = '';
                this.success_message = false;
            })
        },
        doAction(bvModalEvt){
            bvModalEvt.preventDefault();
            switch (this.action){
                case "create":
                    this.createInvoice();
                    break;
                case "update":
                    this.updateInvoice();
                    break;
                default:
                    this.createInvoice();
                    break;
            }
        },
        resetErrors(){
            this.form_number_error = false;
            this.form_nip_buyer_error = false;
            this.form_nip_seller_error = false;
            this.form_product_name_error = false;
            this.form_net_price_error = false;
        },
        clearForm(){
            this.form_id = null;
            this.form_number = null;
            this.form_nip_buyer = null;
            this.form_nip_seller = null;
            this.form_product_name = null;
            this.form_net_price = null;
        },
        showModalUpdate(data) {
            this.modal_title = 'Update Invoice';
            this.form_id = data.item.id;
            this.form_number = data.item.number;
            this.form_nip_buyer = data.item.nip_buyer;
            this.form_nip_seller = data.item.nip_seller;
            this.form_product_name = data.item.product_name;
            this.form_net_price = data.item.net_price;
            this.action = 'update';
            this.$refs['create-modal'].show();
        },
        showModalCreate() {
            this.modal_title = 'Create Invoice';
            this.action = 'create';
            this.$refs['create-modal'].show();
        },
        showModalDelete(data) {
            this.delete_invoice_id = data.item.id;
            this.delete_invoice_number = data.item.number;
            this.$refs['delete-modal'].show();
        },
        hideModal() {
            this.$refs['create-modal'].hide();
        },
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
