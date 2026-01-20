import { Chart, registerables } from 'chart.js';

// Регистрируем все компоненты Chart.js
Chart.register(...registerables);

// Делаем Chart доступным глобально
window.Chart = Chart;
