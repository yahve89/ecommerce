<template>
  <div id="wrap">
    <header>
      <div class="top-menu py-2">
        <div class="container">
          <router-link active-class="active" to="/basket" class="px-2 pb-2">Корзина</router-link>
          <router-link v-if="!isLoggedIn" active-class="active" to="/login" class="px-2 pb-2">Войти</router-link>
          <router-link v-if="isLoggedIn" active-class="active" to="/profile" class="px-2 pb-2">Личный кабинет</router-link>
          <button v-if="isLoggedIn" @click="signOut" class="px-2 pb-2">Выход</button>
          <router-link v-if="!isLoggedIn" active-class="active" to="/registration" class="px-2 pb-2">Регистрация</router-link>
        </div>
      </div>

      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-4 my-md-4 my-md-2 mt-2 mb-3 p-md-0">
            <router-link to="/" id="logo">
              <span class="logo-wrap-1">Everyday</span>
              <span>-</span>
              <span class="logo-wrap-2">Сosmetics</span>
            </router-link>
            <p class="slogan m-0">Корейская косметика по всей России</p>
          </div>
          <div class="offset-lg-3 col-lg-3">
            <p class="h3 m-0 mt-md-1 text-center">
              <i class="fa fa-mobile" aria-hidden="true"></i>
              <b> +7 (999) 624-32-00</b>
            </p>
            <b-input-group class="mt-2">
              <b-form-input id="search" placeholder="Поиск товаров"></b-form-input>
              <b-input-group-append>
                <b-button variant="search">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </b-button>
              </b-input-group-append>
            </b-input-group>
          </div>
          <div class="col-lg-2 my-2 my-md-0 p-0">
            <div id="basket" class="pull-right d-block w-100">
              <router-link :to="`/basket`" class="d-block w-100">
                <div class="header-basket py-2 px-3">
                  <i class="fa fa-shopping-cart"></i>&nbsp;
                  <b>Моя корзина</b>
                </div>
                <div class="body-basket py-2 px-3">
                  <span v-text="basket.qty"></span>
                  <span>&nbsp;шт.&nbsp;–&nbsp;</span>
                  <span>{{ basket.sum.toLocaleString('ru-RU') }} руб.</span>
                </div>
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <b-navbar id="main-menu" toggleable="lg" type="dark" >
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
            <b-collapse id="nav-collapse" is-nav>
              <b-navbar-nav>
                <b-nav-item :active="isHome" class="navbar-item mx-1" to="/">Главная</b-nav-item>
                <b-nav-item :active="isCatalog" class="navbar-item mx-1" to="/catalog">Каталог товаров</b-nav-item>
                <!-- <b-nav-item active-class="active" to="/shares" class="navbar-item mx-1">Акции</b-nav-item> -->
                <b-nav-item active-class="active" to="/delivery" class="navbar-item mx-1">Доставка</b-nav-item>
                <b-nav-item active-class="active" to="/contacts" class="navbar-item mx-1">Контакты</b-nav-item>
                <b-nav-item active-class="active" to="/about" class="navbar-item mx-1">О компании</b-nav-item>
              </b-navbar-nav>
            </b-collapse>
          </b-navbar>
          <div class="col">
            <div class="row breadcrumb-block d-none d-sm-block">
                <b-breadcrumb :items="breadcrumb" v-if="breadcrumb"></b-breadcrumb>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="container white-block">
      <router-view @breadcrumb="getBreadcrumb"  @recountProduct="recountProduct"></router-view>
    </div>

    <footer>
      <div class="container py-3">
        <div class="row align-items-top">
          <div class="col-md-2">
            <p class="h5">Информация</p>
            <ul class="pl-0">
              <li>
                <router-link active-class="active" to="/about" class="px-2 pb-2">О компании</router-link>
              </li>
              <li>
                <router-link active-class="active" to="/contacts" class="px-2 pb-2">Контакты</router-link>
              </li>
              <li>
                <router-link active-class="active" to="/delivery" class="px-2 pb-2">Доставка</router-link>
              </li>
            </ul>
          </div>
          <div class="col-md-2">
            <p class="h5">Мой аккаунт</p>
            <ul class="pl-0">
              <li v-if="!isLoggedIn">
                <router-link active-class="active" to="/login" class="px-2 pb-2">Войти</router-link>
              </li>
              <li v-if="!isLoggedIn">
                <router-link active-class="active" to="/registration" class="px-2 pb-2">Регистрация</router-link>
              </li>
              <li v-if="isLoggedIn">
                <router-link active-class="active" to="/profile" class="px-2 pb-2">Личный кабинет</router-link>
              </li>
              <li>
                <router-link active-class="active" to="/basket" class="px-2 pb-2">Корзина</router-link>
              </li>
            </ul>
          </div>
          <div class="col-md-8">
            <small><p class="copyright">
                Вся информация на сайте – собственность интернет-магазина everyday-cosmetics.ru<br>
              Публикация информации с сайта everyday-cosmetics.ru без разрешения запрещена.<br>
              Информация на сайте everyday-cosmetics.ru не является публичной офертой. Указанные цены действуют только при оформлении заказа через интернет-магазин everyday-cosmetics.ru<br>
              Вы принимаете условия политики конфиденциальности и пользовательского соглашения каждый раз, когда оставляете свои данные в любой форме обратной связи на сайте everyday-cosmetics.ru
          </p></small>
          </div>
        </div>
      </div>
    </footer>

  </div>
