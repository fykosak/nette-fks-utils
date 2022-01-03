# FKS utils for nette 
## Currency & Price
### Currency.php
Something like enum :) Methods `cases`, `tryFrom`, `try` and property `value` similar like PHP 8.1 enum.
Implemented is only `EUR` and `CZK`. 

To format amount use method `format(float $amount):string`

### Price.php
Representation of single currency price. Currency is passed as required parameter of constructor and can not be changed.
If amount is not present in constructor, will be set to `0.0`. To modify amount use method `add`, to substrate use `add` with negative amount. 

Method `__toString` is only delegate to `Currency::format()`.

### MultiCurrencyPrice
Represent container for price in more Currencies at the same time.
####Base usage
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

$multiPrice2->add($multiPrice1); // thow exeption because $multiprice1 no contain eur, so $multiprice2 is not a subset of $multiprice1

```
##BaseComponent

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
