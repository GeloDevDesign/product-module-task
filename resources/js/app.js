import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue'
import Welcome from './components/Welcome'


const app = createApp({})

app.component('welcome', Welcome)

app.mount('#vueApp')