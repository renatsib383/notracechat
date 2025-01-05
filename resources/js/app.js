import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import PrimeVue from 'primevue/config';
import { ru } from './ru.json';
import "primeicons/primeicons.css";
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                theme: 'none',
                ripple: true,
                locale: ru,
            })
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: 'var(--p-primary-600)',
    },
});