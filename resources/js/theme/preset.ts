import { definePreset } from '@primevue/themes'
import Theme from '@primevue/themes/aura'
import { getMessageScheme } from './consts'

const preset = definePreset(Theme, {
    components: {
        //
    }
})
console.log(preset.components)

export default preset
