<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = "employees";
    //Mass assignment 2 columns
    protected $fillable = ["name","email", "phone", "gender", "age"];

    public $timestamps = false;
}
