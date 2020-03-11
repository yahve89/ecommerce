<template>
  <main class="white-block">
    <section class="container">
      <div class="row justify-content-center">
        <div class="col-10">
          <h1>Контактная информация</h1>
          <hr>
        
        </div>
      </div>
    </section>
  </main>
</template>
 
<script>
export default {
  name: "pageContacts",
  data() {
    return {
      breadcrumb: [
        {
          html: '<i class="fa fa-home" aria-hidden="true"></i>',
          to: { name: 'home' }
        },
        {
          text: 'Контактная информация',
          to: { name: 'pageContacts' }
        }
      ]
    }
  },
  created() {
    this.$emit('breadcrumb', this.breadcrumb)
  }
}
</script>