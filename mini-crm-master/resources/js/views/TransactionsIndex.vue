<template>
  <b-container fluid class="mb-5">
    <div class="transactions">
      <!--Success deletion Alert-->
      <alert
        ref="alert"
        variant="success"
        message="Transaction Deleted Successfully"
      >
      </alert>
      <!--Error-->
      <div v-if="error" class="error">
        <p>{{ error }}</p>
        
        <p>
          <b-button
            variant="success"
            @click.prevent="fetchData">
            Try Again
          </b-button>
        </p>
      </div>
      <!--Add new button-->
      <b-row>
        <b-col xs="12" sm="12" md="6" class="float-left my-2">
          <b-button variant="success" class="float-left" :href="route('transactions.create')">Add New</b-button>
        </b-col>
        <b-col xs="12" sm="12" md="6" class="float-right my-2">
          <b-form-group horizontal class="mb-0">
            <b-input-group>
              <b-form-input
                v-model="filter"
                placeholder="Type to Search"/>
              <b-input-group-append>
                <b-btn
                  :disabled="!filter"
                  @click="filter = ''"
                >
                  Clear
                </b-btn>
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>
      </b-row>
      <!--Loading-->
      <div class="loading" v-if="loading">
        Loading...
      </div>
      <!--Transactions Table-->
      <b-row v-if="!loading">
        <b-table
          ref="table"
          id="transactions-table"
          striped
          outlined
          hover
          foot-cline
          responsive
          show-empty
          stacked="md"
          :filter="filter"
          :items="transactions"
          :fields="fields"
          @filtered="onFiltered"
          :busy.sync="loading"
        >
          <!--Custom Actions-->
          <template slot="actions" slot-scope="row">
            <b-button-group>
              <b-button
                variant="info"
                size="md"
                @click.stop="info(row.item, $event.target)"
                v-b-popover.hover="'Show Details'">View
              </b-button>
              <b-button
                variant="warning"
                size="md"
                :href="route('transactions.edit',{transaction:row.item.id})"
                v-b-popover.hover="'Edit Transaction'"
              >Edit
              </b-button>
              <b-button
                variant="danger"
                size="md"
                @click.stop="onDeleteTransaction(row.item.id)"
                v-b-popover.hover="'Delete Transaction'"
              >Delete
              </b-button>
            </b-button-group>
          </template>
          <!-- A custom formatted column for client -->
          <template slot="client" slot-scope="data">
            <a :href="route('clients.edit',{client:data.item.client_id})">{{data.item.client}}</a>
          </template>
        </b-table>
      
      </b-row>
      <!--Pagination-->
      <b-row>
        <b-col md="12" class="my-1" align="left">
          <pagination
            :data="response"
            @pagination-change-page="fetchData"
            :limit="3"
            class="my-0">
          </pagination>
          
          <div v-if="filter === ''">
            Showing page {{ currentPage }} from {{ totalPages }} for {{ totalRows }} results<br>
          </div>
          <div v-else>
            Found {{totalResults}} search results
          </div>
        </b-col>
      </b-row>
      <!-- Info modal -->
      <b-modal
        ref="modalInfo"
        id="modalInfo"
        @hide="resetModal"
        title="Transaction Info"
        ok-only>
        <b-container fluid v-if="!modalIsLoading">
          <b-row>
            <b-col><strong>Client:</strong><br/> {{currentTransaction.client || ''}}</b-col>
            <b-col><strong>Date:</strong><br/> {{currentTransaction.date || ''}}</b-col>
            <b-col><strong>Amount:</strong><br/> {{currentTransaction.amount || ''}}</b-col>
          </b-row>
        </b-container>
        <div class="text-center justify-content-center" v-else>
          Loading....
        </div>
      </b-modal>
    </div>
  </b-container>
</template>

<script>
  import AlertComponent from '../components/AlertComponent';
  import PaginationComponent from '../components/PaginationComponent';
  import {clearURL} from '../helpers';
  
  export default {
    name: 'TransactionsIndex',
    components: {
      'alert': AlertComponent,
      'pagination': PaginationComponent,
    },
    data() {
      return {
        modalIsLoading: false,
        currentTransaction: {},
        response: {},
        transactions: [],
        loading: false,
        error: null,
        perPage: 10,
        totalRows: null,
        totalPages: null,
        fromRow: null,
        toRow: null,
        filter: '',
        totalResults: 0,
        fields: [
          {
            key: 'id',
            label: '#',
            sortable: true,
          }, {
            key: 'date',
            sortable: true,
          }, {
            key: 'amount',
            sortable: true,
          }, {
            key: 'client',
            sortable: true,
          }, {
            key: 'actions',
            label: 'Actions',
            sortable: false,
          },
        ],
      };
    },
    created() {
      this.fetchData();
    },
    methods: {
      fetchData(page = 1) {
        clearURL();
        this.currentPage = page;
        this.error = null;
        this.loading = true;
        this.$http.get(this.route('transactions.index'), {
          params: {
            page: this.currentPage,
            perPage: this.perPage,
          },
        }).then(response => {
          this.loading = false;
          this.transactions = response.data.data;
          this.response = response.data;
          this.currentPage = response.data.meta.current_page;
          this.fromRow = response.data.meta.from;
          this.toRow = response.data.meta.to;
          this.perPage = response.data.meta.per_page;
          this.totalPages = response.data.meta.last_page;
          this.totalRows = response.data.meta.total;
        }).catch(error => {
          this.loading = false;
          this.error = error.data.message || error.message;
        });
      },
      onFiltered(filteredItems) {
        this.totalResults = filteredItems.length;
      },
      onDeleteTransaction(id) {
        this.$http.delete(this.route('transactions.destroy', {transaction: id})).then(response => {
          this.$refs.alert.showAlert();
          this.fetchData();
        }).catch(error => {
          this.loading = false;
          this.error = error.response.data.message || error.message;
        });
      },
      info(item, button) {
        this.modalIsLoading = true;
        this.$http.get(this.route('transactions.show', {transaction: item.id})).then(response => {
          this.currentTransaction = response.data.data;
          this.modalIsLoading = false;
        }).catch(error => {
          this.modalIsLoading = false;
          this.error = error.response.data.message || error.message;
        });
        this.$root.$emit('bv::show::modal', 'modalInfo', button);
      },
      resetModal() {
        this.currentTransaction = {};
        this.modalIsLoading = false;
      },
    },
  };
</script>
