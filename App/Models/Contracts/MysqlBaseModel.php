<?php

namespace App\Models\Contracts;

use Medoo\Medoo;


class mysqlBaseModel extends BaseModel
{

    public function __construct($id = null)
    {
        // Stablish connection on the base model
        // using Medoo query builder library
        try {
            $this->connection = new Medoo([
                'type' => 'mysql',
                'host' => $_ENV['DB_HOST'],
                'database' => $_ENV['DB_NAME'],
                'username' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
                'error' => \PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (\PDOException $th) {
            throw $th;
        }

        // Check if the Model primary key is passed to the
        // constructor and assign the specific record properties
        // to the corresponding object
        if (!is_null($id)) {
            $this->find($id);
        }
    }

    /**  create new record using passed data in the specified table
     *   return last inserted record id
     */
    public function create(array $data): int
    {
        $this->connection->insert($this->table, $data);
        return $this->connection->id() ?? -1;
    }

    /**
     * @param int $id should be unique primary key
     * finding a unique record using primary key
     * sets the object properties using column names and values
     */
    public function find(int $id): object | null
    {
        $record = $this->connection->get($this->table, '*', [$this->primaryKey => $id]) ?? [];
        foreach ($record as $key => $value) {
            $this->setAttribute($key, $value);
        }
        return $this;
    }

    // select all the existing records and columns in a table
    public function getAll(): array
    {
        return $this->connection->select($this->table, "*");
    }

    /**
     * select a portion of data by specifying where conditions
     * and specific column names 
     */
    public function get(array $columns, array $where): array
    {
        return $this->connection->get($this->table, $columns, $where);
    }

    /**
     * update a specific record in database
     * @param array $data array of new record values
     * @param array $where array of conditions for the update operation
     * return the number of affected rows
     */
    public function update(array $data, array $where): int
    {
        $result = $this->connection->update($this->table, $data, $where);
        return $result->rowCount() ?? -1;
    }

    /**
     * delete specific rows by specifying 
     * where condition and return the number of affected rows
     */
    public function delete(array $where): int
    {
        return $this->connection->delete($this->table, $where)->rowCount() ?? -1;
    }

    public function remove()
    {
        $record_id = $this->{$this->primaryKey};
        $this->delete([$this->primaryKey => $record_id]);
        return $record_id;
    }

    public function save(): int
    {
        $record_id = $this->{$this->primaryKey};
        return $this->update($this->getAttributes(), [$this->primaryKey => $record_id]);
    }
}
