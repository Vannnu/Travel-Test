// composables/useTravelDetails.ts
import { ref, onMounted } from 'vue';

/**
 * A composable to fetch and manage travel details.
 * It retrieves travel information from the API based on the given travel ID.
 *
 * @param {string} id - The unique identifier of the travel.
 * @returns {Object} - An object containing the travel details, loading state, and error message.
 */
export function useTravelDetails(id: string): object {
    const travel = ref<any>(null); // Holds the travel details
    const isLoading = ref(true); // Indicates whether data is being fetched
    const error = ref<string | null>(null); // Stores any error message

    /**
     * Fetches travel details from the API.
     * If the request fails, it stores an error message.
     */
    const fetchTravelDetails = async () => {
        try {
            const response = await fetch(`http://localhost:8080/travels/${id}`);
            if (!response.ok) throw new Error('Errore nel recupero dei dettagli del viaggio');
            travel.value = await response.json();
        } catch (err: any) {
            error.value = err.message;
        } finally {
            isLoading.value = false;
        }
    };

    onMounted(fetchTravelDetails);

    return { travel, isLoading, error };
}
