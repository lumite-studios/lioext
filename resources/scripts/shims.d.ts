import type { User } from '@/types/models/user/user'
import type { Pusher } from 'pusher-js'
import type { Channel, PresenceChannel } from 'laravel-echo'

declare global {
    interface Window {
        Pusher: Pusher
        Echo: {
            channel: (channel: string) => Channel,
            connect: () => void,
            disconnect: () => void,
            join: (channel: string) => PresenceChannel,
            leaveChannel: (channel: string) => void,
            leaveAllChannels: () => void,
            listen: (channel: string, event: string, callback: Function) => Channel,
            private: (channel: string) => Channel,
            encryptedPrivate: (channel: string) => Channel,
            socketId: () => string,
        }
    }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        $g: TranslationFunction
        $t: TranslationFunction
    }
}

declare module '@inertiajs/core' {
    interface PageProps {
        auth: User
        global: {
            locale: string
            locales: Array<string>
            translations: string
        }
        success: string
        translations: string
        [key: string]: unknown
    }
}
