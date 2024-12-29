export interface Props {
    matches: Match[]
    years: string[]
}

export interface Form {
    compares: string[]
    percentage: number
    url: string
    years: string[]
}

export const parts = ['Base', 'Skin', 'Eyes', 'Mane Type', 'Mane Color', 'Slot 1', 'Slot 2', 'Slot 3', 'Slot 4', 'Slot 5', 'Slot 6', 'Slot 7', 'Slot 8', 'Slot 9', 'Slot 10', 'Mutation']

export interface Parts {
    Base: string
    Skin?: string
    Eyes: string
    Mane: string
    "Mane Type"?: string
    "Mane Color"?: string
    "Slot 1"?: string
    "Slot 2"?: string
    "Slot 3"?: string
    "Slot 4"?: string
    "Slot 5"?: string
    "Slot 6"?: string
    "Slot 7"?: string
    "Slot 8"?: string
    "Slot 9"?: string
    "Slot 10"?: string
    Mutation: string
}

export interface Match extends Parts {
    date: string
    matches: (keyof Parts)[]
    percent: number
    image: string
}
