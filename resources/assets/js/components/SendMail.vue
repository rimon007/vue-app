<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Send Mail</div>

                    <div class="panel-body">
                        <form class="form-horizontal" @submit.prevent="sendMail" enctype="multipart/form-data">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                                <span class="input-group-addon" id="sizing-addon3"><i class="fa fa-user"></i></span>
                                <input type="text" 
                                    class="form-control" 
                                    placeholder="Username" 
                                    name="username" 
                                    aria-describedby="sizing-addon3"
                                    v-model="send.username">
                            </div>
                            
                            <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                                <span class="input-group-addon" id="sizing-addon3">@</span>
                                <input type="text" 
                                    class="form-control" 
                                    placeholder="Email"  
                                    name="email"
                                    aria-describedby="sizing-addon3"
                                    v-model="send.email">
                            </div>
                            
                            <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                                <span class="input-group-addon" id="sizing-addon3">@</span>
                                <input type="text" 
                                    class="form-control" 
                                    placeholder="Subject"  
                                    name="subject"
                                    aria-describedby="sizing-addon3"
                                    v-model="send.subject">
                            </div>
                            
                            <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                                <span class="input-group-addon" id="sizing-addon3"><i class="fa fa-user"></i></span>
                                <input type="text" 
                                    class="form-control" 
                                    placeholder="Message"  
                                    name="message"
                                    aria-describedby="sizing-addon3"
                                    v-model="send.message">
                            </div>

                            <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                                <span class="input-group-addon" id="sizing-addon3"><i class="fa fa-user"></i></span>
                                <input type="file" 
                                    class="form-control" 
                                    placeholder="File Attach"  
                                    name="attachment" 
                                    v-on:change="onFileChange"
                                    aria-describedby="sizing-addon3">
                            </div>

                            <button class="btn btn-primary btn-sm">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {
                csrfToken: window.Laravel.csrfToken,

                send: {
                    username: '',
                    subject: '',
                    email: '',
                    message: '',
                    attachment: ''
                }
            }
        },

        methods: {
            sendMail() {
                /*console.log(this.send);
                let form = document.querySelector('form');
                let request = new XMLHttpRequest();
                let formData = new FormData(form);

                request.open('post', [['mail']]);
                request.send(formData);*/



                axios.post('/mail', this.send)
                  .then(function (response) {
                    console.log(response);
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.send.attachment = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }
</script>
