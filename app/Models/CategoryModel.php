<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Category name is required',
            'min_length' => 'Category name must be at least 3 characters',
            'max_length' => 'Category name cannot exceed 100 characters'
        ]
    ];
}