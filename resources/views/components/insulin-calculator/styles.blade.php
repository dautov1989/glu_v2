<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #06b6d4;
        /* cyan-500 */
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: content-box;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #0891b2;
        /* cyan-600 */
    }

    /* Horizontal Scrollbar specifically for the selected items list */
    .custom-scrollbar-horizontal::-webkit-scrollbar {
        height: 6px;
    }

    .custom-scrollbar-horizontal::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        margin: 0 10px;
    }

    .custom-scrollbar-horizontal::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.4);
        border-radius: 10px;
    }

    .custom-scrollbar-horizontal::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.6);
    }

    /* For Firefox */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #06b6d4 rgba(0, 0, 0, 0.05);
    }

    .custom-scrollbar-horizontal {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.4) rgba(255, 255, 255, 0.1);
    }
</style>