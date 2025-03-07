<?php declare(strict_types=1);

use App\Models\Travel;
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
        $this->tableName = (new Travel())->getTable();
    }

    /**
     * Run the Migration.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('slug', 64)
                  ->unique();
            $table->string('name', 64);
            $table->text('description');
            $table->text('moods');
            $table->date('starting_date');
            $table->date('ending_date');
            $table->float('price');
            $table->tinyInteger('original_seat_capacity');
            $table->tinyInteger('seat_capacity');
            $table->tinyInteger('reserved_seat_number');
            $table->text('url_images');
            $table->string('departure_location', 64);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
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
