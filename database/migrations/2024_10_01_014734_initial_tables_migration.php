<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('accountcategories', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('label', 150)->nullable();
        //     $table->integer('is_active')->default(1);
        // });

        Schema::create('accountnatures', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('is_active')->default(1);
        });

        Schema::create('classaccounts', function (Blueprint $table) {
            $table->id();
            $table->string('num', 10);
            $table->string('label', 150)->nullable();
            $table->integer('chartaccount_id')->nullable();
            $table->integer('is_active')->default(1);
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('subaccountcategory_id')->nullable();
            $table->integer('is_active')->default(1);
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('classaccount_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->integer('accountnature_id')->nullable();
            $table->integer('is_active')->default(1);

            $table->foreign('classaccount_id')->references('id')->on('classaccounts');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('accountnature_id')->references('id')->on('accountnatures');
        });

        Schema::create('account_types', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('required')->default(0);
        });

        Schema::create('account_account_types', function (Blueprint $table) {
            $table->integer('account_type_id');
            $table->integer('account_id');
            $table->integer('required')->default(0);

            $table->primary(['account_type_id', 'account_id']);
            $table->foreign('account_type_id')->references('id')->on('account_types');
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        Schema::create('axistypes', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('required')->default(0);
        });

        Schema::create('account_axistypes', function (Blueprint $table) {
            $table->integer('axistype_id');
            $table->integer('account_id');
            $table->integer('required')->default(0);

            $table->primary(['axistype_id', 'account_id']);
            $table->foreign('axistype_id')->references('id')->on('axistypes');
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('companygroup_id')->nullable();
            $table->integer('is_active')->default(1);
        });

        Schema::create('account_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->nullable();
            $table->integer('company_id')->nullable()->unique();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('company_id')->references('id')->on('companies');
        });

        Schema::create('account_types_det', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('required')->default(0);
            $table->integer('account_type_id')->nullable();

            $table->foreign('account_type_id')->references('id')->on('account_types');
        });

        Schema::create('analyticalaxis', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('is_active')->default(1);
            $table->string('code', 10)->nullable();
            $table->integer('axistype_id')->nullable();

            $table->foreign('axistype_id')->references('id')->on('axistypes');
        });

        Schema::create('periodtypes', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('is_active')->default(1);
        });

        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->integer('is_active')->default(1);
        });

        Schema::create('balance_sheets_heads', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->nullable()->unique();
            $table->integer('year_id')->nullable()->unique();
            $table->integer('periodtype_id')->nullable()->unique();
            $table->integer('month')->nullable();
            $table->integer('status_id')->nullable();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('periodtype_id')->references('id')->on('periodtypes');
        });

        Schema::create('balance_sheets_details', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->nullable()->unique();
            $table->decimal('account_balance', 10, 2)->nullable();
            $table->integer('balance_sheets_head_id')->nullable()->unique();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('balance_sheets_head_id')->references('id')->on('balance_sheets_heads');
        });

        Schema::create('chartaccounts', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('is_active')->default(1);
        });

        Schema::create('chartaccounts_companies', function (Blueprint $table) {
            $table->integer('chartaccount_id');
            $table->integer('company_id');

            $table->primary(['chartaccount_id', 'company_id']);
            $table->foreign('chartaccount_id')->references('id')->on('chartaccounts');
            $table->foreign('company_id')->references('id')->on('companies');
        });

        Schema::create('companies_axistypes', function (Blueprint $table) {
            $table->integer('company_id');
            $table->integer('axistype_id');
            $table->integer('is_active')->default(1);

            $table->primary(['company_id', 'axistype_id']);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('axistype_id')->references('id')->on('axistypes');
        });

        Schema::create('companygroups', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('is_active')->default(1);
        });

        Schema::create('subaccountcategories', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('accountcategory_id')->nullable();
            $table->integer('is_active')->default(1);

            $table->foreign('accountcategory_id')->references('id')->on('accountcategories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('balance_sheets_details');
        Schema::dropIfExists('balance_sheets_heads');
        Schema::dropIfExists('account_settings');
        Schema::dropIfExists('account_account_types');
        Schema::dropIfExists('account_axistypes');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('account_types_det');
        Schema::dropIfExists('account_types');
        Schema::dropIfExists('analyticalaxis');
        Schema::dropIfExists('axistypes');
        Schema::dropIfExists('chartaccounts_companies');
        Schema::dropIfExists('companies_axistypes');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('companygroups');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('subaccountcategories');
        Schema::dropIfExists('accountcategories');
        Schema::dropIfExists('accountnatures');
        Schema::dropIfExists('classaccounts');
        Schema::dropIfExists('chartaccounts');
        Schema::dropIfExists('periodtypes');
        Schema::dropIfExists('years');
    }
};
