<?php namespace Cb\Company\Updates;

use Cb\Company\Models\Project;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHambernCompanyProjects extends Migration
{
    public function up()
    {
        Schema::table('hambern_company_projects', function ($table) {
            $table->string('slug')->nullable()->index();
        });

        // Fill slug attributes
        Project::all()->each(function ($model) {
            $model->slugAttributes();
            $model->save();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_projects', function ($table) {
            $table->dropColumn('slug');
        });
    }
}