<template>
  <main class="white-block">
    <section class="container">
      <div class="row justify-content-center">
        <div class="col-10">
          <h1>Моя корзина</h1>
          <hr>
          <div v-if="Array.isArray(basket)">
            <textarea name="" id="" cols="100" rows="10">{{ basket }}</textarea>
          </div>
          <div v-else>
            <p>Ваша корзина пуста.</p>
          </div>
        </div>
      </div>  
    </section>
  </main>
</template>
 
<script>
  export default {
    name: "pageBasket",
    data() {
      return {
        basket: JSON.parse(localStorage.getItem('basket')),
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
    mounted() {
      this.$emit('breadcrumb', this.breadcrumb)
    },
    methods: {
    }
  }
</script>
 
<style scoped>

</style>