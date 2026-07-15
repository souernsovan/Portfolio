<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'projects' => Project::count(),
            'skills' => Skill::count(),
            'messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::whereNull('read_at')->count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $messagesTrend = $this->messagesTrend();
        $skillsByCategory = $this->skillsByCategory();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'messagesTrend', 'skillsByCategory'));
    }

    private function messagesTrend(): array
    {
        $days = 14;
        $start = Carbon::today()->subDays($days - 1);

        $counts = ContactMessage::selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->pluck('total', 'day');

        return collect(range(0, $days - 1))->map(function (int $offset) use ($start, $counts) {
            $date = $start->copy()->addDays($offset);
            $key = $date->format('Y-m-d');

            return [
                'label' => $date->format('M j'),
                'value' => (int) ($counts[$key] ?? 0),
            ];
        })->all();
    }

    private function skillsByCategory(): array
    {
        $rows = Skill::with('category')->get()
            ->filter(fn (Skill $skill) => $skill->category !== null)
            ->groupBy(fn (Skill $skill) => $skill->category->name)
            ->map(fn ($skills, $name) => [
                'label' => $name,
                'value' => (int) round($skills->avg('level')),
                'count' => $skills->count(),
            ])
            ->values();

        // Assign each category a stable color slot (alphabetical), independent of the
        // avg_level ranking used for display, so a category's color never shifts as its
        // numbers change.
        $colorOrder = $rows->pluck('label')->sort()->values();

        return $rows->sortByDesc('value')->values()
            ->map(fn ($row) => [
                ...$row,
                'colorIndex' => $colorOrder->search($row['label']),
            ])
            ->all();
    }
}
