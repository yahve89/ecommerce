<template>
  <div id="filter-bar" class="mt-4">
      <b-card no-body class="mb-0 mt-2">
        <b-form-group>
          <label for="">Бренды:</label>
          <b-form-checkbox-group id="checkbox-brand" v-model="brands" name="brand">
            <b-form-checkbox v-for="(option, i) in options" :key="i" :value="option.value" class="col-6 mr-0">{{ option.text }}</b-form-checkbox>
          </b-form-checkbox-group>
        </b-form-group>
      </b-card>
    <hr>
    <div class="row">
      <div class="col-6">
        <label for="minPrice">Стоимость от:</label>
      </div>
      <div class="col-6 pr-4">
        <b-form-input id="minPrice" size="sm" type="number" v-model="minPrice"></b-form-input>
      </div>
      <div class="col-6 my-1">
        <label for="maxPrice">Стоимость до:</label>
      </div>
      <div class="col-6 my-1 pr-4">
        <b-form-input id="maxPrice" size="sm" type="number" v-model="maxPrice"></b-form-input>
      </div>
      <div class="col-12">
        <hr class="mt-2 mb-0">
      </div>
      <div class="col-6">
          <b-button class="mr-3 my-3 btn-outline-default" @click="reset">Отменить</b-button>
      </div>
      <div class="col-6 text-right">
          <b-button class="my-3 d-block mx-auto btn-purpure" @click="sendFilter">Применить</b-button>
      </div>
      <div class="col-12">
        <hr class="mt-2 mb-0">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "filterBar",
  props: ['activeAlias'],
  data () {
    return {
      options: [],
      brands: [],
      minPrice: 0,
      maxPrice: 10000
    }
  },
  created() {
    if (typeof this.$route.query.brands !== 'undefined')
      if (Array.isArray(this.$route.query.brands)) {
        this.$route.query.brands.filter(function(brand) {
          this.brands.push(brand)
        }.bind(this))
      } else {
        this.brands.push(this.$route.query.brands)
      }
  },
  mounted() {
    this.load()
  },
  methods: {
    load () {
      this.$http.get('/site/filter').then(response => {
        this.$set(this, 'options', response.data.brands)
      })
    },
    reset () {
      this.brands = []
      
      if (this.$route.path !== this.$route.fullPath)
        this.$router.push({
          path: this.$route.path
        })
    },
    sendFilter () {
      let query = new Object()

      if (this.brands.length > 0)
        query.brands = this.brands


      if (this.minPrice > 0)
        query.minPrice = this.minPrice

       if (this.maxPrice > 0)
        query.maxPrice = this.maxPrice

      if (JSON.stringify(query) !== JSON.stringify(this.$route.query))
        this.$router.push({
          path: this.$route.path,
          query: query
        })
    }
  }
}
</script>

<style scoped>
#filter-bar {
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  
  border-right: 1px solid rgba(0, 0, 0, 0.1);
}
.filter-end {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.section-name {
  text-transform: uppercase;
  font-size: 16px;
  font-weight: bold;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  text-align: center;
}
.card-header {
  background-color: #fff;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.card {
  border: 0;
}
.card-body {
  padding: 0
}
</style>