<template>
  <main class="white-block">
    <section class="container">
      <div class="row justify-content-center">
        <div class="col-10">
          <h1>О компании</h1>
          <hr>
        </div>
      </div>  
    </section>
  </main>
</template>
 
<script>
  export default {
    name: "pageAbout",
    data() {
      return {
        breadcrumb: [
          {
            html: '<i class="fa fa-home" aria-hidden="true"></i>',
            to: { name: 'home' }
          },
          {
            text: 'О компании',
            to: { name: 'pageAbout' }
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