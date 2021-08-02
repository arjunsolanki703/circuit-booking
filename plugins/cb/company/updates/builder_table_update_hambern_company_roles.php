<?php namespace Cb\Company\Updates;

use Cb\Company\Models\Role;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHambernCompanyRoles extends Migration
{
    public function up()
    {
        Schema::table('hambern_company_roles', function ($table) {
            $table->string('slug')->nullable()->index();
        });

        // Fill slug attributes
        Role::all()->each(function ($model) {
            $model->slugAttributes();
            $model->save();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_roles', function ($table) {
            $table->dropColumn('slug');
        });
    }
}