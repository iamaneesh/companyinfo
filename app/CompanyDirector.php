<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDirector extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies_directors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'director_id'
    ];
}
