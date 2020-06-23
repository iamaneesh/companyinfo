<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cin')->comment('Corporate Identification Number')->unique();
            $table->string('name')->comment('Company Name');
            $table->string('status')->comment('Company Status');
            $table->string('date_incorporation')->comment('Age (Date of Incorporation)');
            $table->string('reg_no')->comment('Registration Number');
            $table->string('category')->comment('Company Category');
            $table->string('subcategory')->comment('Company Subcategory');
            $table->string('class_company')->comment('Class of Company');
            $table->string('roc_code')->comment('ROC Code');
            $table->string('no_of_members')->comment('Number of Members');
            $table->string('email')->comment('Email Address');
            $table->text('reg_office')->comment('Registered Office');
            $table->string('whether_listed_not')->comment('Whether listed or not');
            $table->string('date_last_agm')->comment('Date of Last AGM');
            $table->string('date_balance_sheet')->comment('Date of Balance sheet');
            $table->string('state')->comment('State');
            $table->string('district')->comment('District');
            $table->string('city')->comment('City');
            $table->string('pin')->comment('PIN');
            $table->string('section')->comment('Section');
            $table->string('division')->comment('Division');
            $table->string('main_group')->comment('Main Group');
            $table->string('main_class')->comment('Main Class');
            $table->string('url')->comment('Company URL')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
