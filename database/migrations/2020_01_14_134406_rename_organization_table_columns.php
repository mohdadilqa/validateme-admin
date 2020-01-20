<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameOrganizationTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function(Blueprint $table) {
            $table->string('organization_email')->after('domain')->nullable(false);
            $table->renameColumn('name', 'organization_name');
            $table->renameColumn('domain', 'organization_domain');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('organizations', function(Blueprint $table) {
            $table->renameColumn('organization_name', 'name');
            $table->renameColumn('organization_domain', 'domain');
        });

    }
}
