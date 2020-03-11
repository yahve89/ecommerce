<template>
 <main class="content container">
    <div class="row justify-content-center">    
      <section class="col-10 pt-3 pb-2">
        <p class="h3">Личная информация и контакты</p>
        <hr class="my-1">
        <p>Здесь вы можете изменить свои личные данные</p>
      </section>
      <section class="jumbotron col-10 mt-1 pt-5 pb-4">
        <div class="row">
            <div class="col-md-8">
              <b-container fluid>
                <b-row class="my-1">
                  <b-col sm="3">
                    <label for="first_name">Имя:</label>
                  </b-col>
                  <b-col sm="9">
                    <b-form-input 
                      id="first_name" 
                      v-model="profile.first_name"
                      :state="null"
                    ></b-form-input>
                  </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                      <label for="last_name">Фамилия:</label>
                    </b-col>
                    <b-col sm="9">
                      <b-form-input 
                        id="last_name" 
                        v-model="profile.last_name"
                        :state="null"
                      ></b-form-input>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                      <label for="patronymic">Отчество:</label>
                    </b-col>
                    <b-col sm="9">
                      <b-form-input 
                        id="patronymic" 
                        v-model="profile.patronymic"
                        :state="null"
                      ></b-form-input>
                    </b-col>
                </b-row>
                <br>
                <b-row class="my-1">
                  <b-col sm="3">
                    <label for="location">Адрес:</label>
                  </b-col>
                  <b-col sm="9">
                    <b-form-input 
                      id="location" 
                      :state="null"
                      v-model="profile.location"
                    ></b-form-input>
                  </b-col>
                </b-row>
                <b-row class="my-1">
                  <b-col sm="3">
                    <label for="phone">Телефон:</label>
                  </b-col>
                  <b-col sm="9">
                    <b-form-input 
                        id="phone" 
                        v-model="profile.phone"
                        :state="null"
                    ></b-form-input>
                  </b-col>
                </b-row>
                <b-row class="my-1">
                  <b-col sm="3">
                    <label for="email">E-mail:</label>
                  </b-col>
                  <b-col sm="9">
                    <b-form-input 
                      id="email" 
                      v-model="user.email" 
                      :state="null"
                      disabled
                    ></b-form-input>
                  </b-col>
                </b-row>
            </b-container>
          </div>
          <div class="col-md-4">
            <div class="row justify-content-center">
              <b-form-group label="Пол" class="my-0 col-xs-10">
                <b-form-radio-group
                  v-model="profile.gender"
                  :options="genderList"
                  name="radio-options"
                ></b-form-radio-group>
              </b-form-group>
            </div>
          </div>
          <div class="col mt-3 text-right">
            <b-button @click="updateUser" variant="outline-primary">Сохранить изменения</b-button>
          </div>
        </div>
      </section>
    </div>
  </main>
</template>

<script>
export default {
  name: "profile",
  data() {
    return {
      breadcrumb: [
        {
          html: '<i class="fa fa-home" aria-hidden="true"></i>',
          to: { name: 'home' }
        },
        {
          text: 'Профиль',
          to: { name: 'profile' }
        }
      ],
      user: [],
      'gender': null,
      genderList: [
        { text: 'Мужской', value: 'male' },
        { text: 'Женский', value: 'female' }
      ],
      profile: []
    }
  },
  created() {
    this.$emit('breadcrumb', this.breadcrumb)
  },
  mounted() {
    this.$http.get('/security/user').then(result => {
     this.$set(this, 'user', result.data.user)
     this.$set(this, 'profile', result.data.profile) 
    })
  },
  methods: {
    updateUser() {
      let data =  encodeURIComponent(JSON.stringify({Profile: this.profile}))
        .replace(/[!'()]/g, escape).replace(/\*/g, "%2A").replace(/\./g, "%dot%"); // &middot;

      this.$http.put('/security/update-profile', data).then(() => {
        // console.log(result)
      }, () => {
        this.$router.push({name: 'Page404'})
      })      
    }
  }
}
</script>
