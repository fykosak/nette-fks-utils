export type MultiCurrencyPrice<TCurrency extends string, TNumber = number> = {
    [currency in TCurrency]: TNumber;
}
