<template>
  <b-carousel
    id="carousel"
    v-model="slide"
    :interval="4000"
    fade
    indicators
    background="#ababab"
    img-width="1519"
    img-height="759"
  >
    <router-link :to="item.link" v-for="(item, key) in items" :key="key"  >
      <b-carousel-slide :img-alt="item.alt" :img-src="item.src"></b-carousel-slide>
    </router-link>
  </b-carousel>
</template>

<script>
  export default {
    name: 'carousel',
    data() {
      return {
        items: [
          {
            alt:'рис 1',
            src: 'http://server/public/banners/slide1_image.jpg',
            link:'/catalog/makiyazh'
          },
          {
            alt:'рис 2',
            src: 'http://server/public/banners/slide2_image.jpg',
            link:'/catalog/krema-dlya-glaz'
          },
          {
            alt:'рис 3',
            src: 'http://server/public/banners/slide3_image.jpg',
            link:'/catalog/patchi-dlya-glaz'
          }
        ],
        slide: 0,
        sliding: true
      }
    },
    methods: {
    }
  }
</script>