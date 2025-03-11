<?php 

namespace Awl\Orm;

use PDO;

class Course extends Model
{
    public function __construct()
    {
        parent::__construct("courses");
    }

    public function getAllByCycle(string $cycle, ?int $limit = null): array
    {
        $query = $this->where("cycle", $cycle);
        
        if ($limit !== null) {
            $query->limit($limit);
        }
        
        return $query->getAll();
    }

    public function getByHours(int $hours, ?int $limit = null): array
    {
        $query = $this->where("hours", $hours, ">=", PDO::PARAM_INT);
        
        if ($limit !== null) {
            $query->limit($limit);
        }
        
        return $query->getAll();
    }
}