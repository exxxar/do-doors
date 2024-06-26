import './bootstrap';
import '../css/app.css';
import store from './Store'
import VueLazyLoad from 'vue3-lazyload'

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import Notifications from '@kyvg/vue3-notification'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(store)
            .use(Notifications)
            .use(VueLazyLoad,
                {
                    loading: '/images/logo.jpg',
                    error: '/images/logo.jpg'
                })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
