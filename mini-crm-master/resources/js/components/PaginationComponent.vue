<template>
  <base-pagination
    :data="data"
    :limit="limit"
    :show-disabled="showDisabled"
    v-on:pagination-change-page="onPaginationChangePage">
    <ul class="pagination"
        v-if="computed.total > computed.perPage"
        slot-scope="{ data, limit, computed, prevButtonEvents, nextButtonEvents, pageButtonEvents }">
      <li
        class="page-item pagination-prev-nav"
        :class="{'disabled': !computed.prevPageUrl}"
        v-if="computed.prevPageUrl || showDisabled">
        <a
          class="page-link"
          href="#"
          aria-label="Previous"
          :tabindex="!computed.prevPageUrl && -1"
          v-on="prevButtonEvents">
          <slot name="prev-nav">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </slot>
        </a>
      </li>
      <li
        class="page-item pagination-page-nav"
        v-for="(page, key) in computed.pageRange"
        :key="key"
        :class="{ 'active': page === computed.currentPage }">
        <a
          class="page-link"
          href="#"
          v-on="pageButtonEvents(page)">{{ page }}</a>
      </li>
      <li
        class="page-item pagination-next-nav"
        :class="{'disabled': !computed.nextPageUrl}"
        v-if="computed.nextPageUrl || showDisabled">
        <a
          class="page-link"
          href="#"
          aria-label="Next"
          :tabindex="!computed.nextPageUrl && -1"
          v-on="nextButtonEvents">
          <slot name="next-nav">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </slot>
        </a>
      </li>
    </ul>
  </base-pagination>
</template>

<script>
  import BasePagination from './BasePagination';
  
  export default {
    name: 'PaginationComponent',
    components: {BasePagination},
    props: {
      data: {
        type: Object,
        default: () => {
        },
      },
      limit: {
        type: Number,
        default: 0,
      },
      showDisabled: {
        type: Boolean,
        default: false,
      },
    },
    methods: {
      onPaginationChangePage(page) {
        this.$emit('pagination-change-page', page);
      },
    },
  };
</script>

<style scoped>
  .pagination {
    margin-top: 40px;
  }
</style>