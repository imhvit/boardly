import { ref } from "vue";

export function useDrag(initialColumns) {
    const columns = ref(initialColumns);
    const dragPayload = ref(null);
    const placeholder = ref({
        type: null,
        colId: null,
        index: null,
        height: 0,
        width: 0,
    });

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

    const onTaskDragOver = (e, targetIndex, colId) => {
        if (!dragPayload.value || dragPayload.value.type !== "task") return;

        const rect = e.currentTarget.getBoundingClientRect();
        const midPoint = rect.top + rect.height / 2;
        const insertIndex =
            e.clientY < midPoint ? targetIndex : targetIndex + 1;

        if (dragPayload.value.fromColId === colId) {
            const col = columns.value.find((c) => c.id === colId);
            const originalIndex = col.tasks.findIndex(
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
            type: "task",
            colId,
            index: insertIndex,
            height: dragPayload.value.height,
        };
    };

    const onColumnDragOver = (e, targetColId) => {
        if (!dragPayload.value) return;

        if (dragPayload.value.type === "task") {
            if (placeholder.value.colId !== targetColId) {
                const col = columns.value.find((c) => c.id === targetColId);

                if (dragPayload.value.fromColId === targetColId) {
                    const originalIndex = col.tasks.findIndex(
                        (t) => t.id === dragPayload.value.data.id,
                    );
                    if (originalIndex === col.tasks.length - 1) {
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
                    type: "task",
                    colId: targetColId,
                    index: col.tasks.length,
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

        if (type === "task") {
            const fromCol = columns.value.find((c) => c.id === fromColId);
            const toCol = columns.value.find((c) => c.id === toColId);
            const taskIndex = fromCol.tasks.findIndex((t) => t.id === data.id);

            if (taskIndex > -1) {
                const [task] = fromCol.tasks.splice(taskIndex, 1);
                let finalIndex = toIndex;
                if (fromColId === toColId && taskIndex < toIndex) finalIndex--;
                toCol.tasks.splice(finalIndex, 0, task);
            }
        } else if (type === "column") {
            const colIndex = columns.value.findIndex((c) => c.id === data.id);
            if (colIndex > -1) {
                const [col] = columns.value.splice(colIndex, 1);
                let finalIndex = toIndex;
                if (colIndex < toIndex) finalIndex--;
                columns.value.splice(finalIndex, 0, col);
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

    return {
        columns,
        dragPayload,
        placeholder,
        onDragStart,
        onTaskDragOver,
        onColumnDragOver,
        onDrop,
        resetDrag,
    };
}
