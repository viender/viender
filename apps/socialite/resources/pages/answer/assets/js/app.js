import store from './store';

/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.$app = () => {
    Vue.component('comment', require('viender_socialite/core/js/components/comment.vue'));
    Vue.component('comment-list', require('viender_socialite/core/js/components/comment-list.vue'));
    Vue.component('comment-create-form', require('viender_socialite/core/js/components/comment-create-form.vue'));
    Vue.component('answer-preview', require('viender_socialite/core/js/components/answer-preview.vue'));
    Vue.component('question', require('viender_socialite/core/js/components/question.vue'));
    Vue.component('question-list', require('viender_socialite/core/js/components/question-list.vue'));
    Vue.component('answer-create-form', require('viender_socialite/core/js/components/answer-create-form.vue'));
    Vue.component('answer-create-modal', require('viender_socialite/core/js/components/answer-create-modal.vue'));
    Vue.component('more-menu', require('viender_socialite/core/js/components/more-menu.vue'));

    let feed = new Vue({
        el: '#app',

        store: new Vuex.Store(store),

        mounted() {
            this.$store.dispatch('navigation/getNotificationCount');
        },
    });
};
