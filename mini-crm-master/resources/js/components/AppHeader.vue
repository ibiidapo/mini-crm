<template>
  <header-component
    :links="links"
    v-show="this.$currentUser !== null"
  ></header-component>
</template>

<script>
  import HeaderComponent from './HeaderComponent';
  
  export default {
    name: 'AppHeader',
    components: {HeaderComponent},
    data: function() {
      return {
        links: [
          {
            id: 'clients',
            title: this.$trans.get('navigation.clients.index'),
            show: true,
            hasChild: true,
            children: [
              {
                id: 'clients-add',
                title: this.$trans.get('navigation.clients.add'),
                href: this.route('clients.create').url(),
                disabled: false,
                hasChild: false,
              }, {
                id: 'clients-view',
                title: this.$trans.get('navigation.clients.view'),
                href: this.route('clients.index').url(),
                disabled: false,
                hasChild: false,
              },
            
            ],
          }, {
            id: 'transactions',
            title: this.$trans.get('navigation.transactions.index'),
            show: true,
            hasChild: true,
            children: [
              {
                id: 'transactions-add',
                title: this.$trans.get('navigation.transactions.add'),
                href: this.route('transactions.create').url(),
                disabled: false,
                hasChild: false,
              }, {
                id: 'transactions-view',
                title: this.$trans.get('navigation.transactions.view'),
                href: this.route('transactions.index').url(),
                disabled: false,
                hasChild: true,
              },
            
            ],
          },
        ],
      };
    },
  };
</script>