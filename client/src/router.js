import Vue from 'vue'
import Router from 'vue-router'

import Profile from './views/cabinet/Profile.vue'

import Login from './views/front/Login.vue'
import Home from './views/front/Home.vue'
import PageAbout from './views/front/About.vue'
import PageCatalog from './views/front/Catalog.vue'
import PageDelivery from './views/front/Delivery.vue'
import PageShares from './views/front/Shares.vue'
import PageContacts from './views/front/Contacts.vue'
import PageProduct from './views/front/Product.vue'
import PageBasket from './views/front/Basket.vue'
import Page404 from './views/front/Page404.vue'


Vue.use(Router)

let router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/catalog',
      name: 'catalog',
      component: PageCatalog
    },
    {
      path: '/catalog/:alias',
      name: 'catalog',
      component: PageCatalog
    },
    {
      path: '/product/:alias',
      name: 'product',
      component: PageProduct
    },
    {
      path: '/profile',
      name: 'profile',
      component: Profile,
      meta: {
        requiresAuth: true,
        is_user: true
      }
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: {
        guest: true
      }
    },
    {
      path: '/about',
      name: 'pageAbout',
      component: PageAbout
    },
    {
      path: '/contacts',
      name: 'pageContacts',
      component: PageContacts
    },
    {
      path: '/delivery',
      name: 'pageDelivery',
      component: PageDelivery
    },
    {
      path: '/shares',
      name: 'pageShares',
      component: PageShares
    },
    {
      path: '/basket',
      name: 'pageBasket',
      component: PageBasket
    },
    {
      path: '*',
      name: 'page404',
      component: Page404
    }
  ],
  scrollBehavior () {
    return { x: 0, y: 0 }
  }
})

function getUser() {
  let promise = Vue.prototype.$http.get('/security/sign-in')
  return promise.then(function (response) {
    return response.data;  
  });
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (localStorage.getItem('token') == null) {
      next({
        path: '/login',
        params: { nextUrl: to.fullPath }
      })
    } else {
        if (to.matched.some(record => record.meta.is_admin)) {
          getUser().then((role) => {
            if (role === 'root') {
              next()
            } else {
              next({name: 'Page404'})
            }
          })
        } else if (to.matched.some(record => record.meta.is_user)) {
          getUser().then((role) => {
            if (role === 'user' || role === 'root') {
                next()
            } else {
                next({name: 'Page404'})
            }
          })
        } else {
          next()
        }
    }
  } else if (to.matched.some(record => record.meta.guest)) {
    if (localStorage.getItem('token') == null) {
      next()
    } else {
      next({name: 'profile'})
    }
  } else {
    next()
  }
})

export default router