
export type MultiCurrencyPrice<TCurrency extends string>={
    [currency in TCurrency]: number;
}
