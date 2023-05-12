<?php

namespace ElePHPant\Cookie\Storage;


interface CookieStorageInterface
{
    public function set(string $name, ?string $value, int $expire): bool;

    public function get(?string $name = null);

    public function delete(?string $name = null): bool;
}
