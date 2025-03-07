import { ref, onMounted } from 'vue';

/**
 * A composable to fetch and manage the list of travels.
 * It retrieves travel data from the API and processes it to fit the component structure.
 *
 * @returns {Object} - An object containing the list of travels, loading state, and error message.
 */
export function useTravels(): object {
    const travels = ref<any[]>([]); // Holds the list of travels
    const isLoading = ref(true); // Indicates whether data is being fetched
    const error = ref<string | null>(null); // Stores any error message

    /**
     * Fetches the list of travels from the API.
     * If the request is successful, it processes the data to match the expected component structure.
     * If the request fails, it stores an error message.
     */
    const fetchTravels = async () => {
        try {
            const response = await fetch('http://localhost:8080/travels');

            if (!response.ok) throw new Error('Errore nel recupero dei viaggi');

            const data = await response.json();

            travels.value = data.data.map((travel: any) => ({
                id: travel.id,
                title: travel.name,
                description: travel.description.text,
                price: travel.price,
                availableSeats: travel.seat_capacity - travel.reserved_seat_number,
                image: travel.url_images[0],
            }));
        } catch (err: any) {
            error.value = err.message;
        } finally {
            isLoading.value = false;
        }
    };

    onMounted(fetchTravels);

    return { travels, isLoading, error };
}
