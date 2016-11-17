<?php namespace App\Repositories;


interface AppealRepositoryInterface
{
    public function all();

    public function find($id);

    public function create($data);
}