<?php

class CustomCollection implements ArrayAccess, Iterator{

    public function __construct(
        protected array $elements
    )
    {
        //
    }


    public static function make(array $array): static {

        return new static($array);
    }


    public function offsetExists(mixed $offset): bool {

        return array_key_exists($offset, $this->elements);
    }

    public function offsetGet(mixed $offset): mixed {

        return $this->offsetExists($offset)
                ? $this->elements[$offset]
                : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void {

        is_null($offset)
            ? $this->elements[] = $value
            : $this->elements[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void {

        if($this->offsetExists($offset)) {

            unset($this->elements[$offset]);
        }
    }

    public function current(): mixed {

        return current($this->elements);
    }

    public function key(): mixed {

        return key($this->elements);
    }

    public function next(): void {

        next($this->elements);
    }

    public function rewind(): void {

        reset($this->elements);
    }

    public function valid(): bool {

        return isset($this->elements[$this->key()]);
    }

    public function map(callable $callback): static {

        $keys = array_keys($this->elements);
        
        $items = array_map($callback, $this->elements, $keys);

        return new static(array_combine($keys, $items));
    }

    public function filter(?callable $callback, int $mode = 0): static {

        return new static(array_filter($this->elements, $callback, $mode));
    }

    public function reduce(callable $callback, mixed $initial = null): mixed {

        return array_reduce($this->elements, $callback, $initial);
    }

    public function sum(?string $key = null) {

        return $this->reduce(fn ($sum, $item) => $sum + (is_null($item) ? $item : $item[$key]), 0);
    }
}