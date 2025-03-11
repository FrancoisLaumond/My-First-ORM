<?php

namespace Awl\Orm;

use PDO;
class Model 
{
    protected string $table;
    protected array $fields = [];
    protected array $conditions = [];
    protected array $updates = [];
    private ?int $limit = null;

    private PDO $connexion;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->connexion = Database::connect();
    }

    public function fields(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function where(string $field, $value, string $operator = "=", int $pdoType = PDO::PARAM_STR): self
    {
        $this->conditions[] = [
            'fields' => $field,
            'value' => $value,
            'operator' => $operator,
            'pdoType' => $pdoType
        ];

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function getById(int $id): array
    {
        $this->where("id", $id);
        $sql = $this->buildSql();

        $query = $this->connexion->prepare($sql);
        $query->bindValue(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $this->flush();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getFirst (): array
    {
        $this->limit(1);
        $sql = $this->buildSql();
        $query = $this->connexion->prepare($sql);
        
        foreach ($this->conditions as $condition) {
            $query->bindValue(":" . $condition['fields'], $condition['value'], $condition['pdoType']);
        }
        
        $query->execute();
        $this->flush();
        return $query->fetch(PDO::FETCH_ASSOC);
    }


    private function buildSql(): string
    {
        $sql = "SELECT ";
        // Si pas de field obligatoire on selectionne tout
        if (empty($this->fields)) {
            $sql .= "*";
        // Si fields on les selectionne
        } else {
            $sql .= implode(", ", $this->fields);
        }

        // il y a forcement une table dans le Constructeur
        $sql .= " FROM " . $this->table;

        // Si on a des conditions on les ajoute
        if (!empty($this->conditions)) {
            $sql .= " WHERE ";
            $conditions = [];
            foreach ($this->conditions as $condition) {
                $conditions[] = $condition['fields'] . " " . $condition['operator'] . " :" . $condition['fields'];
            }
            $sql .= implode(" AND ", $conditions);
        }

        // Correction de la condition pour le LIMIT
        if (!is_null($this->limit)) {
            $sql .= " LIMIT " . $this->limit;
        }

        return $sql;
        }
    

    public function getAll(): array
    {
        $sql = $this->buildSql();
        $query = $this->connexion->prepare($sql);
        
        foreach ($this->conditions as $condition) {
            $query->bindValue(":" . $condition['fields'], $condition['value'], $condition['pdoType']);
        }
        
        $query->execute();
        $this->flush();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function set(string $field, $value): self
    {
        $this->updates[$field] = $value;
        return $this;
    }

    public function update(): bool
    {
        if (empty($this->conditions) || empty($this->updates)) {
            return false;
        }

        $sql = "UPDATE " . $this->table . " SET ";
        $sets = [];
        foreach ($this->updates as $field => $value) {
            $sets[] = "$field = :set_$field";
        }
        $sql .= implode(", ", $sets);

        $sql .= " WHERE ";
        $conditions = [];
        foreach ($this->conditions as $condition) {
            $conditions[] = $condition['fields'] . " " . $condition['operator'] . " :" . $condition['fields'];
        }
        $sql .= implode(" AND ", $conditions);

        $query = $this->connexion->prepare($sql);

        foreach ($this->updates as $field => $value) {
            $query->bindValue(":set_$field", $value);
        }

        foreach ($this->conditions as $condition) {
            $query->bindValue(":" . $condition['fields'], $condition['value'], $condition['pdoType']);
        }

        $result = $query->execute();
        $this->flush();
        return $result;
    }
    // On vide les champs et les conditions pour eviter les colision
    private function flush(): void
    {
        $this->fields = [];
        $this->conditions = [];
        $this->limit = null;
    }
}