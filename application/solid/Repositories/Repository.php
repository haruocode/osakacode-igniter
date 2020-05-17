<?php
namespace Solid\Repositories;


interface Repository {
    public function setModel(\MY_Model $model);
    public function save();
    public function getAll();
    public function findById($id);
}