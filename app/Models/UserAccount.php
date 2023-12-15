<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;
}
$table->string('name');
$table->string('surname');
$table->string('email')->unique();
$table->string('password');
$table->string('PIN');
