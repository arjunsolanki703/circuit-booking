<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareLocations extends Migration
{
    public function up()
    {
        
        Schema::create('cb_pgmware_locations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // Fk
            $table->integer('country_id'); // will be installed with Countries-Version
            //$table->foreign('country_id')->references('id')->on('rainlab_location_countries');
            $table->integer('company_id')->nullable(); // will be installed with Company-Version
            //$table->foreign('company_id')->references('id')->on('cb_userplus_companies');
            $table->integer('timezone_id')->nullable();   // will be installed with Timezone-Version
            $table->integer('user_id')->unsigned()->nullable()->default(null);   // october_user_id
            //$table->foreign('user_id')->references('id')->on('users');
            
            $table->integer('address_id')->unsigned()->nullable()->default(null);   
            //$table->foreign('l_address_id')->references('address_id')->on('cb_pgmware_location_address');
            
            // properties
            $table->string('name_short', 30)->nullable()->default(null);
            $table->string('name');
            //$table->string('l_street');     // => address
            //$table->string('l_zip', 20);     // => address
            //$table->string('l_city');     // => address
            //$table->string('l_phone');     // => address
            //$table->string('l_fax', 30);     // => address
            //$table->string('l_email');     // => address
            $table->string('youtube_video_url')->nullable()->default(null);
            $table->string('slug')->nullable()->default(null);
            
            $table->string('open_from', 45)->nullable();
            $table->string('open_to', 45)->nullable();
            $table->string('lunch_from', 45)->nullable();
            $table->string('lunch_to', 45)->nullable();
            
            $table->longText('description')->nullable()->default(null);
            $table->longText('equipment')->nullable()->default(null);
            $table->longText('specials')->nullable()->default(null);
            
            $table->integer('gtc')->nullable()->default(null);                     // general terms and conditions
            $table->integer('dataprotection_info')->nullable()->default(null);
                        
            $table->integer('module_file')->nullable()->default(null);
            $table->integer('facility_overview')->nullable()->default(null);
            $table->integer('facility_file')->nullable()->default(null);
            $table->integer('logo')->nullable()->default(null);
            //$table->integer('timezone_id')->nullable()->default(null);
            
            //$table->double('l_gps_lat');  // => address
           // $table->double('l_gps_lon');  // => address
            
            $table->integer('noise')->nullable();
            
            // uploads, as it is not clear, how we can handle uploads, these attrbutes are commended out
            // $table->integer('l_headimage')->nullable()->default(null);
            // $table->integer('l_attachements')->nullable()->default(null);
            // $table->integer('l_arrival_file')->nullable()->default(null);
            // $table->integer('l_presentation_file')->nullable()->default(null);
            
            // booleans/switches
            $table->boolean('restaurant')->nullable(); // null=> no info, false=>no restaurant, true=>restaurant available
            $table->boolean('medical')->nullable();    // null=> no info, false=>no medial, true=>medial available
            $table->boolean('fuel')->nullable();       // null=> no info, false=>no fuel, true=>fuel available
            
            
            // saved for later use in additional plugins
            // $table->integer('l_layout')->nullable()->default(null);  // moved to variants
            
            
            
            
        });
    }
    
    public function down()
    {
        /*
        if (Schema::hasTable('cb_pgmware_locations')) {
            Schema::table('cb_pgmware_locations', function($table)
            {
                
                $table->dropForeign(['user_id']);
            });
        }
        */
        
        Schema::dropIfExists('cb_pgmware_locations');

    }
}