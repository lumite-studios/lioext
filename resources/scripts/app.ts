import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, h, type DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import AppLayout from '@/layout/app.vue'

import '@/styles/app.scss'
import 'primeicons/primeicons.css'
import TranslationPlugin from '@/scripts/plugins/translation'
import Theme from '@/styles/theme'
import PrimeVue from 'primevue/config'
import BadgeDirective from 'primevue/badgedirective'
import Ripple from 'primevue/ripple'
import ToastService from 'primevue/toastservice'
import Tooltip from 'primevue/tooltip'
import dayjs from 'dayjs'
import advancedFormat from 'dayjs/plugin/advancedFormat'
import relativeTime from 'dayjs/plugin/relativeTime'
import utc from 'dayjs/plugin/utc'

dayjs.extend(advancedFormat) // eslint-disable-line
dayjs.extend(relativeTime) // eslint-disable-line
dayjs.extend(utc) // eslint-disable-line

createInertiaApp({
    resolve: (name: string) => {
        const page = resolvePageComponent(
            `../views/${name}.vue`,
            import.meta.glob<DefineComponent>('../views/**/*.vue')
        )
        page.then((module: DefineComponent) => {
            (module.default as { layout: unknown }).layout = AppLayout
        }).catch((err) => {
            console.log(err)
        })
        return page
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })

        app.use(plugin)
        app.use(PrimeVue, {
            pt: Theme,
            ptOptions: {
                mergeProps: true
            },
            ripple: true,
            unstyled: true,
        })
        app.use(ToastService)
        app.use(TranslationPlugin)

        app.directive('badge', BadgeDirective)
        app.directive('ripple', Ripple)
        app.directive('tooltip', Tooltip)

        app.provide('dayjs', dayjs)

        app.config.globalProperties.$dayjs = dayjs

        app.mount(el)
    },
}).catch((err) => {
    console.log(err)
})
