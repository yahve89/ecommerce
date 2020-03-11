<template>
  <main class="row">
    <carousel></carousel>
    <section class="col-12">
      <div class="box mb-3">
        <h2>Популярные товары</h2>
      </div>
      <div class="clearfix"></div>
      <items-block 
        class="mt-5"
        v-if="popular.length > 0" 
        :items="popular"
        :classes="`col-md-3 col-lg-3`"
      ></items-block> 
      <div class="text-center mt-5">
      </div>
    </section>
  </main>
</template>

<script>
import carousel from '../../components/blocks/carousel'
import itemsBlock from '../../components/blocks/itemsBlock'

export default {
  name: 'home',
  components: {
    carousel,
    itemsBlock
  },
  metaInfo: {
    title: 'Магазин косметики - Корейская косметика по всей России',
    meta: [
      { vmid: 'description', property: 'description', content: 'Vue App' },
      { vmid: 'og:title', property: 'og:title', content: 'Vue App' },
      { vmid: 'og:description', property: 'og:description', content: 'Vue App' },
    ],
  },
  data() {
    return {
      popular: [],
      brands: []
    }
  },
  created() {
    this.$emit('breadcrumb', false)
  },
  mounted() {
    this.$http.get('/site/home').then(response => {
      console.log(response.data)
      this.$set(this, 'popular', response.data.popular)
      this.$set(this, 'brands', response.data.brands)
    });
  },
  methods: {}
}
</script>

<style scoped>

</style>