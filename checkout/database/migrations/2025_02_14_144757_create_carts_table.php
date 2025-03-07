<?php declare(strict_types=1);

use App\Models\Cart;
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
        $this->tableName = (new Cart())->getTable();
    }

    /**
     * Run the migration.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('travel_id');
            $table->string('email');
            $table->tinyInteger('reserved_seat');
            $table->timestamp('expiration_time');
            $table->tinyInteger('status')->default(Cart::ACTIVE);
            $table->integer('total_amount');
            $table->timestamps();

            $table->foreign('travel_id')->references('id')->on('travels')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
