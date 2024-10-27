<?php

namespace haiderjabbar\laravelsolr\Schema;

class SolrSchemaBuilder
{
    protected $fields = [];
    protected $currentField = null;

    public function name($name)
    {
        $this->currentField = ['name' => $name];
        $this->fields[] = &$this->currentField;
        return $this;
    }

    public function type($type)
    {
        $this->currentField['type'] = $type;
        return $this;
    }

    public function required($required = true)
    {
        $this->currentField['required'] = $required;
        return $this;
    }

    public function indexed($indexed = true)
    {
        $this->currentField['indexed'] = $indexed;
        return $this;
    }

    public function stored($stored = true)
    {
        $this->currentField['stored'] = $stored;
        return $this;
    }

    public function multiValued($multiValued = true)
    {
        $this->currentField['multiValued'] = $multiValued;
        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }
}
