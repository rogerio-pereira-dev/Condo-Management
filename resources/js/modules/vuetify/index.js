import 'vuetify/styles'


import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi'

const light = {
        dark: false,
        colors: {
            background: '#FFFFFF',
            surface: '#FFFFFF',
            primary: '#2F4C59',
            secondary: '#f07241',
            error: '#B00020',
            info: '#2196F3',
            success: '#4CAF50',
            warning: '#FB8C00',
        }
    }

const dark = {
    dark: true,
    colors: {
    //     background: '#FFFFFF',
    //     surface: '#FFFFFF',
        primary: '#2F4C59',
        secondary: '#f07241',
    //     error: '#B00020',
    //     info: '#2196F3',
    //     success: '#4CAF50',
    //     warning: '#FB8C00',
    }
}

const vuetify = createVuetify({
        components,
        directives,
        icons: {
            defaultSet: 'mdi',
            aliases,
            sets: {
                mdi,
            }
        },
        theme: {
            defaultTheme: 'light',
            variations: {
                colors: ['primary', 'secondary'],
                lighten: 4,
                darken: 4,
            },
            themes: {
                light,
                dark
            },
        }
    });

export default vuetify 