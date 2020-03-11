<template>
  <div id="slider" class="row">
    <div class="col-md-2 col-xs-12 text-center">
      <b-img 
        :src="image(item, '60_60')" 
        v-for="(item, i) in items" 
        :key="i" 
        v-on:mouseover="isActive(item.id)"
        class="my-md-1 m-1 image mx-md-auto d-md-block"
      ></b-img>
    </div>
    <div v-for="(item, i) in items" :key="i" v-show="activeImage[i].active" class="col-md-10 col-xs-12">
      <b-img center :src="image(item, '390_390')" class="image"></b-img>
    </div>
  </div>
</template>

<script>
export default {
  name: "slider",
  props: ['items'],
  data () {
    return {
      activeImage: []
    }
  },
  watch: {
    items: function () {
      if (this.items.length > 0) {
        this.load()
      }
    }
  },
  methods: {
    load: function () {
      for (let i = 0; i < this.items.length; i++) {
        if (i == 0) {
          this.activeImage.push({'active': true, 'id': this.items[i].id})
        } else {
          this.activeImage.push({'active': false, 'id': this.items[i].id})
        }
      }
    },
    image (item, wh) {
      if (item !== null) {
        if (screen.width < 380 && wh == '390_390') 
          return this.$http.defaults.baseURL +'file/image?cid=' +item.id +'&wh=280_280'

        return this.$http.defaults.baseURL +'file/image?cid=' +item.id +'&wh=' +wh
      }
    },
    isActive (id) {
      this.activeImage.filter(function (item) {
        item.active = false
    
        if (item.id == id)
          item.active = true
      })
    }
  }
}
</script>

<style scoped>
  .image {
    border: 1px solid rgba(0, 0, 0, 0.1);
  }
</style>