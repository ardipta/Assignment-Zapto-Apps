<?php
namespace App\Interfaces;
use Illuminate\Http\Request;

interface ProductInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(Request $request);
    public function edit(Request $request, int $id);
    public function delete(int $id);
}
