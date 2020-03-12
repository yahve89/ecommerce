<template>
  <main class="row justify-content-center">
    <section class="col-mb-3 col-lg-3">
      <categoties></categoties> 
    </section>
    <section class="col-mb-9 col-lg-9">
      <h2>Моя корзина</h2>
      <div v-if="Array.isArray(basket) && basket.length > 0" class="col-12">
        <div v-for="(product, i) in basket" :key="i" class="row py-2 my-3 item">
          <div class="col-lg-2">
            <router-link :to="`/product/${product.alias}`">
              <b-img center :src="preview(product)" class="image"></b-img>
            </router-link>
          </div>
          <div class="col-lg-10">
            <router-link :to="`/product/${product.alias}`" v-text="product.name"></router-link>
            <hr class="my-2">
            <div class="row">
              <div class="col-lg-8">
                <p  class="mb-1">
                  <b>за 1 шт.</b>&nbsp;-&nbsp;<span v-text="sumPrice(product)"></span>
                  <span>&nbsp;руб.</span>
                </p>
                <p>
                  <b>итого</b>&nbsp;-&nbsp;
                  <span v-text="sumPrice(product, product.qty)"></span>
                  <span>&nbsp;руб.</span>
                </p>
              </div> 
              <div class="col-lg-4 text-right">
                <div class="d-block pb-1">
                  <b-form-spinbutton id="sb-inline" v-model="product.qty" inline ></b-form-spinbutton> 
                </div>
                <button class="btn btn-outline-default" @click="deleteProduct(product)">
                  <i class="fa fa-trash-o" aria-hidden="true"></i> 
                  Удалить
                </button>            
              </div>
            </div>
          </div>
        </div>
        <div class="subtotal row">
          <div class="col-12 text-right">
            <span>Итого: <span v-text="total.toLocaleString('ru-RU')"></span>&nbsp;руб.</span>
          </div>
        </div>
      </div>
      <div v-else class="col-12">
        <p>Ваша корзина пуста</p>
      </div>
    </section>
  </main>
</template>
 
<script>
import categoties from '../../components/blocks/categoties'

export default {
  name: "pageBasket",
   components: {
    categoties
  },
  data() {
    return {
      basket: JSON.parse(localStorage.getItem('basket')),
      total: 0,
      breadcrumb: [
        {
          html: '<i class="fa fa-home" aria-hidden="true"></i>',
          to: { name: 'home' }
        },
        {
          text: 'Моя корзина',
          to: { name: 'pageBasket' }
        }
      ]
    }
  },
  watch: {
    basket: {
      handler: function () {
        this.recountProduct()
        this.$emit('recountProduct')
      },
      deep: true
    }
  },
  mounted() {
    this.$emit('breadcrumb', this.breadcrumb)
    this.recountProduct()
  },
  methods: {
    preview (preview) {
      if (preview !== null)
        return this.$http.defaults.baseURL +'file/image?cid=' +preview.cid +'&wh=130_130'
      
     // return 
    },
    sumPrice (product, qty = 1) {
      let price = product.price * qty
      return Number(price).toLocaleString('ru-RU')
    },
    deleteProduct(product) {
      this.$set(this, 'basket', this.basket.filter(item => item.pid !== product.pid))

      if (this.basket.length > 0) {
        localStorage.setItem('basket', JSON.stringify(this.basket))
      } else {
        localStorage.removeItem('basket')
      }

      this.$emit('recountProduct')
    },
    recountProduct() {
      let sum = 0
      this.basket.filter(item => {sum += item.price * item.qty})
      this.$set(this, 'total', sum)
      localStorage.setItem('basket', JSON.stringify(this.basket))  
    },
  }
}
</script>
 
<style scoped>
 .item {
  border: 1px solid rgba(0, 0, 0, 0.1);
 }
 .btn-outline-default {
    width: 115px;
 }
</style>