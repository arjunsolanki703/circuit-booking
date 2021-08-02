<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareCompanies extends Migration
{
    public function up()
    {
        /*
        Schema::create('cb_pgmware_companies', function($table)
        {
            
            $table->engine = 'InnoDB';
            $table->increments('company_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            // FK
            //$table->integer('co_country_id')->unsigned()->nullable()->default(null); // See countries-version
            //$table->foreign('co_country_id')->references('country_id')->on('cb_pgmware_countries');
            $table->integer('v_address_id')->unsigned()->nullable()->default(null);   
            //$table->foreign('v_address_id')->references('id')->on('cb_pgmware_address');
            
            
            ///$table->integer('co_manager_member_id')->unsigned()->nullable()->default(null);  // See Member-Version
            //$table->foreign('co_manager_member_id')->references('id')->on('user');
            
            
            // properties
            $table->string('co_name');
            //$table->string('co_street');
            //$table->string('co_zip', 20);
            //$table->string('co_city');
            //$table->string('co_phone', 20)->nullable()->default(null);
            //$table->string('co_fax', 20)->nullable()->default(null);
            //$table->string('co_email')->nullable()->default(null);
            //$table->string('co_web')->nullable()->default(null);
                    
            
            $table->string('co_vat')->nullable()->default(null);
            $table->string('co_vat_id')->nullable()->default(null);
            $table->string('co_bank');
            $table->string('co_bank_address')->nullable()->default(null);
            $table->string('co_aba_number')->nullable()->default(null);
            $table->string('co_account');
            $table->string('co_bank_code')->nullable()->default(null);
            $table->string('co_iban')->nullable()->default(null);
            $table->string('co_swift')->nullable()->default(null);
            
            // booleans/switches
            $table->boolean('co_active')->default('0');
            $table->boolean('co_kmu')->default('0');
            
            // saved for later use in additional plugins
            // $table->char('co_invoice_lang_id', 2);
            // $table->integer('co_price_list')->nullable()->default(null);
        });
        
         if (Schema::hasTable('cb_pgmware_locations')) {
            Schema::table('cb_pgmware_locations', function($table)
            {
                if (!Schema::hasColumn('cb_pgmware_locations', 'l_company_id')) {
                    $table->integer('l_company_id')->unsigned()->nullable()->default(null);
                }
                //$table->foreign('l_company_id')->references('company_id')->on('cb_pgmware_companies');
            });
        }
        */
    }
    
    public function down()
    {
        /*
        if (Schema::hasTable('cb_pgmware_locations')) {
            Schema::table('cb_pgmware_locations', function($table)
            {
                if (Schema::hasColumn('cb_pgmware_locations', 'l_company_id')) {
                    //$table->dropForeign(['l_company_id']);
                    //$table->dropColumn('l_company_id');
                }
            });
        }

        Schema::dropIfExists('cb_pgmware_companies');
        */
    }
}