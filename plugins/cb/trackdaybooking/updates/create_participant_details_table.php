<?php namespace Cb\Trackdaybooking\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateParticipantDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('cb_trackdaybooking_participant_details', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->string('licenseplate');
            $table->integer('trim_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cb_trackdaybooking_participant_details');
    }
}
