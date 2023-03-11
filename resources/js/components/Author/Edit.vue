<template>
    <div>
        <h4 class="text-center">Author Edit</h4><br/>
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-danger" v-if="error">
                    {{ errorMessage }}
                </div>
                <form @submit.prevent="updateAuthor">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="author.name" name="name">
                        <form-error v-if="errors.name" :errors="errors">
                            {{ errors.name[0] }}
                        </form-error>
                    </div>
                        <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" v-model="author.address" name="address">
                        <form-error v-if="errors.address" :errors="errors">
                            {{ errors.address }}
                        </form-error>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" v-model="author.phone" name="phone">
                        <form-error v-if="errors.phone" :errors="errors">
                            {{ errors.phone }}
                        </form-error>
                    </div>
                      <div class="form-group">
                        <label>Phone</label>
                        <input type="date" class="form-control" v-model="author.birthday" name="birthday">
                        <form-error v-if="errors.birthday" :errors="errors">
                            {{ errors.birthday }}
                        </form-error>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Author</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                author: {},
                error: false,
                errorMessage: '',
                errors: {}
            }
        },
        created() {
            this.axios
                .get(window.location.origin+`/api/v1/author/${this.$route.params.id}`)
                .then((response) => {
                    this.author = response.data.data;
                })
                .catch(error => {
                    alert(error.response.data.message);
                    this.$router.push({name: 'home'});
                });
        },
        methods: {
            updateAuthor() {
                this.axios
                    .put(window.location.origin+`/api/v1/author/${this.$route.params.id}`, this.author)
                    .then((response) => {
                    if(response.data.success){
  this.$toastr.s("Saved Successfully");
                      this.$router.push({name: 'home'})
}
                      else
                      {
                          this.$toastr.e("There\'s something wrong with your request");
                        this.errors = response.data.data
                        this.errorMessage = response.data.message
                      }
                    })
                    .catch(error => {
                        this.error = true
                           this.$toastr.e("Some Thing Wrong");
                        this.errorMessage = error.response.data.message
                        this.errors = error.response.data.errors
                    });
            }
        }
    }
</script>