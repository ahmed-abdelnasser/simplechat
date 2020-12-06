/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'

/////// scroll /////
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)
///////              /////


/////// notifications /////
import Toaster from 'v-toaster'
Vue.use(Toaster, {timeout: 5000})
// You need a specific loader for CSS files like https://github.com/webpack/css-loader
import 'v-toaster/dist/v-toaster.css'
///////              /////
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('message', require('./components/message.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        message: '',
        chat: {
            message: [],
            user: [],
            color: [],
            time:[],
            // usersNumbers:0,
        },
        usersNumbers:0,
        typing: '',
    },
    watch: {
        message() {
            Echo.private('chat')
                .whisper('typing', {
                    message: this.message
                });
        }
    },
    methods: {
        send: function () {
            if (this.message.length != 0) {
                this.chat.message.push(this.message);
                this.chat.user.push('you');
                this.chat.color.push('success');
                this.chat.time.push(this.getTime());

                axios.post('/send', {
                        message: this.message,
                        chat: this.chat,
                    })
                    .then(response => {
                        console.log(response);
                        this.message = '';
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }

        },
        getTime(){
          let time = new Date();
          return time.getHours()+':'+time.getMinutes()+':'+time.getSeconds();
        },
        getOldMessages(){
            axios.post('/getOldMessages')
            .then(response => {
              console.log(response);
              if (response.data != '') {
                  this.chat = response.data;
              }
            })
            .catch(error => {
              console.log(error);
            });
        }
    },
    mounted() {
        this.getOldMessages();
        Echo.private('chat')
            .listen('ChatEvent', (e) => {
                // console.log(e.message);
                this.chat.message.push(e.message);
                this.chat.color.push('warning');
                this.chat.user.push(e.user);
                this.chat.time.push(this.getTime());

                axios.post('/saveMessage',{
                    chat: this.chat                
                })
                .then()
                .catch(error => {
                  console.log(error);
                });


            }).listenForWhisper('typing', (e) => {
                if (e.message != '') {
                    this.typing = 'typing: ' + e.message;
                } else {
                    this.typing = ''
                }
            });

            Echo.join(`chat`)
            .here((users) => {
                // console.log( users );
                this.usersNumbers = users.length;
            })
            .joining((user) => {
                this.usersNumbers += 1;
                this.$toaster.success(user.name + ' is joined chat room')

                // console.log(user.name);
            })
            .leaving((user) => {
                this.usersNumbers -= 1;
                this.$toaster.warning(user.name + ' is leaved chat room.')
                // console.log(user.name);
            });


    }
});
