<template>
  <b-navbar :toggleable="toggleable" :type="type" :variant="variant">
    
    <!-- Navbar toggle for smaller screens -->
    <b-navbar-toggle
      target="nav_collapse"
    ></b-navbar-toggle>
    <!-- Brand - Home -->
    <b-navbar-brand
      :href="route('home')"
      :class="{active : currentLocation.indexOf('home') > -1}"
    >
      {{$trans.get('navigation.home')}}
    </b-navbar-brand>
    <!-- Left aligned nav items -->
    <b-collapse is-nav id="nav_collapse">
      <b-navbar-nav v-for="link in links"
                    :key="link.id"
      >
        
        <template v-if="link.hasChild">
          <b-nav-item-dropdown
            :text="link.title"
            v-show="link.show"
            center>
            <b-dropdown-item
              v-for="child in link.children"
              :href="child.href"
              :disabled="child.disabled"
              :key="child.id"
              :class="{active : currentLocation.endsWith(child.href)}"
            >
              {{child.title}}
            </b-dropdown-item>
          </b-nav-item-dropdown>
        </template>
        <b-nav-item
          v-else
          :href="link.href"
          :disabled="link.disabled"
        >
          {{link.title}}
        </b-nav-item>
      
      </b-navbar-nav>
      
      <!-- Right aligned nav items -->
      <b-navbar-nav
        class="ml-auto"
        v-if="logoutLink && this.$currentUser !== null">
        <b-nav-item-dropdown right>
          <!-- Using button-content slot -->
          <template slot="button-content">
            <em>{{ this.$currentUser.name}}</em>
          </template>
          <b-dropdown-item
            :href="route('logout')"
            @click.prevent="logoutUser"
          >
            {{$trans.get('navigation.logout')}}
          </b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    
    </b-collapse>
  </b-navbar>
</template>

<script>
  import Form from '../utilities/Form';
  
  export default {
    name: 'HeaderComponent',
    props: {
      links: {
        type: Array,
        required: true,
      },
      toggleable: {
        type: String,
        required: false,
        default: 'md',
      },
      type: {
        type: String,
        required: false,
        default: 'dark',
      },
      variant: {
        type: String,
        required: false,
        default: 'dark',
      },
      fixed: {
        type: String,
        required: false,
        default: 'top',
      },
      sticky: {
        type: Boolean,
        required: false,
        default: false,
      },
      logoutLink: {
        type: Boolean,
        required: false,
        default: true,
      },
    },
    data: function() {
      return {
        currentLocation: location.href,
        logoutForm: new Form([]),
      };
    },
    methods: {
      isActive(el) {
        console.debug(el);
        return window.location.href === this.href;
      },
      logoutUser() {
        this.logoutForm.post(this.route('logout'), null).then(function(data) {
          window.location.reload(true);
        }).catch(function(data) {
          console.error(data);
        });
      },
    },
    computed: {
      csrf() {
        return document.head.querySelector('meta[name="csrf-token"]');
      },
    },
  };
</script>