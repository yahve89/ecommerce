<template>
<div class="row justify-content-center">
  <div 
    class="align-self-center" :class="classes" v-for="(item, i) in items" :key="i">
    <div class="single-item px-3 mb-5">                             
      <div class="pb-3">
        <div class="h5 pt-1 text-center preview">
          <router-link :to="`/product/${item.product.alias}`">
            <b-img center :src="preview(item.preview)" :alt="item.product.name"></b-img>
          </router-link>
          <p class="mt-2" v-html="item.product.name"></p> 
        </div>
        <hr class="mt-1 mb-2">
        <div class="single-item-info">
          <i>&nbsp;</i>
          <b class="pull-right price">
            <span v-text="sumPrice(item.product)"></span>&nbsp;
            руб.
          </b>
        </div>  
      </div>
      <div class="button-bottom">
        <router-link 
          :to="`/product/${item.product.alias}`" 
          class="button-default"   
        >
        <span v-if="btnName" v-text="btnName"></span>
        <span v-else>Подробнее</span>
        </router-link>
      </div>                            
    </div>
  </div>
</div>
</template>

<script>
export default {
    name: "itemsBlock",
    props: ['items', 'btnName', 'classes'],
    methods: {
      preview (preview) {
        if (preview !== null)
          return this.$http.defaults.baseURL +'file/image?cid=' +preview.id +'&wh=150_150'
        
       // return 
      },
      sumPrice (product) {
        // let markup_price = product.price / 100 * product.markup
        // let price = Math.ceil(Number(markup_price) + Number(product.price))
        return Number(product.price).toLocaleString('ru-RU')
      }
    }
}
</script>

<style scoped>
.preview {
  position: relative;
  min-height: 300px;
}
.preview p {
  position: absolute;
  bottom: 0;
}
.price {
  font-size: larger;
}
.price i {
  font-size: medium;
}
.single-item {
  background: #f6f6f6 none repeat scroll 0 0;
  background: -webkit-linear-gradient(#ffffff 0%, #f6f6f6 100%);
  background: -o-linear-gradient(#ffffff 0%, #f6f6f6 100%);
  background: linear-gradient(#ffffff 0%, #f6f6f6 100%);
  border-bottom: 3px solid #5d1b4e;
  transition: all 0.3s ease 0s;
  border-radius: 0px;
}
.single-item .button-default {
  background: #ef556b none repeat scroll 0 0;
  background: -webkit-linear-gradient(#ef556b 0%, #b43761 100%);
  background: -o-linear-gradient(#ef556b 0%, #b43761 100%);
  background: linear-gradient(#ef556b 0%, #b43761 100%);
  padding: 8px 33px;
}
.single-item:hover {
  background: #ffffff none repeat scroll 0 0;
  box-shadow: 0 2px 20px rgba(34, 30, 31, 0.4);
}
.single-item:hover .button-default {
  background: #7a1d65 none repeat scroll 0 0;
  background: -webkit-linear-gradient(#7a1d65 0%, #5d1b4e 100%);
  background: -o-linear-gradient(#7a1d65 0%, #5d1b4e 100%);
  background: linear-gradient(#7a1d65 0%, #5d1b4e 100%);
  color: white;
}
.button-bottom {
  margin-bottom: -19.5px;
  text-align: center;
}
.button-default {
  background: #2d3e50 none repeat scroll 0 0;
  color: #ffffff;
  display: inline-block;
  font-size: 14px;
  margin: 0;
  padding: 15px 35px;
  text-transform: uppercase;
  font-weight: 400;
}
.single-item .button-default {
  border-radius: 0px;
  background: #ef556b none repeat scroll 0 0;
  background: -webkit-linear-gradient(#ef556b 0%, #b43761 100%);
  background: -o-linear-gradient(#ef556b 0%, #b43761 100%);
  background: linear-gradient(#ef556b 0%, #b43761 100%);
  padding: 8px 33px;
}
.single-item .button-default span {
  color: #ffffff;
}
.single-item a {
  transition: all 0.3s ease 0s;
  text-decoration: none;
  color: #000;
}
</style>