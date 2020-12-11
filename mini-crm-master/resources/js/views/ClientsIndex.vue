<template>
  <b-container fluid class="mb-5">
    <div class="clients">
      <!--Success deletion Alert-->
      <alert
        ref="alert"
        variant="success"
        message="Client Deleted Successfully"
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
        <b-col
          xs="12"
          sm="12"
          md="6"
          class="float-left my-2">
          <b-button
            variant="success"
            class="float-left"
            :href="route('clients.create')"
          >
            Add New
          </b-button>
        </b-col>
        <b-col
          xs="12"
          sm="12"
          md="6"
          class="float-right my-2">
          <b-form-group
            horizontal
            class="mb-0">
            <b-input-group>
              <b-form-input
                v-model="filter"
                placeholder="Type to Search"/>
              <b-input-group-append>
                <b-btn
                  :disabled="!filter"
                  @click="filter = ''">Clear
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
      <!--Clients Table-->
      <b-row v-if="!loading">
        <b-table
          ref="table"
          id="clients-table"
          striped
          outlined
          hover
          foot-cline
          responsive
          show-empty
          stacked="md"
          :filter="filter"
          :items="clients"
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
                :href="route('clients.edit',{client:row.item.id})"
                v-b-popover.hover="'Edit Client'">Edit
              </b-button>
              <b-button
                variant="danger"
                size="md"
                @click.stop="onDeleteClient(row.item.id)"
                v-b-popover.hover="'Delete Client'">Delete
              </b-button>
            </b-button-group>
          </template>
          <!--Show rounded image for avatar-->
          <template
            slot="avatar"
            slot-scope="row">
            <b-img
              :src="row.item.avatar || 'https://placeimg.com/50/50/any'"
              rounded="circle"
              width="50"
              height="50"
              alt="image"
              fluid/>
          </template>
          <!--Transactions row button -->
          <template
            slot="show_details"
            slot-scope="row">
            <b-button
              size="sm"
              @click.stop="row.toggleDetails"
              class="mr-2"
              v-if="row.item.transactions.length > 0 "
            >
              {{ row.detailsShowing ? 'Hide' : 'Show'}}
            </b-button>
            <p v-else>No Transactions</p>
          </template>
          <!--Transactions row expand list-->
          <template
            slot="row-details"
            slot-scope="row">
            <b-container>
              <b-row>
                <b-col v-for="row in row.item.transactions" :key="row.id" md="6" lg="4">
                  <b-card class="mb-1">
                    <b-row class="mb-1">
                      <b-col sm="5" class="text-sm-right"><b>Date:</b></b-col>
                      <b-col>{{ row.date }}</b-col>
                    </b-row>
                    <b-row class="mb-1">
                      <b-col sm="5" class="text-sm-right"><b>Amount:</b></b-col>
                      <b-col>{{ row.amount }}</b-col>
                    </b-row>
                    <b-row class="justify-content-center">
                      <b-button
                        sm=3
                        size="sm"
                        :href="route('transactions.edit',{transaction: row.id}).url()"
                        class="text-center mb-1 mt-1"
                      >View
                      </b-button>
                    </b-row>
                  </b-card>
                </b-col>
              </b-row>
            </b-container>
            <b-button size="sm" @click="row.toggleDetails">Hide Details</b-button>
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
        title="Client Info"
        ok-only>
        <b-container
          fluid
          v-if="!modalIsLoading">
          <b-row>
            <b-img
              :src="currentClient.avatar_path"
              rounded
              width="250"
              height="250"
              class="m-1"
              alt="image"
              fluid-grow
              center>
            </b-img>
          </b-row>
          <b-row>
            <b-col><strong>First Name:</strong> {{currentClient.first_name}}</b-col>
            <b-col><strong>Last Name:</strong> {{currentClient.last_name}}</b-col>
            <b-col><strong>Email:</strong> {{currentClient.email}}</b-col>
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
    name: 'ClientsIndex',
    components: {
      'alert': AlertComponent,
      'pagination': PaginationComponent,
    },
    data() {
      return {
        modalIsLoading: false,
        currentClient: {},
        response: {},
        clients: [],
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
            key: 'avatar',
            sortable: true,
          }, {
            key: 'first_name',
            sortable: true,
          }, {
            key: 'last_name',
            sortable: true,
          }, {
            key: 'email',
            sortable: true,
          }, {
            key: 'show_details',
            label: 'Transactions',
            sortable: false,
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
        this.$http.get('/clients', {
          params: {
            page: this.currentPage,
            perPage: this.perPage,
          },
        }).then(response => {
          this.loading = false;
          this.clients = response.data.data;
          this.response = response.data;
          this.currentPage = response.data.meta.current_page;
          this.fromRow = response.data.meta.from;
          this.toRow = response.data.meta.to;
          this.perPage = response.data.meta.per_page;
          this.totalPages = response.data.meta.last_page;
          this.totalRows = response.data.meta.total;
        }).catch(error => {
          this.loading = false;
          this.error = error.response.data.message || error.message;
        });
      },
      onFiltered(filteredItems) {
        this.totalResults = filteredItems.length;
      },
      onDeleteClient(id) {
        this.$http.delete(this.route('clients.destroy', {client: id})).then(response => {
          this.$refs.alert.showAlert();
          this.fetchData();
        }).catch(error => {
          this.loading = false;
          this.error = error.response.data.message || error.message;
        });
      },
      info(item, button) {
        this.modalIsLoading = true;
        this.$http.get(this.route('clients.show', {client: item.id})).then(response => {
          this.currentClient = response.data;
          this.modalIsLoading = false;
        }).catch(error => {
          this.modalIsLoading = false;
          this.error = error.response.data.message || error.message;
        });
        this.$root.$emit('bv::show::modal', 'modalInfo', button);
      },
      resetModal() {
        this.currentClient = {};
        this.modalIsLoading = false;
      },
    },
  };
</script>

<style scoped>

</style>