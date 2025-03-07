<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Travel;

/**
 * Class TravelSeeder.
 */
class TravelSeeder
{
    /**
     * Travels name list.
     */
    private array $travels = [
        [
            'slug' => 'avventura-islanda',
            'name' => 'Avventura tra i Ghiacciai e le Cascate d’Islanda',
            'starting_date' => '2025-06-15',
            'ending_date' => '2025-06-22',
            'price' => 1999,
            'original_seat_capacity' => 5,
            'seat_capacity' => 5,
            'reserved_seat_number' => 0,
            'departure_location' => 'Reykjavík, Islanda',
            'url_images' => [
                'travelImages/avventura-islanda/islanda1.jpg',
                'travelImages/avventura-islanda/islanda2.jpg',
                'travelImages/avventura-islanda/islanda3.jpg',
            ],
            'moods' => [
                'nature' => 80,
                'relax' => 20,
                'history' => 90,
                'culture' => 30,
                'party' => 10,
            ],
            'description' => [
                'text' => "Scopri l'Islanda in un viaggio unico tra ghiacciai, cascate e paesaggi mozzafiato.",
                'highlights' => [
                    'Trekking sui ghiacciai',
                    'Bagno nelle sorgenti termali',
                    'Visita alle cascate Gullfoss e Seljalandsfoss',
                    "Tour del Circolo d'Oro",
                ],
                'difficulty_level' => 'Medio',
                'included_services' => [
                    'Volo andata e ritorno',
                    'Hotel 3-4 stelle',
                    'Colazione inclusa',
                    'Guida esperta',
                ],
                'excluded_services' => [
                    'Pranzi e cene',
                    'Assicurazione viaggio',
                    'Escursioni facoltative',
                ],
                'guide' => 'Luca Bianchi',
                'itinerary' => [
                    'Giorno 1' => 'Arrivo a Reykjavík e visita della città',
                    'Giorno 2' => 'Tour del Circolo d’Oro',
                    'Giorno 3' => 'Escursione sui ghiacciai',
                    'Giorno 4' => 'Relax nelle sorgenti termali',
                    'Giorno 5' => 'Esplorazione della costa sud',
                    'Giorno 6' => 'Trekking nel Parco Nazionale di Vatnajökull',
                    'Giorno 7' => 'Ultimo giorno libero a Reykjavík',
                ],
            ],
        ],
        [
            'slug' => 'safari-safari-tanzania',
            'name' => 'Safari Selvaggio in Tanzania',
            'starting_date' => '2025-07-10',
            'ending_date' => '2025-07-20',
            'price' => 2999,
            'original_seat_capacity' => 5,
            'seat_capacity' => 5,
            'reserved_seat_number' => 0,
            'departure_location' => 'Arusha, Tanzania',
            'url_images' => [
                'travelImages/safari-tanzania/tanzania1.jpg',
                'travelImages/safari-tanzania/tanzania2.jpg',
                'travelImages/safari-tanzania/tanzania3.jpg',
            ],
            'moods' => [
                'nature' => 10,
                'relax' => 50,
                'history' => 60,
                'culture' => 20,
                'party' => 90,
            ],
            'description' => [
                'text' => "Vivi un'avventura indimenticabile nei parchi della Tanzania, tra leoni, elefanti e paesaggi mozzafiato.",
                'highlights' => [
                    'Safari nel Serengeti',
                    'Visita al cratere Ngorongoro',
                    'Incontro con tribù locali',
                    'Relax sulle spiagge di Zanzibar',
                ],
                'difficulty_level' => 'Facile',
                'included_services' => [
                    'Safari in jeep con guida esperta',
                    'Pernottamento in lodge e campi tendati',
                    'Pasti inclusi durante il safari',
                    'Trasferimenti interni',
                ],
                'excluded_services' => [
                    'Volo internazionale',
                    'Assicurazione viaggio',
                    'Attività extra',
                ],
                'guide' => 'Marco Rossi',
                'itinerary' => [
                    'Giorno 1' => 'Arrivo ad Arusha e briefing di viaggio',
                    'Giorno 2-4' => 'Safari nel Parco Serengeti',
                    'Giorno 5' => 'Visita al cratere Ngorongoro',
                    'Giorno 6-7' => 'Escursione culturale con tribù Masai',
                    'Giorno 8-10' => 'Relax e snorkeling a Zanzibar',
                    'Giorno 11' => 'Partenza e rientro',
                ],
            ],
        ],
        [
            'slug' => 'giappone-cultura',
            'name' => 'Alla Scoperta del Giappone: Tradizione e Futuro',
            'starting_date' => '2025-09-05',
            'ending_date' => '2025-09-15',
            'price' => 2599,
            'original_seat_capacity' => 5,
            'seat_capacity' => 5,
            'reserved_seat_number' => 0,
            'departure_location' => 'Tokyo, Giappone',
            'url_images' => [
                'travelImages/giappone-cultura/giappone1.jpg',
                'travelImages/giappone-cultura/giappone2.jpg',
                'travelImages/giappone-cultura/giappone3.jpg',
            ],
            'moods' => [
                'nature' => 5,
                'relax' => 25,
                'history' => 10,
                'culture' => 10,
                'party' => 100,
            ],
            'description' => [
                'text' => 'Un viaggio tra l’antico e il moderno, dai templi di Kyoto ai grattacieli di Tokyo, esplorando la cultura giapponese.',
                'highlights' => [
                    'Visita a Kyoto e ai suoi templi',
                    'Esperienza in un ryokan tradizionale',
                    'Scoperta della tecnologia di Tokyo',
                    'Cena con sushi e sake',
                ],
                'difficulty_level' => 'Medio',
                'included_services' => [
                    'Alloggio in hotel e ryokan',
                    'Trasporti interni con Japan Rail Pass',
                    'Colazione e alcune cene incluse',
                    'Guida parlante italiano',
                ],
                'excluded_services' => [
                    'Volo internazionale',
                    'Pranzi e cene extra',
                    'Attività facoltative',
                ],
                'guide' => 'Yuki Tanaka',
                'itinerary' => [
                    'Giorno 1' => 'Arrivo a Tokyo e visita di Shibuya',
                    'Giorno 2' => 'Esplorazione di Asakusa e Akihabara',
                    'Giorno 3' => 'Visita a Kamakura e il Grande Buddha',
                    'Giorno 4-5' => 'Kyoto: Fushimi Inari, Kinkaku-ji e Gion',
                    'Giorno 6' => 'Nara e il parco dei cervi',
                    'Giorno 7' => "Hiroshima e l'isola di Miyajima",
                    'Giorno 8' => 'Monte Fuji e Hakone',
                    'Giorno 9' => 'Shopping e tempo libero a Tokyo',
                    'Giorno 10' => 'Partenza per il rientro',
                ],
            ],
        ],
    ];

    /**
     * Migrate Tags inside the DB.
     *
     * @return void
     */
    public function seed(): void
    {
        foreach ($this->travels as $travel) {
            Travel::create([
                'slug' => $travel['slug'],
                'name' => $travel['name'],
                'moods' => json_encode($travel['moods']),
                'description' => json_encode($travel['description']),
                'starting_date' => $travel['starting_date'],
                'ending_date' => $travel['ending_date'],
                'price' => $travel['price'],
                'original_seat_capacity' => $travel['original_seat_capacity'],
                'seat_capacity' => $travel['seat_capacity'],
                'reserved_seat_number' => $travel['reserved_seat_number'],
                'url_images' => json_encode($this->prepareImagesLinks($travel['url_images'])),
                'departure_location' => $travel['departure_location'],
            ]);
        }
    }

    /**
     * Prepare the image links into the DB.
     *
     * @param array $url_images
     *
     * @return array
     */
    private function prepareImagesLinks(array $url_images): array
    {
        $assets = [];

        foreach ($url_images as $image) {
            $assets[] = asset($image);
        }

        return $assets;
    }
}
