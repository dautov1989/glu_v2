<div class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/10 dark:to-blue-900/10 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-4 md:p-6 shadow-lg"
    x-data="{
         carbs: '',
         glucose: '',
         activeInsulin: 0.0,
         result: null,
         warning: '',
         
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
    <x-insulin-calculator.styles />

</div>