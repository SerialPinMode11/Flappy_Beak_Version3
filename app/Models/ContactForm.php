<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    protected $table = 'contactforms'; // Add this line to specify the table name
    protected $fillable =[
        'firstname',
        'lastname',
        'email',
        'message',
    ];
}
