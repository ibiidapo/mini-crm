<template>
  <div>
    <alert-component
      ref="alert"
      variant="success"
      message="Client Saved Successfully"
    ></alert-component>
    <b-card :title="title">
      <div class="card-body">
        <b-form
          ref="form"
          id="form-client"
          v-if="show"
          @reset="onReset"
          @submit.prevent="onSubmit"
          @keydown="errors.clear($event.target.name)">
          <b-form-row>
            <b-col>
              <b-form-group
                id="nameLabel"
                label="First Name"
                label-for="first_name"
              >
                <b-form-input
                  id="nameInput"
                  type="text"
                  v-model.trim="first_name"
                  required
                  placeholder="Write your Client`s Name."
                  aria-describedby="nameFeedback"
                  :state="errors.missing('first_name')"
                >
                </b-form-input>
                <b-form-invalid-feedback id="nameFeedback">
                  {{ errors.get('first_name') || 'This is a required field and must be maximum 255 characters' }}
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                id="surnameLabel"
                label="Last Name"
                label-for="last_name"
              >
                <b-form-input
                  id="surnameInput"
                  type="text"
                  v-model="last_name"
                  placeholder="Write your Client`s Last Name."
                  aria-describedby="lastNameFeedback"
                  :state="errors.missing('last_name')"
                  required
                >
                </b-form-input>
                <b-form-invalid-feedback id="lastNameFeedback">
                  {{ errors.get('last_name') || 'This is a required field and must be maximum 255 characters' }}
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
            <b-col>
              <b-form-group
                id="emailLabel"
                label="Email"
                label-for="email"
              >
                <b-form-input
                  id="emailInput"
                  type="email"
                  v-model="email"
                  placeholder="Write your Client`s Email."
                  aria-describedby="emailFeedback"
                  :state="errors.missing('email')"
                  required
                >
                </b-form-input>
                <b-form-invalid-feedback id="emailFeedback">
                  {{ errors.get('email') || 'This is a required email field and must be maximum 255 characters' }}
                </b-form-invalid-feedback>
              </b-form-group>
            
            </b-col>
          </b-form-row>
          
          <b-form-group
            id="avatarLabel"
            label="Avatar"
            label-for="avatar"
            description="Only image png,jpg,gif,svg,minimum 100X100px"
          >
            <!-- Accept specific image formats by extension -->
            <image-component
              :is-valid="errors.missing('avatar')"
              :preview-image="previewAvatar"
              @imageLoaded="saveImageToForm"
              required
            >
            </image-component>
            <div class="text-danger" v-if="errors.has('avatar')">
              {{ errors.get('avatar') || 'This is a required image file and must be minimum 100x100px' }}
            </div>
          </b-form-group>
          
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
  import ImageComponent from './ImageComponent';
  import Errors from '../utilities/Errors';
  import AlertComponent from './AlertComponent';
  
  export default {
    name: 'ClientForm',
    components: {
      AlertComponent,
      ImageComponent,
    },
    props: {
      new: {
        type: Boolean,
        required: false,
        default: false,
      },
      id: {
        type: Number,
        required: false,
        default: null,
      },
      client: {
        type: Object,
        required: false,
        default: function() {
          return {};
        },
      },
    },
    data: function() {
      return {
        show: true,
        errors: new Errors(),
        first_name: '',
        last_name: '',
        email: '',
        avatar: '',
        previewAvatar: '',
        alertMessage: '',
      };
    },
    methods: {
      getData() {
        if (this.isNew()) {
          let formData = new FormData();
          formData.append('avatar', this.avatar);
          formData.append('first_name', this.first_name);
          formData.append('last_name', this.last_name);
          formData.append('email', this.email);
          return formData;
        } else {
          return {
            avatar: this.avatar.src,
            first_name: this.first_name,
            last_name: this.last_name,
            email: this.email,
          };
        }
      },
      getHeaders() {
        if (this.isNew()) {
          return {
            headers: {'content-type': 'multipart/form-data'},
          };
        } else {
          return null;
        }
      },
      onSubmit(event) {
        let vm = this;
        event.preventDefault();
        this.$http[this.getEndpointMethod()](this.getEndpoint(), this.getData(), this.getHeaders()).then(response => {
          if (response.status === 2000) {
            this.alertMessage = 'Client Saved Successfully';
          } else {
            this.alertMessage = response.statusText;
          }
          vm.$refs.alert.showAlert();
        }).catch(error => {
          console.error(error.response);
          console.error(error.request);
          console.error(error.message);
          if (vm.errors) {
            vm.errors.record(error.response.data.errors);
          } else {
            this.alertMessage = error.response.statusText;
            vm.$refs.alert.showAlert();
          }
        });
      },
      
      onReset(event) {
        event.preventDefault();
        //reset fields
        this.avatar = '';
        this.first_name = '';
        this.last_name = '';
        this.email = '';
        /* Trick to reset/clear native browser form validation state */
        this.show = false;
        this.$nextTick(() => {
          this.show = true;
        });
      },
      saveImageToForm(image) {
        if (image) {
          this.avatar = image;
        }
      },
      isNew() {
        return !this.client.id;
      },
      getEndpoint() {
        if (this.isNew()) {
          return this.route('clients.store').url();
        }
        
        return this.route('clients.update', {client: this.client.id}).url();
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
          return 'Create New Client';
        }
        return 'Edit Client ' + this.first_name + ' ' + this.last_name;
      },
    },
    created() {
      if (this.client.id) {
        this.first_name = this.client.first_name;
        this.last_name = this.client.last_name;
        this.email = this.client.email;
        this.previewAvatar = this.client.avatar_path;
      }
    },
  };
</script>