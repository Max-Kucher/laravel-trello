require('./bootstrap');

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import App from './components/App.vue'
import About from './components/About.vue'

const app = createApp({});

const router = new createRouter({
    history: createWebHistory(),
    // mode: 'history',
    routes: [
        {
            path: '/',
            name: 'index',
            component: App,
        },

        {
            path: '/about-us',
            name: 'about',
            component: About,
        },
    ],
});

app.use(router)

app.mount('#app')
