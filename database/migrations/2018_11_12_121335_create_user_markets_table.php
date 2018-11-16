<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        
        Schema::create('user_markets', function (Blueprint $table) { 
            $table->increments('id');
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("market_id");
            $table->timestamps();

            /*
            $table->foreign("user_id")
            ->references("id")
            ->on("users")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->foreign("market_id")
            ->references("id")
            ->on("markets")
            ->onDelete("cascade")
            ->onUpdate("cascade");
            */
            
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_markets');
    }
}
