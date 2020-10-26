<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateProductsTable
 */
class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')){
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('product_id')->unique();
                $table->string('organization_id')->nullable(false);
                $table->string('name')->nullable(false);
                $table->string('description');
                $table->string('account_id');
                $table->string('inventoryAccountId')->nullable();
                $table->string('productNo');
                $table->string('suppliersProductNo');
                $table->string('salesTaxRulesetId');
                $table->boolean('isArchived');
                $table->boolean('isInInventory');
                $table->string('imageId')->nullable();
                $table->string('imageUrl')->nullable();

                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('products')){
            Schema::dropIfExists('products');
        }
    }
}
