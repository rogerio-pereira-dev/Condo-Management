import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
// import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

// Vuetify
import vuetify from './modules/vuetify'

//Pinia (state management)
import { createPinia } from 'pinia'

//Layout
import Layout from './Layouts/Layout.vue'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const pinia = createPinia();

createInertiaApp({
    title: (title) => `${appName}`,
    // resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        page.default.layout = Layout
        return page
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(pinia)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
