<?php namespace Cb\Car2db\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class AlterTablesUpdateData extends Migration
{
    public function up()
    {
        $tbls = [
                "cb_car2db_generations",
                "cb_car2db_makes",
                "cb_car2db_models",
                "cb_car2db_series",
                "cb_car2db_trims"
            ];

        foreach($tbls as $t) {

            Schema::table($t, function ($table) {
                $table->dropColumn(['created_at', 'updated_at']);
            });

            Schema::table($t, function ($table) {
                $table->renameColumn('date_create', 'created_at');
                $table->renameColumn('date_update', 'updated_at');
            });
        }
    }

    public function down()
    {
        $tbls = [
            "cb_car2db_generations",
            "cb_car2db_makes",
            "cb_car2db_models",
            "cb_car2db_series",
            "cb_car2db_trims"
        ];

        foreach($tbls as $t) {

            Schema::table($t, function ($table) {
                $table->renameColumn('created_at', 'date_create');
                $table->renameColumn('updated_at', 'date_update');
            });

            Schema::table($t, function ($table) {
                $table->timestamps();
            });
        }
    }
}
