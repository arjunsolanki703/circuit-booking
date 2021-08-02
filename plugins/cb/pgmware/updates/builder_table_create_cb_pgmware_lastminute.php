<?php namespace Cb\Pgmware\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCbPgmwareLastminute extends Migration
{
    public function up()
    {
        Schema::create('cb_pgmware_lastminute', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('variant_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('valid_before_date');
            $table->text('description');
            $table->double('price', 10, 2);
            $table->boolean('is_with_vat')->default(0);
            $table->integer('user_id');
            $table->integer('currency_id');
            $table->boolean('id_available')->default(0);
            $table->boolean('is_separately')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cb_pgmware_lastminute');
    }
}
