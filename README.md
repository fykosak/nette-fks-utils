# FKS utils for nette 
![Lines of code](https://img.shields.io/tokei/lines/github/fykosak/nette-fks-utils)![PHP](https://github.com/fykosak/nette-fks-utils/actions/workflows/php.yml/badge.svg)![PSR-12](https://github.com/fykosak/nette-fks-utils/actions/workflows/php-psr.yml/badge.svg)

## Currency & Price
### Currency.php
Something like enum :) Methods `cases`, `tryFrom`, `from` and property `value` similar like enum(PHP8.1).
Implemented is only `EUR` and `CZK`. 

To format amount use method `format(float $amount):string`

### Price.php
Representation of single currency price. Currency is passed as required parameter of constructor and can not be changed.
If amount is not present in constructor, will be set to `0.0`. To modify amount use method `add`, to substrate use `add` with negative amount. 
```php
$price = new Price(Currency::from(Currency::CZK), 4.5);
$price->add(5.0);
$price->add(-4.0);
$price->getAmount(); // return 5.5
$price->getCurrency();// return Currency object with value 'czk'
```

Method `__toString` is only delegate to `Currency::format()`.

### MultiCurrencyPrice
Represent container for price in more Currencies at the same time.
#### Base usage
```php
$multiPrice = new MultiCurrencyPrice([new Price(Currency::from(Currency::CZK), 4)]); // Create container with only CZK price and amout 4.0 CZK
$multiPrice->czk; // Price can be access wia magic __get, an key is ISO 4217 3char code and return Price object
$multiPrice->eur; // Throw \OutOfRangeException, Price in EUR is not set 

$multiPrice->czk = new Price(Currency::from(Currency::CZK)); // via magic __set can be set price
$multiPrice->czk = new Price(Currency::from(Currency::EUR)); // thow exception currecies muss be same

$multiPrice->eur = new Price(Currency::from(Currency::EUR)); // thow exception because EUR price is not present, only curencies registred in contructor can be used
```
#### Operation add

```php
$multiPrice1 = new MultiCurrencyPrice([
    new Price(Currency::from(Currency::CZK), 2),
]);
$multiPrice2 = new MultiCurrencyPrice([
    new Price(Currency::from(Currency::CZK), 1),
    new Price(Currency::from(Currency::EUR), 4),
]);

$multiPrice1->add($multiPrice2); // can be added because curencies of $multiprice1 is a subset of $multiprice2
$multiPrice1->eur; // but still thow exception and not added a new currency 
$multiPrice1->czk->getAmount(); // is 3.0 call add on Prices

$multiPrice2->add($multiPrice1); // thow exeption because $multiprice1 no contains eur, so $multiprice2 is not a subset of the $multiprice1

```
## BaseComponent

BaseComponent represent nette `Nette\Application\UI\Control` with possibility use nette/DI inject like in Presenters.

```php
class MyComponent extends \Fykosak\Utils\BaseComponent\BaseComponent
{
    private MyService $myService;
    public function injectMyService(MyService $myService):void
    {
        $this->myService = $myService; // works with BaseComponent in components too ;)
    }
} 
```
