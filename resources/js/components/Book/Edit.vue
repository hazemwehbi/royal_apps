<template>
    <div>
        <h4 class="text-center">Book Edit</h4><br/>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="alert alert-danger" v-if="error">
                    {{ errorMessage }}
                </div>
                <form @submit.prevent="updateBook">
                    <div class="form-group">
                        <label>Author ID</label>
                        <select v-model="book.author_id" name="author_id" class="form-control">
                            <option v-for="author in authors" :key="author.id" :value="author.id">{{ author.name }}</option>
                        </select>
                        <form-error v-if="errors.author_id" :errors="errors">
                            {{ errors.author_id }}
                        </form-error>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="book.title" name="title">
                        <form-error v-if="errors.title" :errors="errors">
                            {{ errors.title }}
                        </form-error>
                    </div>
                     <div class="form-group">
                        <label>Subject</label>
                        <input type="text" class="form-control" v-model="book.subject" name="subject">
                        <form-error  v-if="errors.subject" :errors="errors">
                            {{ errors.subject }}
                        </form-error>
                    </div>
                     <div class="form-group">
                        <label>Version Date</label>
                        <input type="date" class="form-control" v-model="book.version_date" name="version_date">
                        <form-error  v-if="errors.version_date" :errors="errors">
                            {{ errors.version_date }}
                        </form-error>
                    </div>
                      <div class="form-group">
                        <label>Serial Number</label>
                        <input type="text" class="form-control" v-model="book.serial_number" name="serial_number">
                        <form-error  v-if="errors.serial_number" :errors="errors">
                            {{ errors.serial_number }}
                        </form-error>
                    </div>
                      <div class="form-group">
                                     <a class="btn" @click="toggleShow">Set Image</a>
  <my-upload field="img"
  v-show="show"
        @crop-success="cropSuccess"
        @crop-upload-success="cropUploadSuccess"
     
     
    :width="250"
    :height="250"
    :params="params"
    :headers="headers"
    :langType ="langType"
    img-format="png"></my-upload>
  <img :src="imgDataUrl?imgDataUrl:imageData">
  </div>
                      <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" class="form-control" v-model="book.description" name="description"></textarea>
                        
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Update Book</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                book: {},
                authors: [],
                error: false,
                errorMessage: '',
                errors: {},
                                  show: false,
    params: {
      token: '12321',
      name: 'image',

    },
    headers: {
      smail: '*_~',
    },
    langType: {
  type: String,
  'default': 'en'
},
    imgDataUrl: null,
    imageData:null
            }
        },
        created() {
            this.axios
                .get(window.location.origin+'/api/v1/author?order_by=name&sort=asc&select_field=id,name')
                .then((response) => {
                    this.authors = response.data.data;
                });

            this.axios
                .get(window.location.origin+`/api/v1/book/${this.$route.params.id}`)
                .then((response) => {
                    this.book = response.data.data;
                     this.imageData = response.data.data.media[response.data.data.media.length-1].original_url
                })
                .catch(error => {
                    alert(error.response.data.message);
                    this.$router.push({name: 'book'});
                });
        },
        methods: {
               toggleShow() {
      this.show = !this.show;
    },
          /**
     * crop success
     *
     * [param] imgDataUrl
     * [param] field
     */
    cropSuccess(imgDataUrl, field){
      console.log('-------- crop success --------');
      this.imgDataUrl = imgDataUrl;
      this.show=false
      console.log(this.imgDataUrl)
    },
    /**
     * upload success
     *
     * [param] jsonData  server api return data, already json encode
     * [param] field
     */
    cropUploadSuccess(jsonData, field){
      console.log('-------- upload success --------');
      console.log(jsonData);
      console.log('field: ' + field);
        this.show=false
    },
    /**
     * upload fail
     *
     * [param] status    server api return error status, like 500
     * [param] field
     */

            updateBook() {
                this.book.imgDataUrl = this.imgDataUrl
                this.axios
                    .put(window.location.origin+`/api/v1/book/${this.$route.params.id}`, this.book)
                    .then((response) => {
                      if(response.data.success){
                      this.$router.push({name: 'book'})
                        this.$toastr.s("Saved Successfully");
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