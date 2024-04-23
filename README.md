# PHP-TypedArrays

## Why?
It the PHP ecosystem, we do not have a native way to tell an array what it should accept or not.   
We have the phpdoc, but it is just annotations, it does not work at runtime.   

## Solution
This library describes `abstract class TypedArray`.    
This class has a `protected array $items` property and implements the ArrayAccess native interface.   
Therefore, you will be able to access the `$items` elements of the class as if it was an array.   
When you will extend this class, you will need to define a `public satisfies function`.   
Via this function, you will define the conditions to allow an item to be added or not in the items property.   

## How it works
Via the `offsetSet` function of the `ArrayAccess` interface, we will first check if the value passes the satisfies function.   
If it does not, we will not add the item value, neither update it.   

## How to use
Declare a class extending TypedArray.   
In this class, implement a satisfies method returning a bool, if true, the element will be added/updated, if false, it will be ignored.   
Eg: 
```php
class RandomObj 
{}

class TypedObject extends TypedArray
{
    public function satisfies(mixed $item): bool
    {
        // Add the element only if it is an instance of RandomObj
        return $item instanceof RandomObj;
    }
}

// Output: object(RandomObj)#2 (0) {}
// Ignores the 'r', 1, 3 and 4
$typed = new TypedObject(['r', 1, new RandomObj(), 3, 4]);
```