<template>
<div>
   <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <h3 class="text-center">BOOKSTORE MANAGEMENT</h3><br/>
        </div>
        <nav class="navbar navbar-expand-sm bg-light">
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link to="/" class="nav-item nav-link">Author</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/book" class="nav-item nav-link">Book</router-link>
            </li>
            
        
          </ul>
          <router-link to="/" class="nav-item nav-link ml-auto">{{user.name}}</router-link>
          <button @click="logout" class="btn nav-item nav-link btn-primary">Logout</button>
        </nav>
        <br/>
        <router-view></router-view>
        </div>
</template>

<script>
import store from './store'
export default {
 data(){
   return{
    user: null
   }
 },
 created(){
   this.getUser()
 },
 methods:{
    getUser(){
        this.user = store.getters['auth/user']
        console.log(this.user)
    },
    logout(){
      store.dispatch('auth/logout')
      this.$router.push('/login')
    }
 }
}
</script>

<style>

</style>
