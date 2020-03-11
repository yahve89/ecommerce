<template>
    <div id="signUp" class="col">
        <p class="h3 text-center">Регистрация</p>
        <b-form @submit="onSubmit" v-if="show">
            <b-form-group label="Email:" label-for="regEmail">
                <b-form-input 
                    id="regEmail" 
                    v-model="signUp.email" 
                    type="email" 
                    :invalid-feedback="invalidFeedbackEmail" 
                    :valid-feedback="validFeedbackEmail" 
                    :state="stateEmail" 
                    required
                    >

                </b-form-input>
            </b-form-group>
            <b-form-group label="Пароль:" label-for="password">
                <b-form-input 
                    id="regPassword" 
                    v-model="signUp.password" 
                    :invalid-feedback="invalidFeedbackPassword" 
                    :valid-feedback="validFeedbackPassword" 
                    :state="statePassword" 
                    type="password"
                    required
                    >
                    
                </b-form-input>
            </b-form-group>
            <b-form-group id="input-group-2" label="Повторите пароль:" label-for="rePassword">
                <b-form-input 
                    id="rePassword" 
                    v-model="signUp.rePassword" 
                    :invalid-feedback="invalidFeedbackRePassword" 
                    :valid-feedback="validFeedbackRePassword" 
                    :state="stateRePassword" 
                    type="password"
                    required
                    >
                    
                </b-form-input>
            </b-form-group>
            <div class="text-right">
                <b-button type="submit">Регистрация</b-button>
            </div>
            <div class="clearfix"></div>
        </b-form>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    name: 'signUp',
    computed: {
        stateEmail() {
            return this.signUp.email.length >= 4 ? true : false
        },
        invalidFeedbackEmail() {
            if (this.signUp.email.length > 4) {
                return ''
            } else if (this.signUp.email.length > 0) {
                return 'Enter at least 4 characters'
            } else {
                return 'Please enter something'
            }
        },
        validFeedbackEmail() {
            return this.stateEmail === true ? 'Thank you' : ''
        },
        statePassword() {
            return this.signUp.password.length >= 4 ? true : false
        },
        invalidFeedbackPassword() {
            if (this.signUp.password.length > 4) {
                return ''
            } else if (this.signUp.password.length > 0) {
                return 'Enter at least 4 characters'
            } else {
                return 'Please enter something'
            }
        },
        validFeedbackPassword() {
            return this.statePassword === true ? 'Thank you' : ''
        },
        stateRePassword() {
               return this.signUp.password === this.signUp.rePassword ? true : false
        },
        invalidFeedbackRePassword() {
            if (this.signUp.password.length !== this.signUp.rePassword)
                return 'Пароли не совпадают'
        },
        validFeedbackRePassword() {
            return this.stateRePassword === true ? 'Thank you' : ''
        },
    },
    data() {
        return {
            signUp: {
                email: '',
                password: ''
            },
            error: false,
            show: true
        }
    },
    methods: {
        onSubmit(evt) {
            evt.preventDefault()
            axios({
                method: "POST",
                "url": "/api/signUp",
                "data": JSON.stringify(this.signUp),
                "headers": { "content-type": "application/json" }
            }).then(result => {
                //console.log(result)
                location = document.location.href
            }, error => {
                console.error(error)
            })
        }
    }
}
</script>