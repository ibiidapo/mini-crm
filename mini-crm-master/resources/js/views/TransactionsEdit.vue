<template>
  <div>
    <alert-component
      ref="alert"
      variant="success"
      message="Transaction Saved Successfully"
    ></alert-component>
    <b-card :title="title">
      <div class="card-body">
        <b-form
          ref="form"
          id="form-transaction"
          v-if="show"
          @reset="onReset"
          @submit.prevent="onSubmit"
          @keydown="errors.clear($event.target.name)">
          <b-form-row>
            <b-col cols="5">
              <b-form-group id="clientLabel"
                            label="Client"
                            label-for="client"
              >
                <autocomplete
                  ref="autocomplete"
                  id="clientInput"
                  input-class="form-control"
                  placeholder="Write your Client`s Name."
                  :disabled="disabled"
                  :source="route('search.clients').url()+'?query='"
                  results-property="data"
                  results-value="id"
                  results-display="name"
                  :initial-value="this.client.id || ''"
                  :initial-display="this.client.info || ''"
                  @selected="saveClient"
                  name="client_id"
                >
                </autocomplete>
                <div class="text-danger" v-if="errors.has('client_id')">
                  {{ errors.get('client_id') || 'Client is required' }}
                </div>
              </b-form-group>
            </b-col>
            <b-col cols="4">
              <b-form-group
                id="dateLabel"
                label="Date"
                label-for="transaction_date"
              >
                <b-form-input
                  id="dateInput"
                  v-model="transaction_date"
                  type="date"
                  required
                  placeholder="Select transaction date"
                  :state="errors.missing('transaction_date')"
                  :disabled="disabled"
                  aria-describedby="dateFeedback"
                >
                </b-form-input>
                <b-form-invalid-feedback id="dateFeedback">
                  {{ errors.get('transaction_date') || 'Date is required' }}
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
            <b-col cols="3">
              <b-form-group
                id="amountLabel"
                label="Amount"
                label-for="amount"
              >
                <b-form-input
                  id="amountInput"
                  type="number"
                  v-model="amount"
                  min="0"
                  required
                  placeholder="Enter amount"
                  aria-describedby="amountFeedback"
                  :state="errors.missing('amount')"
                  :disabled="disabled"
                >
                </b-form-input>
                <b-form-invalid-feedback id="amountFeedback">
                  {{ errors.get('amount') || 'A valid amount is required' }}
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
          </b-form-row>
          <b-button
            type="submit"
            variant="success"
            @click="onSubmit"
            :disabled="errors.any()">
            Submit
          </b-button>
          <b-button
            type="reset"
            variant="danger"
            @click="onReset">
            Reset
          </b-button>
        </b-form>
      </div>
    </b-card>
  </div>

</template>

<script>
  import AlertComponent from '../components/AlertComponent';
  import Errors from '../utilities/Errors';
  import Autocomplete from 'vuejs-auto-complete';
  
  export default {
    name: 'TransactionsEdit',
    components: {
      Autocomplete,
      AlertComponent,
    },
    props: {
      transaction: {
        type: Object,
        required: false,
        default: function() {
          return {};
        },
      },
      disabled: {
        type: Boolean,
        required: false,
        default: false,
      },
    },
    data: function() {
      return {
        show: true,
        errors: new Errors(),
        transaction_date: '',
        client: '',
        amount: '',
      };
    },
    methods: {
      onSubmit(event) {
        event.preventDefault();
        let vm = this;
        let data = {
          'transaction_date': this.transaction_date,
          'amount': this.amount,
          'client_id': this.client.id,
        };
  
        this.$http[this.getEndpointMethod()](this.getEndpoint(), data).then(response => {
          vm.$refs.alert.showAlert();
        }).catch(error => {
          vm.errors.record(error.response.data.errors);
          console.error(error);
        });
      },
      onReset(event) {
        event.preventDefault();
        //reset errors
        this.errors.clear();
        //reset fields
        this.amount = '';
        this.transaction_date = '';
        this.client = '';
        /* Trick to reset/clear native browser form validation state */
        this.show = false;
        this.$nextTick(() => {
          this.show = true;
        });
      },
      saveClient(item) {
        this.client = {
          id: item.value,
          info: item.display,
        };
      },
      isNew() {
        return !this.transaction.id;
      },
      getEndpoint() {
        if (this.isNew()) {
          return this.route('transactions.store').url();
        }
        
        return this.route('transactions.update', {transaction: this.transaction.id}).url();
      },
      getEndpointMethod() {
        if (this.isNew()) {
          return 'post';
        }
        return 'put';
      },
    },
    computed: {
      title() {
        if (this.isNew()) {
          return 'Create Transaction';
        }
        return 'Edit Transaction #' + this.transaction.id + ' for client: ' + this.client.info || '';
      },
    },
    mounted() {
      this.$nextTick(() => {
        if (this.transaction.id) {
          this.amount = this.transaction.amount || '';
          this.transaction_date = this.transaction.transaction_date || '';
          this.client = this.transaction.client || '';
        }
      });
    },
  };
</script>
