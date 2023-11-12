<?php

namespace App\Models\Contracts;


class JsonBaseModel extends BaseModel
{
    private $db_path;
    private $table_file_path;

    public function __construct()
    {
        $this->db_path = BASE_PATH . 'storage/jsondb/';
        $this->table_file_path = $this->db_path  . $this->table . '.json';
    }

    private function write_table(array $data): void
    {
        file_put_contents($this->table_file_path, json_encode($data));
        var_dump($data);
    }

    private function read_table(): array
    {
        $table_data = json_decode(file_get_contents($this->table_file_path));
        return $table_data ?? array();
    }
    // create
    public function create(array $data): int
    {
        $table_data = $this->read_table();
        $table_data[] = $data;
        $this->write_table($table_data);
        return 0;
    }

    // read
    public function find(int $id): object
    {
        $table_data = $this->read_table();

        foreach ($table_data as $record) {
            if (isset($record->id) && $record->id == $id) {
                var_dump($record);
                echo '<br />';
            }
        }
        return (object)[];
    }

    public function get(array $columns, array $where): array
    {
        return [];
    }

    // update
    public function update(array $columns, array $where): int
    {
        return 0;
    }

    // delete
    public function delete(array $where): int
    {
        return 0;
    }
}
