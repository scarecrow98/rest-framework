<?php

use App\Core\Database\DB;

class BaseModel {
    protected $table_name = '';
    protected $id_field = 'id';

    public function find($id) {
        return DB::qb()->select(self::$table_name, '*')
                        ->where()
    }

    public function all() {

    }
    
}