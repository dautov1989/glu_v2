<div class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/10 dark:to-blue-900/10 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-4 md:p-6 shadow-lg"
    x-data="{
         carbs: '',
         glucose: '',
         activeInsulin: 0.0,
         result: null,
         warning: '',
         history: [],
         showHistoryModal: false,
         
         init() {
             this.loadHistory();
         },
         
         /**
          * Загрузка истории из localStorage
          */
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
         
         /**
          * Сохранение истории в localStorage
          */
         saveHistory() {
             localStorage.setItem('insulin_calculator_history', JSON.stringify(this.history));
         },
         
         /**
          * Добавление записи в историю
          */
         addToHistory(data) {
             const entry = {
                 id: Date.now(),
                 timestamp: new Date().toISOString(),
                 ...data
             };
             this.history.unshift(entry);
             // Ограничиваем историю 100 записями
             if (this.history.length > 100) {
                 this.history = this.history.slice(0, 100);
             }
             this.saveHistory();
         },
         
         /**
          * Удаление одной записи
          */
         deleteEntry(id) {
             this.history = this.history.filter(entry => entry.id !== id);
             this.saveHistory();
         },
         
         /**
          * Очистка всей истории
          */
         clearHistory() {
             if (confirm('Вы уверены, что хотите удалить всю историю? Это действие нельзя отменить.')) {
                 this.history = [];
                 this.saveHistory();
             }
         },
         
         /**
          * Получить последние N записей для графика
          */
         getRecentEntries(days = 7) {
             const now = new Date();
             const cutoff = new Date(now - days * 24 * 60 * 60 * 1000);
             return this.history.filter(entry => {
                 return new Date(entry.timestamp) >= cutoff;
             }).reverse();
         },
         
         /**
          * Экспорт истории в CSV (Excel)
          */
         exportToCSV() {
             if (this.history.length === 0) {
                 alert('История пуста. Нечего экспортировать.');
                 return;
             }
             
             // Заголовки столбцов
             const headers = [
                 'Дата и время',
                 'Углеводы (г)',
                 'Глюкоза (ммоль/л)',
                 'Активный инсулин (ед)',
                 'Доза на еду (ед)',
                 'Доза на коррекцию (ед)',
                 'Итоговая доза (ед)'
             ];
             
             // Формируем строки данных
             const rows = this.history.map(entry => {
                 const date = new Date(entry.timestamp);
                 const formattedDate = date.toLocaleString('ru-RU', {
                     day: '2-digit',
                     month: '2-digit',
                     year: 'numeric',
                     hour: '2-digit',
                     minute: '2-digit'
                 });
                 
                 return [
                     formattedDate,
                     entry.carbs.toFixed(1),
                     entry.glucose.toFixed(1),
                     entry.activeInsulin.toFixed(1),
                     entry.foodDose.toFixed(1),
                     entry.correctionDose.toFixed(1),
                     entry.total.toFixed(1)
                 ];
             });
             
             // Объединяем заголовки и данные
             const csvContent = [
                 headers.join(','),
                 ...rows.map(row => row.join(','))
             ].join('\n');
             
             // Добавляем BOM для корректного отображения кириллицы в Excel
             const BOM = '\uFEFF';
             const blob = new Blob([BOM + csvContent], { type: 'text/csv;charset=utf-8;' });
             
             // Создаём ссылку для скачивания
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
         
         /**
          * Расчёт дозы инсулина
          * Логика:
          * - 1 ед. инсулина = 10 г углеводов
          * - Коррекция при glucose > 7.0: (glucose - 7.0) * 0.5
          * - Итоговая доза = foodDose + correctionDose - activeInsulin
          * - Округление до 1 знака после запятой
          */
         calculate() {
             // Сброс предыдущих результатов
             this.result = null;
             this.warning = '';
             
             // Преобразование в float
             const carbsValue = parseFloat(this.carbs);
             const glucoseValue = parseFloat(this.glucose);
             const activeInsulinValue = parseFloat(this.activeInsulin) || 0.0;
             
             // Валидация входных данных
             if (isNaN(carbsValue) || carbsValue < 0) {
                 this.warning = '⚠️ Пожалуйста, введите корректное значение углеводов';
                 return;
             }
             
             if (isNaN(glucoseValue) || glucoseValue < 0) {
                 this.warning = '⚠️ Пожалуйста, введите корректное значение сахара крови';
                 return;
             }
             
             // Проверка на гипогликемию
             if (glucoseValue < 4.0) {
                 this.warning = '🚨 ВНИМАНИЕ: Низкий уровень сахара (гипогликемия)! Примите быстрые углеводы и не вводите инсулин. Обратитесь к врачу.';
                 return;
             }
             
             // Расчёт дозы на еду
             const foodDose = carbsValue / 10.0;
             
             // Расчёт коррекции (только если glucose > 7.0)
             let correctionDose = 0.0;
             if (glucoseValue > 7.0) {
                 correctionDose = (glucoseValue - 7.0) * 0.5;
             }
             
             // Итоговая доза с учётом активного инсулина
             const totalDoseRaw = foodDose + correctionDose - activeInsulinValue;
             
             // Округление до 1 знака после запятой
             const totalDose = Math.max(0, totalDoseRaw).toFixed(1);
             
             // Формирование результата
             this.result = {
                 total: totalDose,
                 foodDose: foodDose.toFixed(1),
                 correctionDose: correctionDose.toFixed(1),
                 activeInsulin: activeInsulinValue.toFixed(1),
                 wasRounded: totalDose !== totalDoseRaw
             };
             
             // Сохраняем в историю
             this.addToHistory({
                 carbs: carbsValue,
                 glucose: glucoseValue,
                 activeInsulin: activeInsulinValue,
                 total: parseFloat(totalDose),
                 foodDose: parseFloat(foodDose.toFixed(1)),
                 correctionDose: parseFloat(correctionDose.toFixed(1))
             });
             
             // Очищаем инпуты после успешного расчёта
             this.carbs = '';
             this.glucose = '';
             this.activeInsulin = 0.0;
         }
     }">

    <x-insulin-calculator.schema />
    <x-insulin-calculator.header />

    <!-- Input Form Wrapper with Shared State -->
    <x-insulin-calculator.food-logic>
        <x-insulin-calculator.inputs />
        <x-insulin-calculator.food-modal />
    </x-insulin-calculator.food-logic>

    <x-insulin-calculator.results />
    <x-insulin-calculator.chart />
    <x-insulin-calculator.history-modal />
    <x-insulin-calculator.styles />

</div>