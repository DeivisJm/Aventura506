<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::rename('settings', 'exchange_rates');
    }

    public function down()
    {
        Schema::rename('exchange_rates', 'settings');
    }
};
