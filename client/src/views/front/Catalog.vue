<template>
  <main class="row">
    <section class="col-mb-3 col-lg-3">
      <categoties :activeAlias="activeAlias" @title="setTitle"></categoties>
      <filter-bar :activeAlias="activeAlias"></filter-bar> 
    </section>
    <section class="col-mb-9 col-lg-9">
      <div class="box mb-3">
        <loading :active.sync="isLoading" :is-full-page="false"></loading>
        <h2>
          <span>Каталог товаров </span>
          <small v-show="title" v-text="`- ${title}`"></small>
        </h2>
      </div>
      <div class="clearfix"></div>
      <items-block 
        class="mt-5"
        v-show="products.length > 0"
        :items="products"
        :classes="`col-md-4 col-lg-4`"
      ></items-block> 
      <p v-show="products.length == 0 && isLoading == false">По Вашему запросу ничего не найдено!</p>
      <pagination 
        :totalPage="Math.ceil(pagination.totalCount / pagination.defaultPageSize)"
        v-show="(Math.ceil(pagination.totalCount / pagination.defaultPageSize) > 1)? true: false"
        :params="pagination"
        @getItems="getItems"
      ></pagination> 
    </section>
  </main>
</template>

<script>
import categoties from '../../components/blocks/categoties'
import itemsBlock from '../../components/blocks/itemsBlock'
import filterBar from '../../components/blocks/filterBar'
import pagination from '../../components/blocks/pagination'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

export default {
  name: 'catalog',
  components: {
    Loading,
    itemsBlock,
    filterBar,
    pagination,
    categoties
  },
  data() {
    return {
      title: '',
      breadcrumb: [
        {
          html: '<i class="fa fa-home" aria-hidden="true"></i>',
          to: { name: 'home' }
        },
        {
          text: 'Каталог товаров',
          to: { name: 'catalog' }
        }
      ],
      products: [],
      pagination:[],
      activeAlias: '',
      isLoading: true
    }
  },
  created() {   
    this.$emit('breadcrumb', this.breadcrumb)
    this.getItems(this.getLink())
  },
  watch: {
    $route() {
      this.$set(this, 'isLoading', true)
      this.$set(this, 'title', '')
      this.getItems(this.getLink())
    }    
  },
  methods: {
    setTitle(data) {
      this.$set(this, 'title', data)
    },
    async getItems(url) {
      this.$set(this, 'activeAlias', this.$route.params.alias)
      this.$set(this, 'products', [])
      this.$set(this, 'pagination', [])

      await this.$http.get(url).then(result => {
        this.$set(this, 'products', result.data.products)
        this.$set(this, 'pagination', result.data.pagination)         
        this.$set(this, 'isLoading', false)
      })
    },
    getLink() {
      let query

      if (typeof this.$route.query.brands !== 'undefined')
        if (Array.isArray(this.$route.query.brands)) {
          this.$route.query.brands.filter(function(brand) {
            if (typeof query === 'undefined') {
              query = '?brands[]=' +brand
            } else {
              query += '&brands[]=' +brand
            }
          })
        } else {
          query = '?brands[]=' +this.$route.query.brands
        }

      if (typeof this.$route.query.minPrice !== 'undefined')
        if (typeof query === 'undefined') {
          query = '?minPrice=' +this.$route.query.minPrice
        } else {
          query += '&minPrice=' +this.$route.query.minPrice
        }

      if (typeof this.$route.query.maxPrice !== 'undefined')
        if (typeof query === 'undefined') {
          query = '?maxPrice=' +this.$route.query.maxPrice
        } else {
          query += '&maxPrice=' +this.$route.query.maxPrice
        }

      if (typeof this.$route.query.page !== 'undefined')
        if (typeof query === 'undefined') {
          query = '?page=' +this.$route.query.page
        } else {
          query += '&page=' +this.$route.query.page
        }
      
      if (typeof query == 'undefined')
        query = ''

      return '/site' +this.$route.path +query
    }
  }
}
</script>

<style scoped>
  h2 > small {
    color: #888888;
    text-transform: lowercase;
  }
</style>