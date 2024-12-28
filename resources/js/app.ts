import { createApp, h, type DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import PrimeVue from 'primevue/config'
import AppLayout from '@/views/layouts/app.vue'
import preset from './theme/preset'

createInertiaApp({
    title: (title: string) => `${title} :: Archwardens`,
    resolve: (name: string) => {
        const pages = import.meta.glob('../views/pages/**/*.vue', { eager: true })
        const page: DefineComponent = pages[`../views/pages/${name}.vue`] as DefineComponent
        page.default.layout = Object.hasOwn(page.default, 'layout')
            ? page.default.layout
            : AppLayout
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                ptOptions: {
                    mergeSections: true,
                    mergeProps: true
                },
                theme: {
                    preset,
                    options: {
                        darkModeSelector: '.dark',
                    }
                }
            })
            .mount(el)
    },
})
