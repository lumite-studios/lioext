import { App } from "vue"
import { usePage } from "@inertiajs/vue3"
import { G_TRANS, T_TRANS } from '@/types/symbols'

export default {
    install: (app: App) => {
        app.config.globalProperties.$t = <T extends TranslationArgs>(key: string, args: null | T = null, group: null | string = null): string => {
            return $t<T>(key, args, group)
        }
        app.config.globalProperties.$g = <T extends TranslationArgs>(key: string, args: null | T = null, group: null | string = null): string => {
            return $g<T>(key, args, group)
        }
        app.provide(T_TRANS, $t)
        app.provide(G_TRANS, $g)
    }
}

export type TransFunction = <T extends TranslationArgs>(key: string, args: null | T, group: null | string) => string

export type TranslationArgs = {
    [key: string]: string
}

function TranslationFunction<T extends TranslationArgs>(translations: string, key: string, args: null | T = null, group: null | string = null): string {
    const locale = usePage().props.global.locale
    const parsed = JSON.parse(translations)
    let output = ''

    /**
     * In english just use the key itself.
     */
    if (locale === 'en') {
        output = key
    } else {
        if (group === null && Object.prototype.hasOwnProperty.call(parsed, key)) {
            output = parsed[key]
        } else if (Object.prototype.hasOwnProperty.call(parsed, group) && Object.prototype.hasOwnProperty.call(parsed[group], key)) {
            output = parsed[group][key]
        } else {
            output = key
        }
    }

    if (args !== null) {
        Object.keys(args).forEach((key: string) => {
            output = output.replace(new RegExp(':' + key, 'g'), args[key])
        })
    }

    return output
}

function $t<T extends TranslationArgs>(key: string, args: null | T = null, group: null | string = null): string {
    return TranslationFunction<T>(usePage().props.translations, key, args, group)
}

function $g<T extends TranslationArgs>(key: string, args: null | T = null, group: null | string = null): string {
    return TranslationFunction<T>(usePage().props.global.translations, key, args, group)
}
