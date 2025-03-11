<?php 

namespace Awl\Orm;

class User extends Model
{
    public const ROLE_ELEVE = "eleve";
    public const ROLE_PROF = "prof";
    public function __construct()
    {
        parent::__construct("users");
    }

    public function eleves()
    {
        return $this->where("role", self::ROLE_ELEVE)->getAll();
    }

    public function professeurs()
    {
        return $this->where("role", self::ROLE_PROF)->getAll();
    }


}