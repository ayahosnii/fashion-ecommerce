import { createApp } from 'vue';
import App from '../../../frontend/src/App.vue';
import FrontLayout from '../../../frontend/src/components/layouts/FrontLayout.vue';
import router from '../../../frontend/src/routes/index.js';

const app = createApp(App);

app.component('front-layout', FrontLayout);
app.use(router);
app.mount('.vue');
