<?php

namespace App\Models;

use App\Models\UserModel;

class UserManagementModel extends UserModel
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['email', 'username', 'password_hash', 'active', 'force_pass_reset'];
    protected $useSoftDeletes = true;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation rules for admin management
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username' => 'permit_empty|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
        'password' => 'permit_empty|min_length[8]',
        'active' => 'in_list[0,1]',
        'force_pass_reset' => 'in_list[0,1]'
    ];

    protected $validationMessages = [
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'Email address is already in use'
        ],
        'username' => [
            'min_length' => 'Username must be at least 3 characters',
            'max_length' => 'Username cannot exceed 30 characters',
            'is_unique' => 'Username is already in use',
            'alpha_numeric_punct' => 'Username can only contain alphanumeric characters and punctuation'
        ],
        'password' => [
            'min_length' => 'Password must be at least 8 characters'
        ],
        'active' => [
            'in_list' => 'Active status must be 0 or 1'
        ],
        'force_pass_reset' => [
            'in_list' => 'Force password reset must be 0 or 1'
        ]
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Hash password if provided
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
        }
        return $data;
    }

    public function save($data = null): bool
    {
        if ($data !== null && !is_array($data)) {
            $data = (array) $data;
        }

        if (empty($data['id']) && empty($data['password']) && empty($data['password_hash'])) {
            $this->errors['password'] = 'Password is required for new users';
            return false;
        }

        return parent::save($data);
    }

    public function getUsers($includeDeleted = false)
    {
        if ($includeDeleted) {
            return $this->withDeleted()->findAll();
        }
        return $this->findAll();
    }
}