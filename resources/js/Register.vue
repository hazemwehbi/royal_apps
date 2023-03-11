<template>
    <div>
        <h4 class="text-center mt-5">Register Form</h4><br/>
        <div class="row card mx-5 py-3">
            <div class="col-md-6 mx-auto">
                <div class="alert alert-danger" v-if="error">
                    {{ errorMessage }}
                </div>
                <form @submit.prevent="register">
                     <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="auth.name" name="name">
                        <form-error v-if="errors.name" :errors="errors">
                            {{ errors.name }}
                        </form-error>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" v-model="auth.email" name="email">
                        <form-error v-if="errors.email" :errors="errors">
                            {{ errors.email }}
                        </form-error>
                    </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" v-model="auth.password" name="password">
                        <form-error v-if="errors.password" :errors="errors">
                            {{ errors.password }}
                        </form-error>
                    </div>
 <div class="d-flex">
                    <button type="submit" class="btn btn-primary">Register</button>
                     <router-link to="/login" class="nav-item nav-link">Login</router-link>
                     </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import store from './store'
    export default {
        data() {
            return {
                auth: {
                    name:'',
                    email:'',
                    password:'',
                    confirm_password:''
                },
                error: false,
                errorMessage: '',
                errors: {}
            }
        },
        methods: {

          register() {
                axios
                    .post('/register', this.auth)
                    .then((response) => {
                        console.log(response)
                     if(response.data.success){
                         store.dispatch('auth/login', response.data)
                         this.$toastr.s("Saved Successfully ");
                       this.$router.push({name: "home"});
                     }
                      else
                      {
                        this.$toastr.e("There\'s something wrong with your request");
                        this.errors = response.data.data
                        this.errorMessage = response.data.message
                      }

                    })
                    .catch(function (error) {
                        console.log(error)
                    });

            }
    }
    }
</script>
