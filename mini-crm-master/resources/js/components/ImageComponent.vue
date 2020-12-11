<template>
  <b-container fluid>
    <b-row
      class="justify-content-center">
      <b-col>
        <b-row>
          <b-col
            v-if="previewImage || avatar"
            sm="12"
            md="4"
          >
            <b-img
              :src="previewImage || image"
              rounded="circle"
              width="150"
              height="150"
              class="m-1"
              alt="image"
            >
            </b-img>
          </b-col>
          <b-col
            v-if="!disabled"
            sm="12"
            md="8"
          >
            <b-form-file
              accept=".jpg, .jpeg, .png, .bmp, .gif, .svg"
              v-model="avatar"
              :state="Boolean(avatar) || isValid"
              placeholder="Choose an avatar..."
              @change="onImageChange"
              aria-describedby="fileFeedback"
              :required="required"
              ref="fileinput"
            ></b-form-file>
            <b-form-invalid-feedback id="fileFeedback">
              <slot name="message">Image is required</slot>
            </b-form-invalid-feedback>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
  export default {
    name: 'ImageComponent',
    props: {
      previewImage: {
        type: [Object, String],
        required: false,
        default: '',
      },
      isValid: {
        type: Boolean,
        required: true,
        default: true,
      },
      required: {
        type: Boolean,
        required: true,
        default: true,
      },
      minWidth: {
        type: Number,
        required: false,
        default: 100,
      },
      minHeight: {
        type: Number,
        required: false,
        default: 100,
      },
      disabled: {
        type: Boolean,
        required: false,
        default: false,
      },
    },
    data: function() {
      return {
        avatar: '',
        image: '',
      };
    },
    methods: {
      onImageChange(e) {
        let files = e.target.files || e.dataTransfer.files;
        if (!files.length) return;
        this.createImage(files[0]);
      },
      createImage(file) {
        let reader = new FileReader();
        let vm = this;
        reader.onload = (e) => {
          vm.image = e.target.result;
        };
        reader.readAsDataURL(file);
        // vm.image = file;
        vm.$emit('imageLoaded', file);
      },
    },
  };
</script>