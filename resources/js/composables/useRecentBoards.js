import { ref } from "vue";

const KEY = "recentBoards";

const recentBoards = ref(JSON.parse(localStorage.getItem(KEY)) || []);

export function useRecentBoards() {
    function addRecentBoard(board) {
        const filtered = recentBoards.value.filter((b) => b.id !== board.id);

        filtered.unshift(board);

        recentBoards.value = filtered.slice(0, 5);

        localStorage.setItem(KEY, JSON.stringify(recentBoards.value));
    }

    return {
        recentBoards,
        addRecentBoard,
    };
}
