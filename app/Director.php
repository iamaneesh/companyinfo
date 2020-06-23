<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'directors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'din', 'name', 'designation', 'date_appointment'
    ];
}
