import './bootstrap';
import { createApp } from 'vue';

import KuryeHarita from './components/KuryeHarita.vue';

const app = createApp({});
app.component('kurye-harita', KuryeHarita);
app.mount('#app');
