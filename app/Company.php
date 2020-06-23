<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cin','name','status','date_incorporation','reg_no','category','subcategory','class_company','roc_code','no_of_members','email','reg_office','whether_listed_not','date_last_agm','date_balance_sheet','state','district','city','pin','section','division','main_group','main_class', 'url'
    ];
}