</template>

<script>
import signIn from './components/forms/signIn'

export default {
  name: "app",
  components:{
    signIn
  },
  data() {
    return {
      role: false,
      breadcrumb: false,
      basket: {
        qty: 0,
        sum: 0
      }
    }
  },
  created() {
    this.$http.get('/security/sign-in').then(response => {
      this.$set(this, 'role', response.data)
    })
    this.recountProduct()
  },
  computed : {
    isLoggedIn : function() {
      if (localStorage.getItem('token') !== null)
        return true

      return false
    },
    isAdmin() {
      if (this.role == 'admin')
        return true

      return false
    },
    isHome: function() {
      if (this.$route.name == 'home')
        return true
      
      return false
    },
    isCatalog: function() {
      if (this.$route.name == 'catalog' || this.$route.name == 'product')
        return true
      
      return false
    }
  },
  methods: {
    recountProduct() {
      let qty = 0
      let sum = 0
      let basket = localStorage.getItem('basket')
      
      if (basket) {
        basket = JSON.parse(basket)
        basket.filter(item => {
          sum += item.price * item.qty
          qty += item.qty
        })
      }

      this.$set(this.basket, 'sum', sum)
      this.$set(this.basket, 'qty', qty)
    },
    getBreadcrumb(data) {
      this.$set(this, 'breadcrumb', data)
    },
    signOut(evt) {
      evt.preventDefault();
      this.$http.get('/security/sign-out').then(function (response) {
        if (!response.data.error) {
          localStorage.removeItem('token')
          this.$router.go('/login')
        } 
      }.bind(this))
    }
  }
}
</script>

<style scoped>
#basket a {
  text-decoration: none;
}
.header-basket {
  background: #ef556b;
  background: -webkit-linear-gradient(#ef556b 0%, #b43761 100%);
  background: -o-linear-gradient(#ef556b 0%, #b43761 100%);
  background: linear-gradient(#ef556b 0%, #b43761 100%);
}
.header-basket i {
  font-size: 18px;
}
.header-basket i, .header-basket b {
  color: #fff;
  text-transform: uppercase;
}
.body-basket {
  background: #2e2d2e;
}
.body-basket span {
  color: #888888;
}
.body-basket:hover span {
  color: #fff;
}
.top-menu {
  background: #2e2d2e;
}
.top-menu button {
  background: none;
  border: 0;
  color: #cccccc;
}
.top-menu a {
  color: #cccccc;
  text-decoration: none;
}
.top-menu a:hover, .top-menu button:hover {
  background: -webkit-linear-gradient(#444142 0%, #303030 100%);
  background: -o-linear-gradient(#444142 0%, #303030 100%);
  background: linear-gradient(#444142 0%, #303030 100%);
  color: #cd4073;
}
.top-menu a.active {
  color: #cd4073;
}
#logo {
  text-decoration: none;
}

.logo-wrap-1 {
  color: #515151;
  font-weight: bold;
}
.logo-wrap-2 {
  color: #ef556b;
  font-weight: bold;
}
#logo:hover .logo-wrap-1 {
  color: #ef556b;
  text-decoration: none;
}
#logo:hover .logo-wrap-2 {
  color: #515151;
  text-decoration: none;
}
.slogan {
  color: #515151; 
}
#main-menu {
  background: -webkit-linear-gradient(#411c3a 0%, #2e1e2d 100%);
  background: -o-linear-gradient(#411c3a 0%, #2e1e2d 100%);
  background: linear-gradient(#411c3a 0%, #2e1e2d 100%);
}
footer {
  background: #2f2d2e;
}
footer p.h5 {
  color: #ffffff;
  text-transform: uppercase; 
}
footer ul {
  list-style: none;
}
footer ul li a {
  color: #cccccc;
  text-decoration: none;
}
footer ul li a:hover {
  color: #cd4073;
}
footer ul li a.active {
  color: #cd4073;
}
.copyright {
  color: #cccccc;
}
</style>
