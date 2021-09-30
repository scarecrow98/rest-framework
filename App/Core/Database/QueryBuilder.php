<?php

namespace App\Core\Database;
use \Exception;

class QueryBuilder {
    private $query;
    private $mapped_class = null;
    private $is_prepared = false;
    private $params = null;
    private $query_result = null;
    private $db = null;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    private function next($query = '') {
        $this->appendQuery($query);
        return $this;
    }

    private function appendQuery($query_part) {
        $this->query .= ' ' . $query_part;
    }

    public function setQuery($query) {
        $this->query = $query;
    }

    public function getQuery() {
        return $this->query;
    }

    public function select($table_name, $fields) {
        $fields_string = '';

        if ($fields == '*') {
            $fields_string = '*';
        } else if (is_array($fields)) {
            $fields_string .= implode(', ', $fields);
        } else {
            throw new Exception("Function select expects parameter two to be array or '*'");
        }

        if (empty($table_name) || !is_string($table_name)) {
            throw new Exception("Function select expects parameter one to be a string");
        }

        return $this->next("SELECT $fields_string FROM $table_name");
    }

    public function where($statements) {
        if (empty($statements) || !is_array($statements)) {
            throw new Exception("Function where expects its parameter to be an array");
        }

        foreach ($statements as $field => $value) {
            
        }

        return $this->next("WHERE $statement");
    }

    public function orderBy($fields, $order) {
        $fields_string = '';

        if (is_string($fields) && !empty($fields)) {
            $fields_string = $fields;
        } else if (is_array($fields)) {
            $fields_string = implode(', ', $fields);
        } else {
            throw new Exception("Function orderBy expects parameter one to be array or a string");
        }

        if ($order !== -1 && $order !== 1) {
            throw new Exception("Function orderBy expects parameter two to be either -1 or 1");
        }

        $order_string = ($order == 1) ? 'ASC' : 'DESC';

        return $this->next("ORDER BY $fields_string $order_string");
    }

    public function limit($limit) {        
        if (!is_integer($limit) || $limit < 1) {
            throw new Exception("Function limit expects its parameter to be an integer");
        }

        return $this->next("LIMIT $limit");
    }

    public function insert($table_name, $fields, $values) {
        if (empty($table_name) || !is_string($table_name)) {
            throw new Exception("Function insert expects parameter one to be string");
        }
        
        if (!is_array($fields)) {
            throw new Exception("Function insert expects parameter two to be array");
        }

        if (!is_array($values)) {
            throw new Exception("Function insert expects parameter three to be array");
        }
        
        $fields_string = implode(', ', $fields);
        $placeholders = [];
        foreach($values as $val) $placeholders[] = '?';

        $placeholders_string = implode(', ', $placeholders);
        
        $this->is_prepared = true;
        $this->params = $values;
        return $this->next("INSERT INTO $table_name($fields_string) VALUES($placeholders_string)");
    }

    public function delete($table_name) {

        if (empty($table_name) || !is_string($table_name)) {
            throw new Exception("Function delete expects its parameter to be a string");
        }

        return $this->next("DELETE FROM $table_name");
    }

    public function execute() {
        if ($this->is_prepared) {
            $this->executePrepared();
        } else {
            $this->executeQuery();
        }

        return $this->next();
    }

    private function executeQuery() {
        try {
            $this->query_result = $this->db->query($this->query);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function executePrepared() {
        try {
            $this->db->prepare($this->query)->execute($this->params);
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getSingle() {
        if ($this->mapped_class) {
            return $this->query_result->fetchObject($this->mapped_class);
        }
        return $this->query_result->fetchObject($this->mapped_class);
    }

    public function getCollection() {
        if ($this->mapped_class) {
            return $this->query_result->fetchAll(\PDO::FETCH_CLASS, $this->mapped_class);
        }
        return $this->query_result->fetchAll();
    }
}