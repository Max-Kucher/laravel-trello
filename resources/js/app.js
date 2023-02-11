require('./bootstrap');

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'

import App from './components/App.vue'
import Home from './components/Home.vue'
import Desk from './components/desks/Desk.vue'
import ShowDesk from './components/desks/ShowDesk.vue'

const app = createApp(App);

const router = new createRouter({
    history: createWebHistory(),
    // mode: 'history',
    routes: [
        {
            path: '/',
            name: 'index',
            component: Home,
        },
        {
            path: '/desks',
            name: 'desks',
            component: Desk,
        },
        {
            path: '/desks/:deskId',
            name: 'show-desk',
            component: ShowDesk,
            props: true,
        },
    ],
});

app.use(router)

app.mount('#app')
