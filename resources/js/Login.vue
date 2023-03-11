<template>
    <div>
        <h4 class="text-center mt-5">BookStore App</h4><br/>
        <div class="row card mx-5 py-3">
            <div class="col-md-6 mx-auto">
                <div class="alert alert-danger" v-if="error">
                    {{ errorMessage }}
                </div>
                <form @submit.prevent="login">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" v-model="auth.email" name="email">
                        <form-error v-if="errors.name" :errors="errors">
                            {{ errors.name[0] }}
                        </form-error>
                    </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" v-model="auth.password" name="password">
                        <form-error v-if="errors.name" :errors="errors">
                            {{ errors.name[0] }}
                        </form-error>
                    </div>
                    <div class="d-flex">
                    <button type="submit" class="btn btn-primary">Login</button>
                     <router-link to="/register" class="nav-item nav-link">Register</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import store from './store'
//import {useToast} from 'vue-toast-notification';
//import 'vue-toast-notification/dist/theme-sugar.css';

    export default {
        data() {
            return {
                auth: {
                    email:'',
                    password:''
                },
                error: false,
                errorMessage: '',
                errors: {}
            }
        },
        methods: {
     
            login() {
                this.axios
                    .post('/login', this.auth)
                    .then(response => {
                     store.dispatch('auth/login', response.data)
                      this.$toastr.s("Welcome "+ response.data.user.name);

                     this.$router.push({name: "home"});
            })
                    .catch(error => {
                        console.log(error)
                          this.$toastr.e("User Unauthinticated");
                        this.error = true
                        this.errorMessage = error.response.data.message
                        this.errors = error.response.data.errors
                    })
                    .finally(() => this.loading = false)
            }
        }
    }
</script>
