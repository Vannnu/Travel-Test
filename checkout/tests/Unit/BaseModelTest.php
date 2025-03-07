<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\Constant\TravelModelCostant;
use Tests\TestCase;

/**
 * Class BaseModelTest.
 */
class BaseModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * This test ensures that when a model is created,
     * it automatically generates a valid UUID as the primary key.
     *
     * @return void
     */
    #[Test]
    public function generateUuid(): void
    {
        $model = new Travel();
        $model->fill(TravelModelCostant::TRAVEL_DATA)
              ->save();

        $this->assertNotNull($model->id);
        $this->assertTrue(Str::isUuid($model->id));
    }
}
