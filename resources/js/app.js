require('./bootstrap');

import { createApp } from 'vue'
import App from './components/App.vue'

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

const app = createApp(App).mount('#app')
