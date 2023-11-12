<?php

namespace App\Models\Contracts;



abstract class BaseModel implements CrudInterface
{
    protected $connection;
    protected $table;
    public $primaryKey = "id";
    protected $pageSize = 10;
    protected $attributes = [];

    protected function __construct($connection, $table, $primaryKey)
    {
    }


    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    protected function getAttribute($key)
    {
        if (is_null($key) || !array_key_exists($key, $this->attributes)) {
            return null;
        }
        return $this->attributes[$key];
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
    protected function setAttribute($key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function __get($property): string | int | null
    {
        return $this->getAttribute($property);
    }

    public function __set($key, $value)
    {
        if (is_null($key) || !array_key_exists($key, $this->attributes)) {
            return false;
        }
        $this->setAttribute($key, $value);
    }
}
