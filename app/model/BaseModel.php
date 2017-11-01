<?php

class BaseModel extends Nette\Object
{

    protected $db;

    public function __construct(Nette\Database\Connection $database)
    {
        $this->db = $database;
    }

}