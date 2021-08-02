<?php namespace Cb\Company\Updates;

use Cb\Company\Models\Employee;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHambernCompanyEmployees extends Migration
{
    public function up()
    {
        Schema::table('hambern_company_employees', function ($table) {
            $table->string('slug')->nullable()->index();
        });

        // Fill slug attributes
        Employee::all()->each(function ($model) {
            $model->slugAttributes();
            $model->save();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_employees', function ($table) {
            $table->dropColumn('slug');
        });
    }
}