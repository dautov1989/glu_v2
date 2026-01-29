<!-- Chart Display -->
<div x-show="history.length > 0" x-cloak x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
    class="mt-6 bg-white dark:bg-zinc-800 rounded-xl border border-cyan-200/50 dark:border-cyan-800/30 p-4 shadow-lg">

    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5 text-cyan-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
            </svg>
            <span>История расчётов</span>
        </h3>
        <div class="text-xs font-semibold text-cyan-600 dark:text-cyan-400">
            <span x-text="history.length"></span> зап.
        </div>
    </div>

    <!-- Legend -->
    <div class="flex flex-wrap items-center justify-center gap-3 mb-4 p-2 bg-zinc-50 dark:bg-zinc-900/50 rounded-lg">
        <div class="flex items-center gap-1.5">
            <div class="w-3 h-3 rounded-full bg-orange-500"></div>
            <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Глюкоза</span>
        </div>
        <div class="flex items-center gap-1.5">
            <div class="w-3 h-3 rounded bg-cyan-500"></div>
            <span class="text-xs font-semibold text-zinc-700 dark:text-zinc-300">Углеводы</span>
        </div>
    </div>

    <div class="relative" style="height: 220px;">
        <canvas id="insulinChart" x-init="
            const ctx = document.getElementById('insulinChart').getContext('2d');
            let chart = null;
            
            const updateChart = () => {
                const entries = history.slice().reverse(); // Показываем всю историю
                
                if (entries.length === 0) return;
                
                const labels = entries.map(entry => {
                    const date = new Date(entry.timestamp);
                    return date.toLocaleDateString('ru-RU', { day: 'numeric', month: 'short' });
                });
                
                const glucoseData = entries.map(entry => entry.glucose);
                const carbsData = entries.map(entry => entry.carbs);
                
                const data = {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Глюкоза',
                            data: glucoseData,
                            borderColor: 'rgb(249, 115, 22)',
                            backgroundColor: 'rgba(249, 115, 22, 0.08)',
                            borderWidth: 2.5,
                            tension: 0.4,
                            yAxisID: 'y',
                            type: 'line',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: 'rgb(249, 115, 22)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            fill: true
                        },
                        {
                            label: 'Углеводы',
                            data: carbsData,
                            backgroundColor: 'rgba(6, 182, 212, 0.75)',
                            borderColor: 'rgb(6, 182, 212)',
                            borderWidth: 0,
                            borderRadius: 4,
                            yAxisID: 'y1',
                            type: 'bar',
                            barThickness: 24
                        }
                    ]
                };
                
                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.85)',
                                padding: 10,
                                titleFont: {
                                    size: 12,
                                    weight: 'bold',
                                    family: 'Inter, system-ui, sans-serif'
                                },
                                bodyFont: {
                                    size: 11,
                                    family: 'Inter, system-ui, sans-serif'
                                },
                                bodySpacing: 6,
                                cornerRadius: 6,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += context.parsed.y.toFixed(1);
                                            label += context.datasetIndex === 0 ? ' ммоль/л' : ' г';
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#71717a',
                                    font: {
                                        size: 11,
                                        weight: '500',
                                        family: 'Inter, system-ui, sans-serif'
                                    },
                                    padding: 6
                                }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: false
                                },
                                ticks: {
                                    color: 'rgb(249, 115, 22)',
                                    font: {
                                        size: 10,
                                        weight: '500',
                                        family: 'Inter, system-ui, sans-serif'
                                    },
                                    padding: 6,
                                    callback: function(value) {
                                        return value.toFixed(0);
                                    }
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.04)',
                                    lineWidth: 1
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: false
                                },
                                ticks: {
                                    color: 'rgb(6, 182, 212)',
                                    font: {
                                        size: 10,
                                        weight: '500',
                                        family: 'Inter, system-ui, sans-serif'
                                    },
                                    padding: 6,
                                    callback: function(value) {
                                        return value.toFixed(0);
                                    }
                                },
                                grid: {
                                    drawOnChartArea: false
                                }
                            }
                        }
                    }
                };
                
                if (chart) {
                    chart.destroy();
                }
                
                chart = new Chart(ctx, config);
            };
            
            // Обновляем график при первой загрузке
            setTimeout(updateChart, 100);
            
            // Обновляем график при изменении истории
            $watch('history', () => {
                setTimeout(updateChart, 100);
            });
        "></canvas>
    </div>

    <!-- Statistics Cards -->
    <div class="mt-4 pt-4 border-t border-cyan-200/50 dark:border-cyan-800/30">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- Average Glucose -->
            <div
                class="relative overflow-hidden bg-orange-50/80 dark:bg-orange-900/10 rounded-xl p-3 border border-orange-100 dark:border-orange-800/30 group hover:border-orange-200 dark:hover:border-orange-700/50 transition-colors duration-300">
                <!-- Background Icon -->
                <div
                    class="absolute -right-2 -bottom-4 text-orange-500/10 dark:text-orange-500/20 transform -rotate-12 group-hover:scale-110 group-hover:rotate-0 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16">
                        <path
                            d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div
                        class="text-[10px] font-bold text-orange-600/70 dark:text-orange-400 uppercase tracking-widest mb-1">
                        Средняя Глюкоза</div>
                    <div class="flex items-baseline gap-1.5 mt-auto">
                        <div class="text-2xl font-black text-zinc-700 dark:text-zinc-200 tracking-tight"
                            x-text="history.length > 0 ? (history.reduce((sum, e) => sum + e.glucose, 0) / history.length).toFixed(1) : '—'">
                        </div>
                        <div class="text-[10px] font-bold text-orange-500/80 dark:text-orange-400/80">ммоль/л</div>
                    </div>
                </div>
            </div>

            <!-- Average Carbs -->
            <div
                class="relative overflow-hidden bg-cyan-50/80 dark:bg-cyan-900/10 rounded-xl p-3 border border-cyan-100 dark:border-cyan-800/30 group hover:border-cyan-200 dark:hover:border-cyan-700/50 transition-colors duration-300">
                <!-- Background Icon -->
                <div
                    class="absolute -right-2 -bottom-4 text-cyan-500/10 dark:text-cyan-500/20 transform -rotate-12 group-hover:scale-110 group-hover:rotate-0 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16">
                        <path fill-rule="evenodd"
                            d="M12.963 2.286a.75.75 0 00-1.071-.136 9.742 9.742 0 00-3.539 6.177 7.547 7.547 0 01-1.705-1.715.75.75 0 00-1.152-.082A9 9 0 1015.68 4.534a7.46 7.46 0 01-2.717-2.248zM15.75 14.25a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div
                        class="text-[10px] font-bold text-cyan-600/70 dark:text-cyan-400 uppercase tracking-widest mb-1">
                        Средние Углеводы</div>
                    <div class="flex items-baseline gap-1.5 mt-auto">
                        <div class="text-2xl font-black text-zinc-700 dark:text-zinc-200 tracking-tight"
                            x-text="history.length > 0 ? Math.round(history.reduce((sum, e) => sum + e.carbs, 0) / history.length) : '—'">
                        </div>
                        <div class="text-[10px] font-bold text-cyan-500/80 dark:text-cyan-400/80">грамм</div>
                    </div>
                </div>
            </div>

            <!-- Average Insulin Dose -->
            <div
                class="relative overflow-hidden bg-purple-50/80 dark:bg-purple-900/10 rounded-xl p-3 border border-purple-100 dark:border-purple-800/30 group hover:border-purple-200 dark:hover:border-purple-700/50 transition-colors duration-300">
                <!-- Background Icon -->
                <div
                    class="absolute -right-2 -bottom-4 text-purple-500/10 dark:text-purple-500/20 transform -rotate-12 group-hover:scale-110 group-hover:rotate-0 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16">
                        <path fill-rule="evenodd"
                            d="M11.484 2.17a.75.75 0 011.032 0 11.209 11.209 0 007.877 3.08.75.75 0 01.75.75V12a11.386 11.386 0 01-3.596 8.396A.75.75 0 0116.49 22a9.89 9.89 0 00-8.98-4.26C5.039 17.84 3 16.19 3 14.25V6a.75.75 0 01.75-.75c2.934 0 5.672-1.114 7.734-2.98zM9 11.25a.75.75 0 011.5 0v2.25a.75.75 0 01-1.5 0v-2.25zM12.75 9a.75.75 0 011.5 0v4.5a.75.75 0 01-1.5 0V9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div
                        class="text-[10px] font-bold text-purple-600/70 dark:text-purple-400 uppercase tracking-widest mb-1">
                        Средняя Доза</div>
                    <div class="flex items-baseline gap-1.5 mt-auto">
                        <div class="text-2xl font-black text-zinc-700 dark:text-zinc-200 tracking-tight"
                            x-text="history.length > 0 ? (history.reduce((sum, e) => sum + e.total, 0) / history.length).toFixed(1) : '—'">
                        </div>
                        <div class="text-[10px] font-bold text-purple-500/80 dark:text-purple-400/80">ед</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>