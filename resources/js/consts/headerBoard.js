import { AlignStartHorizontal, List, Table, Clock } from "lucide-vue-next";

export const VIEW_OPTIONS = [
    {
        name: "Overview",
        icon: null,
        query: "overview",
    },
    {
        name: "Board",
        icon: AlignStartHorizontal,
        query: "board",
    },
    {
        name: "List",
        icon: List,
        query: "list",
    },
    {
        name: "Table",
        icon: Table,
        query: "table",
    },
    {
        name: "Timeline",
        icon: Clock,
        query: "timeline",
    },
];
