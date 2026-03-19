import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

export function useDrag(initialColumns) {
    const columns = ref([...initialColumns]);
    const pendingRequests = ref(0);
    const dragPayload = ref(null);
    const placeholder = ref({
        type: null,
        colId: null,
        index: null,
        height: 0,
        width: 0,
    });

    watch(
        () => initialColumns,
        (newCols) => {
            if (pendingRequests.value === 0 && !dragPayload.value) {
                columns.value = [...newCols];
            }
        },
        { deep: true },
    );

    const onDragStart = (e, item, type, fromColId = null) => {
        e.dataTransfer.effectAllowed = "move";
        const rect = e.target.getBoundingClientRect();
        dragPayload.value = {
            type,
            data: item,
            fromColId,
            height: rect.height,
            width: rect.width,
        };
    };

    const onCardDragOver = (e, targetIndex, colId) => {
        if (!dragPayload.value || dragPayload.value.type !== "card") return;

        const rect = e.currentTarget.getBoundingClientRect();
        const midPoint = rect.top + rect.height / 2;
        const insertIndex =
            e.clientY < midPoint ? targetIndex : targetIndex + 1;

        if (dragPayload.value.fromColId === colId) {
            const col = columns.value.find((c) => c.id === colId);
            const originalIndex = col.cards.findIndex(
                (t) => t.id === dragPayload.value.data.id,
            );

            if (
                insertIndex === originalIndex ||
                insertIndex === originalIndex + 1
            ) {
                placeholder.value = {
                    type: null,
                    colId: null,
                    index: null,
                    height: 0,
                    width: 0,
                };
                return;
            }
        }

        placeholder.value = {
            type: "card",
            colId,
            index: insertIndex,
            height: dragPayload.value.height,
        };
    };

    const onColumnDragOver = (e, targetColId) => {
        if (!dragPayload.value) return;

        if (dragPayload.value.type === "card") {
            if (placeholder.value.colId !== targetColId) {
                const col = columns.value.find((c) => c.id === targetColId);

                if (dragPayload.value.fromColId === targetColId) {
                    const originalIndex = col.cards.findIndex(
                        (t) => t.id === dragPayload.value.data.id,
                    );
                    if (originalIndex === col.cards.length - 1) {
                        placeholder.value = {
                            type: null,
                            colId: null,
                            index: null,
                            height: 0,
                            width: 0,
                        };
                        return;
                    }
                }

                placeholder.value = {
                    type: "card",
                    colId: targetColId,
                    index: col.cards.length,
                    height: dragPayload.value.height,
                };
            }
        } else if (dragPayload.value.type === "column") {
            const targetIndex = columns.value.findIndex(
                (c) => c.id === targetColId,
            );
            const rect = e.currentTarget.getBoundingClientRect();
            const midPoint = rect.left + rect.width / 2;
            const insertIndex =
                e.clientX < midPoint ? targetIndex : targetIndex + 1;

            const originalIndex = columns.value.findIndex(
                (c) => c.id === dragPayload.value.data.id,
            );
            if (
                insertIndex === originalIndex ||
                insertIndex === originalIndex + 1
            ) {
                placeholder.value = {
                    type: null,
                    colId: null,
                    index: null,
                    height: 0,
                    width: 0,
                };
                return;
            }

            placeholder.value = {
                type: "column",
                colId: null,
                index: insertIndex,
                width: dragPayload.value.width,
            };
        }
    };

    const onDrop = () => {
        if (!dragPayload.value || placeholder.value.index === null) {
            resetDrag();
            return;
        }

        const { type, data, fromColId } = dragPayload.value;
        const { colId: toColId, index: toIndex } = placeholder.value;

        if (type === "card") {
            const fromCol = columns.value.find((c) => c.id === fromColId);
            const toCol = columns.value.find((c) => c.id === toColId);
            const cardIndex = fromCol.cards.findIndex((t) => t.id === data.id);

            if (cardIndex > -1) {
                const [card] = fromCol.cards.splice(cardIndex, 1);
                let finalIndex = toIndex;
                if (fromColId === toColId && cardIndex < toIndex) finalIndex--;
                toCol.cards.splice(finalIndex, 0, card);

                persistCardOrder(toCol.id, toCol.cards);
            }
        } else if (type === "column") {
            const colIndex = columns.value.findIndex((c) => c.id === data.id);
            if (colIndex > -1) {
                const [col] = columns.value.splice(colIndex, 1);
                let finalIndex = toIndex;
                if (colIndex < toIndex) finalIndex--;
                columns.value.splice(finalIndex, 0, col);

                persistColumnOrder(columns.value);
            }
        }

        resetDrag();
    };

    const resetDrag = () => {
        dragPayload.value = null;
        placeholder.value = {
            type: null,
            colId: null,
            index: null,
            height: 0,
            width: 0,
        };
    };

    const persistCardOrder = (columnId, updatedCards) => {
        pendingRequests.value++;

        router.patch(
            route("app.cards.reorder"),
            {
                column_id: columnId,
                positions: updatedCards.map((card, index) => ({
                    id: card.id,
                    position: index,
                })),
            },
            {
                preserveScroll: true,
                onFinish: () => {
                    pendingRequests.value--;
                },
                onErrors: (errors) => {
                    console.error("Error reordering card:", errors);
                },
            },
        );
    };

    const persistColumnOrder = (updatedColumns) => {
        pendingRequests.value++;

        router.patch(
            route("app.columns.reorder"),
            {
                positions: updatedColumns.map((col, index) => ({
                    id: col.id,
                    position: index,
                })),
            },
            {
                preserveScroll: true,
                onFinish: () => {
                    pendingRequests.value--;
                },
            },
        );
    };

    return {
        columns,
        dragPayload,
        placeholder,
        onDragStart,
        onCardDragOver,
        onColumnDragOver,
        onDrop,
        resetDrag,
    };
}
