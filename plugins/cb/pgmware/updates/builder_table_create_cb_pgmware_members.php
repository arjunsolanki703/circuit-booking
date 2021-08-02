<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareMembers extends Migration
{
    public function up()
    {

        /*
        Schema::create('cb_pgmware_members', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('member_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // Fk
            $table->integer('mem_user_id')->unsigned()->nullable()->default(null);
            $table->foreign('mem_user_id')->references('id')->on('users');
            
            $table->integer('mem_company')->unsigned()->nullable()->default(null);
            $table->foreign('mem_company')->references('company_id')->on('cb_pgmware_companies');
            
            $table->integer('mem_country')->unsigned()->nullable()->default(null);
            $table->foreign('mem_country')->references('country_id')->on('cb_pgmware_countries');
            
            
            
            // Additional Properties, compared to October Users
            $table->string('mem_department')->nullable()->default(null);
            $table->string('mem_street');
            $table->string('mem_zip', 20);
            $table->string('mem_city');
            $table->string('mem_phone', 30);
            $table->string('mem_fax', 30)->nullable()->default(null);
            $table->string('mem_mobile', 30)->nullable()->default(null);
            $table->string('mem_function')->nullable()->default(null);;
            $table->string('mem_notes')->nullable()->default(null);
            $table->string('mem_gender');
            
            // How do we manage user languages
            $table->integer('mem_lang');
            
            
            // booleans/switches
            
            // maybe used in later plugins
            //$table->tinyInteger('mem_checkedin')->default('0');
            // $table->tinyInteger('mem_driver')->default('0');
            // $table->date('mem_safety_instructions')->nullable()->default(null);
            // $table->string('mem_license_number')->nullable()->default(null);
            // $table->tinyInteger('mem_license_valid')->default('0');
            // $table->string('mem_color', 7)->nullable()->default(null);
            // $table->tinyInteger('mem_projektuser')->nullable()->default(null);
            // $table->tinyInteger('mem_status')->default('0');
  
        });
        
        
            if (Schema::hasTable('cb_pgmware_companies')) {
                Schema::table('cb_pgmware_companies', function($table)
                {
                    if (!Schema::hasColumn('cb_pgmware_companies', 'co_member_id')) {
                        $table->integer('co_manager_member_id')->unsigned()->nullable()->default(null);
                        $table->foreign('co_manager_member_id')->references('member_id')->on('cb_pgmware_members');
                    }
                    
                });
            }
        */
    }
    
    public function down()
    {
        /*
         if (Schema::hasTable('cb_pgmware_members')) {
            Schema::table('cb_pgmware_members', function($table)
            {    
                if (Schema::hasColumn('cb_pgmware_members', 'mem_company')) {        
                   $table->dropForeign(['mem_company']);
                }
                if (Schema::hasColumn('cb_pgmware_members', 'mem_country')) {
                   $table->dropForeign(['mem_country']);
                }
                if (Schema::hasColumn('cb_pgmware_members', 'mem_user_id')) {
                   $table->dropForeign(['mem_user_id']);
                }
                
                //$table->dropColumn('vv_master_variant_id');
                //$table->dropColumn('vv_detail_variant_id');
            });
        }
        
        if (Schema::hasTable('cb_pgmware_companies')) {
            Schema::table('cb_pgmware_companies', function($table)
            {
                if (Schema::hasColumn('cb_pgmware_companies', 'co_manager_member_id')) {               
                   $table->dropForeign(['co_manager_member_id']);
                   $table->dropColumn('co_manager_member_id');
                }
            });
        }
        
        
        Schema::dropIfExists('cb_pgmware_members');
        */
    }
}