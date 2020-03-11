<template>
  <main class="white-block">
    <section class="container">
      <div class="row justify-content-center">
        <div class="col-10">
          <h1>Акции</h1>
          <hr>
        </div>
      </div>  
    </section>
  </main>
</template>
 
<script>
  export default {
    name: "pageShares",
    data() {
      return {
        breadcrumb: [
          {
            html: '<i class="fa fa-home" aria-hidden="true"></i>',
            to: { name: 'home' }
          },
          {
            text: 'Акции',
            to: { name: 'pageShares' }
          }
        ]
      }
    },
    created() {
      this.$emit('breadcrumb', this.breadcrumb)
    }
  }
</script>
 
<style scoped>

</style>