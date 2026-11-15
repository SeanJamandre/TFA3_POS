<?php
namespace App\Models;
class CustomerModel extends \CodeIgniter\Model {
    protected $table = 'customers';
    protected $allowedFields = ['full_name', 'email'];
    protected $returnType = 'array';
}
