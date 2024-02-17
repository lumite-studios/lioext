import { InjectionKey } from 'vue'
import dayjs from 'dayjs'
import { TransFunction } from '../scripts/plugins/translation'

export type Dayjs = ((date?: dayjs.ConfigType) => dayjs.Dayjs) | ((date?: dayjs.ConfigType, format?: dayjs.OptionType, strict?: boolean) => dayjs.Dayjs) | ((date?: dayjs.ConfigType, format?: dayjs.OptionType, locale?: string, strict?: boolean) => dayjs.Dayjs)

export const dayjsInject: InjectionKey<Dayjs> = Symbol('dayjs')

export const G_TRANS: InjectionKey<TransFunction> = Symbol('$g')
export const T_TRANS: InjectionKey<TransFunction> = Symbol('$t')
