<?php

namespace App\Traits;

trait ModelPrefixer {

    public function __construct(array $attributes = [])
    {
        if(isset($this->prefix)){
            $this->table = $this->prefix . "_" . $this->getTable() ;
        } else {
            $this->table = $this->getTable();
        }

        parent::__construct($attributes);
    }

    public static function getTableName()
    {
        return (new self)->getTableName();
    }
}
