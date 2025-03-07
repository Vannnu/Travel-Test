<?php declare(strict_types=1);

namespace Tests\Constant;

/**
 * Class TravelModelCostant.
 */
class TravelModelCostant
{
    /**
     * Fake data used for the test purpose.
     *
     * @var array
     */
    public const TRAVEL_DATA = [
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
    ];
}
