<template>
  <main class="content">
    <section class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <signIn prefixId="loginForm" :title="title"></signIn>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import signIn from '../../components/forms/signIn.vue';

export default {
  name: "Login",
  components: { signIn },
  metaInfo: {
    title: 'Магазин косметики - Личный кабинет',
  },
  data() {
    return {
      title: 'Для того чтобы войти, авторизуйтесь'
    }
  }
}
</script>