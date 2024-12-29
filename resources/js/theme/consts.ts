export const getMessageScheme = (color: string, dark = false) => {
    return dark ? {
        // background: `color-mix(in srgb, {${color}.50}, transparent 5%)`,
        // borderColor: `{${color}.200}`,
        // color: `{${color}.600}`,
    } : {
        // background: `color-mix(in srgb, {${color}.50}, transparent 10%)`,
        // borderColor: `{${color}.100}`,
        // color: `{${color}.600}`,
    }
}
