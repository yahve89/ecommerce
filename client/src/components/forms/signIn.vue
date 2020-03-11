<template>
    <div class="card">
        <div class="card-header">
            <p class="h4 text-center">{{ title }}</p>
        </div>
        <div class="card-body">
            <b-alert v-if="error" show variant="danger">{{ error }}</b-alert>
            <b-form @submit="onSubmit" v-if="show">
                <b-form-group :id="`${prefixId}Email`" label="Email:" label-for="Email">
                    <b-form-input :id="`${prefixId}Email`" v-model="form.email" type="email" :invalid-feedback="invalidFeedbackEmail" :valid-feedback="validFeedbackEmail" :state="stateEmail" required>
                    </b-form-input>
                </b-form-group>
                <b-form-group :id="`${prefixId}Password`" label="Пароль:" label-for="password">
                    <b-form-input :id="`${prefixId}Password`" v-model="form.password" :invalid-feedback="invalidFeedbackPassword" :valid-feedback="validFeedbackPassword" :state="statePassword" type="password" required>
                    </b-form-input>
                </b-form-group>
                <div class="text-right">
                    <b-button type="submit">Войти</b-button>
                </div>
                <div class="clearfix"></div>
            </b-form>
        </div>
    </div>
</template>
<script>

export default {
    name: 'signIn',
    props: ['prefixId', 'title'],
    computed: {
        stateEmail() {
            return this.form.email.length >= 4 ? true : false
        },
        invalidFeedbackEmail() {
            var reg = /[а-яА-ЯёЁ]/g;
    
            if (this.form.email.search(reg) !=  -1)
                this.form.email  =  this.form.email.replace(reg, '')

            if (this.form.email.length > 4) {
                return ''
            } else if (this.form.email.length > 0) {
                return 'Enter at least 4 characters'
            } else {
                return 'Please enter something'
            }
        },
        validFeedbackEmail() {
            return this.stateEmail === true ? 'Thank you' : ''
        },
        statePassword() {
            return this.form.password.length >= 4 ? true : false
        },
        invalidFeedbackPassword() {
            var reg = /[а-яА-ЯёЁ]/g;
    
            if (this.form.password.search(reg) !=  -1) {
                this.$set(this.form, 'password', '')
                return 'Доступны только латинские символы'
            } else if (this.form.password.length > 4) {
                return ''
            } else if (this.form.password.length > 0) {
                return 'Enter at least 4 characters'
            } else {
                return 'Please enter something'
            }
        },
        validFeedbackPassword() {
            return this.statePassword === true ? 'Thank you' : ''
        }
    },
    data: function() {
        return {
            form: {
                email: '',
                password: ''
            },
            error: false,
            show: true
        }
    },
    methods: {
        onSubmit(evt) {
            evt.preventDefault();
            var token = "Basic " + window.btoa(this.form.email + ':' + this.form.password);
            var config = {
                "headers": {
                    "Authorization": token
                }
            };
            this.$http.get('/security/sign-in', config).then(function(response) {
                if (!response.data.error) {
                    if (response.data) {
                        localStorage.setItem('token', token);
                        this.$router.go('/cabinet');
                    } else {
                        this.$set(this, 'error', 'Не верный логин или пароль')
                    }
                } else {
                    this.$set(this, 'error', 'Сервис временно недоступен.')
                }
            }.bind(this));
        }
    }
}
</script>