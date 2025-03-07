<?php declare(strict_types=1);

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Instance variable.
     */
    private string $tableName;

    /**
     * Constructor function.
     */
    public function __construct()
    {
        $this->tableName = (new Order())->getTable();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('cart_id');
            $table->uuid('payment_method_id');
            $table->string('transaction_id');
            $table->integer('status')->default(0);
            $table->integer('total_amount');
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
