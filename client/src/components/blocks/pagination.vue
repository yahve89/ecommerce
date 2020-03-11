<template>
  <b-pagination-nav
    align="center" 
    :link-gen="linkGen" 
    :number-of-pages="totalCount" 
    use-router 
  ></b-pagination-nav>
</template>

<script>
  export default {
    name: "pagination", 
    props: ['params', 'totalPage'],
    data () {
      return {
        totalCount: 1
      }
    },
    watch: {
      totalPage: function () {
        if (this.totalPage > 1)
          this.$set(this, 'totalCount', this.totalPage)
      }
    },
    methods: {
      linkGen (pageNum) {
        let query

        if (typeof this.$route.query.brands !== 'undefined')
          if (Array.isArray(this.$route.query.brands)) {
            this.$route.query.brands.filter(function(brand) {
              if (typeof query === 'undefined') {
                query = '?brands=' +brand
              } else {
                query = query + '&brands=' +brand
              }
            })
          } else {
            query = '?brands=' +this.$route.query.brands
          }

        if (typeof this.$route.query.minPrice !== 'undefined')
          if (typeof query === 'undefined') {
            query = '?minPrice=' +this.$route.query.minPrice
          } else {
            query = query + '&minPrice=' +this.$route.query.minPrice
          }

        if (typeof this.$route.query.maxPrice !== 'undefined')
          if (typeof query === 'undefined') {
            query = '?maxPrice=' +this.$route.query.maxPrice
          } else {
            query = query + '&maxPrice=' +this.$route.query.maxPrice
          }

        if (typeof query !== 'undefined') {
          return pageNum === 1 ? query : query +'&page=' +pageNum
        } else {
          return pageNum === 1 ? '?' : '?page=' +pageNum
        }
      }
    }
  }
</script>