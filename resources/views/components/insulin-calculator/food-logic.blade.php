<script>
    window.glucosaFoodConfig = @json(config('carbs'));
</script>

<div x-data="{ 
    showCarbsTable: false,
    modalTotalCarbs: 0,
    modalItemCount: 0,
    selectedItems: [],
    foodCategories: window.glucosaFoodConfig || [],
    
    addCarbsToModal(item) {
        this.modalTotalCarbs += item.carbs;
        this.modalItemCount++;
        this.selectedItems.push({
            id: Date.now() + Math.random(),
            name: item.name,
            carbs: item.carbs
        });
    },

    removeItem(id) {
        const index = this.selectedItems.findIndex(i => i.id === id);
        if (index > -1) {
            this.modalTotalCarbs -= this.selectedItems[index].carbs;
            this.modalItemCount--;
            this.selectedItems.splice(index, 1);
        }
    },
    
    applyCarbs() {
        // Пытаемся передать значение родителю (в insulin-calculator)
        // Alpine ищет переменные вверх по скоупу
        this.carbs = this.modalTotalCarbs;
        this.showCarbsTable = false;
    },
    
    openCarbsTable() {
        this.modalTotalCarbs = 0;
        this.modalItemCount = 0;
        this.selectedItems = [];
        this.showCarbsTable = true;
    }
}">
    {{ $slot }}
</div>