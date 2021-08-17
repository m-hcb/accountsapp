<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'iban', 'bank_name', 'serial_start', 'serial_end', 'cheque_image', 'signature_image'];
}
