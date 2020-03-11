<template>
  <main class="pt-3">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <slider :items="collections"></slider>
      </div>
      <div class="col-md-6 mt-1">
        <h1 v-text="product.name"></h1>
        <div class="my-3 price mb-5">
          <span v-text="sumPrice(product)"></span>&nbsp;руб.
          <s class="ml-3">
            <span v-text="oldSumPrice(product)"></span>&nbsp;руб.
          </s>
        </div>
        <div class="form-inline mb-3">
          <b-form-spinbutton id="sb-inline" v-model="qty" inline></b-form-spinbutton>
          <button class="ml-2 btn btn-add-cart" @click="addCart">Добавить в корзину</button>
        </div>
        <hr>
        <div class="link">
          <p class="my-1">Бренд: 
            <router-link :to="`/catalog?brands=${brand.id}`" v-text="brand.name"></router-link>
          </p>
          <p class="my-1">Категория: 
            <router-link :to="`/catalog/${catalog.alias}`" v-text="catalog.name"></router-link>
          </p>
        </div>
        <hr>
      </div>
      <div class="mt-4 mb-5 col-md-11">
        <b-tabs content-class="mt-3">
          <b-tab title="Описание" active><p v-html="product.description"></p></b-tab>
          <b-tab title="Состав"><p v-html="product.composition"></p></b-tab>
          <b-tab title="Способ применения"><p v-html="product.mode_of_application"></p></b-tab>
        </b-tabs>
      </div>
    </div>
  </main>
</template>

<script>
import categoties from '../../components/blocks/categoties'
import slider from '../../components/blocks/slider'


export default {
  name: 'product',
  components: {
    categoties,
    slider
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
      product: [],
      collections: [],
      brand:[],
      catalog:[],
      preview:[],
      qty: 1
    }
  },
  created() {
    this.$emit('breadcrumb', this.breadcrumb)
  },
  async mounted() {
    await this.$http.get('/site/product/' +this.$route.params.alias).then(response => {
      this.$set(this, 'product', response.data.product)
      this.$set(this, 'brand', response.data.brand)
      this.$set(this, 'catalog', response.data.catalog)
      this.$set(this, 'collections', response.data.collections)
      this.$set(this, 'preview', response.data.preview)
 
      this.$emit('breadcrumb', [
        {
          html: '<i class="fa fa-home" aria-hidden="true"></i>',
          to: { name: 'home' }
        },
        {
          text: 'Каталог',
          to: { name: 'catalog' }
        },
        {
          text: response.data.product.name,
          to: { name: 'product' }
        }
      ])
    });
  },
  methods: {
    addCart () {
      let status = false
      let basket = []
      let current = localStorage.getItem('basket')
      
      let cart = { 
        pid: this.product.id, 
        price: this.product.price,
        name: this.product.name,
        alias: this.product.alias,
        cid: this.preview.id,
        qty: this.qty,

      }

      if (current) {
        current = JSON.parse(current)
        basket = current.filter(item => item.pid !== cart.pid)
      }

      basket.push(cart)
      localStorage.setItem('basket', JSON.stringify(basket))
      this.$emit('recountProduct')
    },
    sumPrice (product) {
      // let markup_price = product.price / 100 * product.markup
      // let price = Math.ceil(Number(markup_price) + Number(product.price))
      return Number(product.price).toLocaleString('ru-RU')
    },
    oldSumPrice (product) {
      let markup_price = product.price / 100 * 15
      let price = Math.ceil(Number(markup_price) + Number(product.price))
      return price.toLocaleString('ru-RU')
    }
  }
}
</script>

<style scoped>
h1 {
  font-size: 23px;
  color: #cd4073;
}
.price {
  font-weight: bold;
  font-size: 23px;
}
.price s, .price s span {
  font-weight: normal;
  font-size: 18px;
  color: #888888;
}
.btn-add-cart:hover {
  color: #fff;
  background: -webkit-linear-gradient(#7a1d65 0%, #5d1b4e 100%);
  background: -o-linear-gradient(#7a1d65 0%, #5d1b4e 100%);
  background: linear-gradient(#7a1d65 0%, #5d1b4e 100%);
  border-color: #7a1d65;
}
.btn-add-cart {
  color: #fff;
  background-color: #ef556b;
  background: -webkit-linear-gradient(#ef556b 0%, #b43761 100%);
  background: -o-linear-gradient(#ef556b 0%, #b43761 100%);
  background: linear-gradient(#ef556b 0%, #b43761 100%);
  border-color: #ef556b;
  text-transform: uppercase;
  border-radius: 0;
}
.btn-outline-secondary, .qty {
  border-radius: 0;
  border-color: #6c757d;
}
.btn-outline-secondary:hover i {
  color: #fff;
}
.link p {
  color: #888888;
}
.link a {
  color: #3e2639;
}
.link a:hover {
  text-decoration: none;
  color: #ef556b;
}
</style>