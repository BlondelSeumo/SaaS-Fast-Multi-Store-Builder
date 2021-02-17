<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Updates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        if (!Schema::hasTable('blog')) {
            Schema::create('blog', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('name')->nullable();
                $table->longText('note')->nullable();
                $table->string('slug')->nullable();
                $table->string('image')->nullable();
                $table->dateTime('start_date')->nullable();
                $table->dateTime('end_date')->nullable();
                $table->longText('extra')->nullable();
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('option_values')) {
            Schema::create('option_values', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('label')->nullable();
                $table->integer('option_id')->nullable();
                $table->float('price')->nullable();
                $table->string('price_type')->default('fixed');
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('options')) {
            Schema::create('options', function (Blueprint $table) {
                $table->id();
                $table->integer('user');
                $table->string('name')->nullable();
                $table->integer('product')->nullable();
                $table->string('type')->nullable();
                $table->integer('is_required')->default(0);
                $table->integer('is_global')->default(0);
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->integer('storeuser');
                $table->string('email')->unique();
                $table->string('name')->nullable();
                $table->integer('role')->default(0);
                $table->string('password');
                $table->longText('details')->nullable();
                $table->timestamps();
            });
        }
        
        Schema::table('domains', function (Blueprint $table) {
            if (!Schema::hasColumn('domains', 'user')) {
                $table->integer('user')->after('id')->nullable();
            }
            if (!Schema::hasColumn('domains', 'wildcard')) {
                $table->integer('wildcard')->after('user')->default(0);
            }
        });
        
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'otheruser')) {
                $table->integer('otheruser')->after('user')->nullable();
            }
        });
        
        Schema::table('product_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('product_orders', 'gateway')) {
                $table->string('gateway')->after('currency')->nullable();
            }
            if (!Schema::hasColumn('product_orders', 'customer')) {
                $table->integer('customer')->after('storeuser')->nullable();
            }
        });
        
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'shipping')) {
                $table->longText('shipping')->after('media')->nullable();
            }
        });
        
        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'gateways')) {
                $table->longText('gateways')->after('domains')->nullable();
            }
        });
        
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'external_url')) {
                $table->longText('external_url_name')->after('media')->nullable();
                $table->longText('external_url')->after('external_url_name')->nullable();
            }
            if (!Schema::hasColumn('products', 'stock_management')) {
                $table->integer('stock_management')->after('external_url_name')->nullable();
            }

            if (!Schema::hasColumn('products', 'stock_status')) {
                $table->integer('stock_status')->after('stock_management')->nullable();
            }

            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->after('stock_status')->nullable();
            }

            if (!Schema::hasColumn('products', 'files')) {
                $table->longText('files')->after('sku')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
