<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\Tip;
use Carbon\Carbon;

class TipOfTheDay extends Component
{
    public string $tip;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->tip = Cache::remember('tip_of_the_day_' . Carbon::now()->format('Y-m-d'), 60 * 24, function () {
            // Get a random active tip
            $tip = Tip::where('is_active', true)->inRandomOrder()->first();

            // Fallback if no tips in DB
            return $tip ? $tip->content : 'Пейте достаточно воды!';
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tip-of-the-day');
    }
}
