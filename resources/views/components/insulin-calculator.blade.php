<div class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/10 dark:to-blue-900/10 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-4 md:p-6 shadow-lg"
    x-data="{
         carbs: '',
         glucose: '',
         result: null,
         warning: '',
         history: [],
         isLoading: false,
         showHistoryModal: false,
         
         init() {
             this.loadHistory();
         },
         
         loadHistory() {
             const stored = localStorage.getItem('insulin_calculator_history');
             if (stored) {
                 try {
                     this.history = JSON.parse(stored);
                 } catch (e) {
                     this.history = [];
                 }
             }
         },
         
         saveHistory() {
             localStorage.setItem('insulin_calculator_history', JSON.stringify(this.history));
         },
         
         addToHistory(data) {
             const entry = {
                 id: Date.now(),
                 timestamp: new Date().toISOString(),
                 ...data
             };
             this.history.unshift(entry);
             if (this.history.length > 100) {
                 this.history = this.history.slice(0, 100);
             }
             this.saveHistory();
         },
         
         deleteEntry(id) {
             this.history = this.history.filter(entry => entry.id !== id);
             this.saveHistory();
         },
         
         clearHistory() {
             if (confirm('Вы уверены, что хотите удалить всю историю? Это действие нельзя отменить.')) {
                 this.history = [];
                 this.saveHistory();
             }
         },
         
         getRecentEntries(days = 7) {
             const now = new Date();
             const cutoff = new Date(now - days * 24 * 60 * 60 * 1000);
             return this.history.filter(entry => {
                 return new Date(entry.timestamp) >= cutoff;
             }).reverse();
         },
         
         exportToCSV() {
             if (this.history.length === 0) {
                 alert('История пуста. Нечего экспортировать.');
                 return;
             }
             const headers = ['Дата и время', 'Углеводы (г)', 'Глюкоза (ммоль/л)', 'Доза на еду (ед)', 'Доза на коррекцию (ед)', 'Итоговая доза (ед)'];
             const rows = this.history.map(entry => {
                 const date = new Date(entry.timestamp);
                 const formattedDate = date.toLocaleString('ru-RU', {
                     day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
                 });
                 return [formattedDate, entry.carbs.toFixed(1), entry.glucose.toFixed(1), entry.foodDose.toFixed(1), entry.correctionDose.toFixed(1), entry.total.toFixed(1)];
             });
             const csvContent = [headers.join(','), ...rows.map(row => row.join(','))].join('\n');
             const BOM = '\uFEFF';
             const blob = new Blob([BOM + csvContent], { type: 'text/csv;charset=utf-8;' });
             const link = document.createElement('a');
             const url = URL.createObjectURL(blob);
             const now = new Date();
             const filename = `insulin_calculator_${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}.csv`;
             link.setAttribute('href', url);
             link.setAttribute('download', filename);
             link.style.visibility = 'hidden';
             document.body.appendChild(link);
             link.click();
             document.body.removeChild(link);
         },
         
         calculate() {
             this.result = null;
             this.warning = '';
             const carbsValue = parseFloat(this.carbs);
             const glucoseValue = parseFloat(this.glucose);
             
             if (isNaN(carbsValue) || carbsValue < 0) {
                 this.warning = '⚠️ Пожалуйста, введите корректное значение углеводов';
                 this.$nextTick(() => {
                    document.getElementById('calculator-warning')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                 });
                 return;
             }
             
             if (isNaN(glucoseValue) || glucoseValue < 0) {
                 this.warning = '⚠️ Пожалуйста, введите корректное значение сахара крови';
                 this.$nextTick(() => {
                    document.getElementById('calculator-warning')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                 });
                 return;
             }
             
             if (glucoseValue < 4.0) {
                 this.warning = '🚨 ВНИМАНИЕ: Низкий уровень сахара (гипогликемия)! Примите быстрые углеводы и не вводите инсулин. Обратитесь к врачу.';
                 this.$nextTick(() => {
                    document.getElementById('calculator-warning')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                 });
                 return;
             }
             
             this.isLoading = true;
             setTimeout(() => {
                 const foodDose = carbsValue / 10.0;
                 let correctionDose = 0.0;
                 if (glucoseValue > 7.0) {
                     correctionDose = (glucoseValue - 7.0) * 0.5;
                 }
                 const totalDoseRaw = foodDose + correctionDose;
                 const totalDose = Math.max(0, totalDoseRaw).toFixed(1);
                 this.result = {
                     total: totalDose,
                     foodDose: foodDose.toFixed(1),
                     correctionDose: correctionDose.toFixed(1),
                     wasRounded: totalDose !== totalDoseRaw
                 };
                 this.addToHistory({
                     carbs: carbsValue,
                     glucose: glucoseValue,
                     total: parseFloat(totalDose),
                     foodDose: parseFloat(foodDose.toFixed(1)),
                     correctionDose: parseFloat(correctionDose.toFixed(1))
                 });
                 this.carbs = '';
                 this.glucose = '';
                 this.isLoading = false;
                 this.$nextTick(() => {
                     const element = document.getElementById('result-section');
                     if (element) {
                         const yOffset = -100;
                         const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;
                         window.scrollTo({ top: y, behavior: 'smooth' });
                     }
                 });
             }, 800);
         }
    }">

    <x-insulin-calculator.schema />
    <x-insulin-calculator.header />

    <x-insulin-calculator.food-logic>
        <x-insulin-calculator.inputs />
        <x-insulin-calculator.food-modal />
    </x-insulin-calculator.food-logic>

    <x-insulin-calculator.results />
    <x-insulin-calculator.chart />
    <x-insulin-calculator.history-modal />
    <x-insulin-calculator.styles />

</div>
