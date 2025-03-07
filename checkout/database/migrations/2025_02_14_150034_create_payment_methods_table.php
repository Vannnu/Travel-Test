<?php declare(strict_types=1);

use App\Models\PaymentMethod;
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
        $this->tableName = (new PaymentMethod())->getTable();
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
            $table->string('name', 64)
                  ->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
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
