<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PaymentMethod;

/**
 * Class PaymentMethodSeeder.
 */
class PaymentMethodSeeder
{
    /**
     * Payment method list.
     *
     * @var array|string[]
     */
    private array $paymentsNames = [
        'Paypal' => 'Pagamento sicuro tramite PayPal, senza condividere i dati della carta.',
        'Klarna' => 'Paga in rate senza interessi, scegliendo tra varie opzioni di pagamento.',
        'Carta Di Credito' => 'Pagamento immediato tramite le principali carte di credito (Visa, Mastercard, American Express).',
        'Bonifico Bancario' => 'Opzione di pagamento tramite bonifico bancario, ideale per transazioni più grandi.',
    ];

    /**
     * Migrate Tags inside the DB.
     *
     * @return void
     */
    public function seed(): void
    {
        foreach ($this->paymentsNames as $name => $description) {
            PaymentMethod::create([
                'name' => $name,
                'description' => $description,
            ]);
        }
    }
}
