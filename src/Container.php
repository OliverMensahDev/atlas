<?php

namespace Atlas;

class Container
{
    private array $bindings = [];

    public function set(string $abstract, callable $concrete): void {
        $this->bindings[$abstract] = $concrete;
    }


    public function get(string $abstract): mixed
    {
        if (!isset($this->bindings[$abstract])) {
            throw new \Exception(
                "No binding found for {$abstract}"
            );
        }

        return ($this->bindings[$abstract])($this);
    }
}