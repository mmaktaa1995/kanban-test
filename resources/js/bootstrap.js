/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import Vue from 'vue';
import VModal from 'vue-js-modal'

window.axios = axios;

window.axios.defaults.baseURL = document.head.querySelector('meta[name="api-base-url"]').getAttribute('content');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    bus.$emit('flash-message', {text: error.response.data.message, type: 'error'});
    if (error.response.status === 401) {
        localStorage.removeItem('user')
        app.user = null;
        setTimeout(() => router.push('/login'), 400)
    }
    return Promise.reject(error)
})

window.bus = new Vue();

Vue.component('icon-add', require('./components/Shared/icons/Add.vue').default);
Vue.component('icon-edit', require('./components/Shared/icons/Edit.vue').default);
Vue.component('icon-delete', require('./components/Shared/icons/Delete.vue').default);
Vue.component('icon-loader', require('./components/Shared/icons/Loader.vue').default);

Vue.component('floating-button', require('./components/Shared/FloatingButton.vue').default);
Vue.component('async-button', require('./components/Shared/AsyncButton.vue').default);
Vue.component('form-input', require('./components/Shared/Input.vue').default);
Vue.component('form-text-area', require('./components/Shared/Textarea.vue').default);
Vue.component('flash-message', require('./components/Shared/FlashMessage.vue').default);
Vue.component('add-board', require('./components/Board/add.vue').default);
Vue.component('kanban-board', require('./screens/KanbanBoard.vue').default);

const filter = (text, length, clamp) => {
    clamp = clamp || '...';
    return text.length > length ? text.slice(0, length) + clamp : text;
};

Vue.filter('truncate', filter);
Vue.use(VModal);

