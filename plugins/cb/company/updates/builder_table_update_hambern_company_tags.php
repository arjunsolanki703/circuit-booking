<?php namespace Cb\Company\Updates;

use Cb\Company\Models\Tag;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHambernCompanyTags extends Migration
{
    public function up()
    {
        Schema::table('hambern_company_tags', function ($table) {
            $table->string('slug')->nullable()->index();
        });

        // Fill slug attributes
        Tag::all()->each(function ($model) {
            $model->slugAttributes();
            $model->save();
        });
    }

    public function down()
    {
        Schema::table('hambern_company_tags', function ($table) {
            $table->dropColumn('slug');
        });
    }
}