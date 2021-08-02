<?php namespace Cb\Company\Updates;

use Cb\Company\Models\Link;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHambernCompanyLinks extends Migration
{
    public function up()
    {
        Schema::table('hambern_company_links', function ($table) {
            $table->string('slug')->nullable()->index();
        });

        // Fill slug attributes
        Link::all()->each(function ($model) {
            $model->slugAttributes();
            $model->save();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_links', function ($table) {
            $table->dropColumn('slug');
        });
    }
}