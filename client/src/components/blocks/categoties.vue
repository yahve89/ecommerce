<template>
  <div id="categories" class="mt-2">
    <p class="section-name my-0 py-2">Категории</p>
    <div role="tablist">
      <b-card no-body class="mb-1">
        <div v-for="(item, i) in categories" :key="i">
          <b-card-header header-tag="header" class="p-1" role="tab">
            <a 
              v-b-toggle="`section-${i}`"
              class="btn-header-nav btn-block pl-1"
              v-text="item.parent.name"
            ></a>
          </b-card-header>
          
          <b-collapse 
            v-if="(item.parent.active == true)" 
            :id="`section-${i}`" 
            visible 
            accordion="categories" 
            role="tabpanel"
          >
            <b-card-body>
              <b-card-text>
                <router-link
                  v-for="(child, key) in item.childs"
                  :key="key" 
                  :to="`/catalog/${child.alias}`"
                  class="btn-block btn-nav-item pl-3 py-1 mt-0" 
                  active-class="active"
                  :active="child.active"
                  :class="(child.active == true)?'active':''"
                  v-text="child.name"
                ></router-link>
              </b-card-text>
            </b-card-body>
          </b-collapse>

          <b-collapse 
            v-if="(item.parent.active == false)" 
            :id="`section-${i}`" 
            accordion="categories" 
            role="tabpanel"
          >
            <b-card-body>
              <b-card-text>
                <router-link
                  v-for="(child, key) in item.childs"
                  :key="key" 
                  :to="`/catalog/${child.alias}`"
                  class="btn-block btn-nav-item pl-3 py-1 mt-0" 
                  active-class="active"
                  :active="child.active"
                  v-text="child.name"
                ></router-link>
              </b-card-text>
            </b-card-body>
          </b-collapse>
        </div>
      </b-card>
    </div>
  </div>
</template>

<script>
export default {
  name: "categoties",
  props: ['activeAlias'],
  data () {
    return {
      categories: []
    }
  },
  watch: {
    activeAlias: function (alias) {
        this.isActive(alias)
    } 
  },
  async mounted() {
     await this.$http.get('/site/categories').then(response => {
      this.$set(this, 'categories', response.data.categories)
      this.isActive(this.activeAlias)
    })
  },
  methods: {
    isActive (alias) {
      this.categories.filter(function (item) {
        this.$set(item.parent, 'active', false)

        item.childs.filter(function (child) {
          this.$set(child, 'active', false)
          
          if (child.alias == alias) {
            this.$set(item.parent, 'active', true)
            this.$set(child, 'active', true)
            this.$emit('title', child.name)
          }
        }.bind(this))
      }.bind(this))
    }
  }
}
</script>

<style scoped>
#categories {
    border-right: 1px solid rgba(0, 0, 0, 0.1);
}
.section-name {
  text-transform: uppercase;
  font-size: 16px;
  font-weight: bold;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  text-align: center;
}
.card-header {
  background-color: #fff;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.card {
  border: 0;
}
.btn-header {
  color: #311e2f;
  text-transform: uppercase;
  font-weight: bold;
}
.card-body {
  padding: 0
}
.btn-header-nav {
  font-size: 16px;
  color: #311e2f;
  font-weight: bold;

  /* text-transform: uppercase; */
  cursor: pointer;
}
.btn-header-nav:hover {
  text-decoration: none;
}
.btn-nav-item {
  color: #3e2639;
  text-decoration: none; 
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.btn-nav-item:hover {
  color: #cd4073;
}
.btn-nav-item.active {
  color: #cd4073;
  background: #eeeeee85;
  font-weight: bold;
  background: linear-gradient(#fff 0%, #eeeeee85 100%);
}
</style>