<?php

use ArrayAccess;

abstract class TypedArray implements ArrayAccess
{
    protected array $items;

    abstract public function satisfies(mixed $item): bool;

    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            if ($this->satisfies($item)) {
                $this->items[] = $item;
            }
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($this->satisfies($value)) {
            if (is_null($offset)) {
                $this->items[] = $value;
            } else {
                $this->items[$offset] = $value;
            }
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}
