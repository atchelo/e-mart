<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('products') ) {
			Schema::create('products', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('category_id')->unsigned()->index('products_category_id_foreign');
				$table->integer('child')->unsigned()->index('products_child_foreign');
				$table->integer('grand_id')->nullable();
				$table->integer('store_id')->unsigned()->nullable();
				$table->integer('vender_id')->unsigned()->nullable();
				$table->integer('brand_id')->unsigned()->nullable()->index('products_brand_id_foreign');
				$table->string('name', 191)->nullable();
				$table->text('des', 65535)->nullable();
				$table->text('tags', 65535)->nullable();
				$table->string('model', 191)->nullable();
				$table->string('sku', 191)->nullable();
				$table->string('price_in', 100)->nullable();
				$table->float('price', 10, 0)->nullable();
				$table->string('offer_price', 191)->nullable();
				$table->enum('featured', array('0','1'));
				$table->enum('status', array('0','1'));
				$table->integer('tax')->default(0);
				$table->integer('codcheck')->unsigned()->nullable();
				$table->integer('free_shipping')->nullable();
				$table->string('return_avbl', 100);
				$table->boolean('cancel_avl')->nullable();
				$table->dateTime('selling_start_at')->nullable();
				$table->text('key_features', 65535)->nullable();
				$table->string('w_d', 191)->nullable();
				$table->string('w_my', 100)->nullable();
				$table->string('w_type', 100)->nullable();
				$table->float('vender_price', 10, 0);
				$table->float('vender_offer_price', 10, 0)->nullable();
				$table->string('commission_rate', 191);
				$table->integer('shipping_id')->unsigned()->nullable();
				$table->integer('return_policy')->nullable();
				$table->timestamps();
				$table->string('tax_r', 191)->nullable();
				$table->string('tax_name', 191)->nullable();
				$table->softDeletes();
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
		Schema::drop('products');
	}

}
