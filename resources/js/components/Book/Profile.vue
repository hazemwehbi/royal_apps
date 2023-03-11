<template>
    <div>
        <h4 class="text-center">Book Profile</h4><br/>
        <div class="row">
            <div class="col-md-6 mx-auto">
               <img :src="imgDataUrl"  style="width:100%"/>
          
            </div>
        </div>
            <div class="col-md-10 row mx-auto mt-2">
               <div class="col-md-6">
                <h3>Author Data</h3>
                <div>Name: {{author.name}}</div>
                  <div>Phone: {{author.phone}}</div>
                    <div>BirthDay: {{author.birthday}}</div>
                      <div>Address: {{author.address}}</div>
                    </div>
                     <div class="col-md-6">
                              <h3>Book Data</h3>
                <div>Title: {{book.title}}</div>
                  <div>Subject: {{book.subject}}</div>
                    <div>Serial Number: {{book.serial_number}}</div>
                      <div>Version Date: {{book.version_date}}</div>
                    </div>
                </div>
                <div class="my-2 py-2 px-2" style="    background: lightgray;">Book Description: {{book.description}}</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                author: {},
                book:{},
                error: false,
                errorMessage: '',
                errors: {},
                imgDataUrl:''
            }
        },
created(){
this.getData()
},
        methods: {
                   getData() {
          

            this.axios
                .get(window.location.origin+`/api/v1/book/${this.$route.params.id}`)
                .then((response) => {
                    this.book = response.data.data;
                     
                     this.imgDataUrl = response.data.data.media[response.data.data.media.length-1].original_url
                     this.author = response.data.data.author;
                    
                })
                .catch(error => {
                    alert(error.response.data.message);
                    this.$router.push({name: 'book'});
                });
        },

        }
    }
</script>