import { type App } from 'vue'
import dayjs, { Dayjs } from 'dayjs'
import advancedFormat from 'dayjs/plugin/advancedFormat'
import relativeTime from 'dayjs/plugin/relativeTime'
import timezone from 'dayjs/plugin/timezone'
import utc from 'dayjs/plugin/utc'
dayjs.extend(advancedFormat)
dayjs.extend(relativeTime)
dayjs.extend(timezone)
dayjs.extend(utc)

export default {
    install: (app: App) => {
        app.config.globalProperties.$datetime = (date: DateType = null): Dayjs => datetime(date)
    }
}

export type DateType = null | Date | string
export type DatetimeFunction = (date?: DateType) => Dayjs

export const datetime: DatetimeFunction = (date: DateType = null): Dayjs => {
    return dayjs(date ?? new Date).utc()
}
