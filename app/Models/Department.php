<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $primaryKey = 'departmentid';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = ['departmentid', 'departmentname'];
}
