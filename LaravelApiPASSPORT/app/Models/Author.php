<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract; //Alias AuthenticateContract
use App\Models\Book;

class Author extends Model implements AuthenticateContract
{
    use HasFactory, HasApiTokens, Authenticatable;


    //protected $table = "authors";

    protected $fillable = ["name", "email", "password", "phone"];

    public $timestamps = false;

    public function books(){
        return $this->hasMany(Book::class);
    }
}
