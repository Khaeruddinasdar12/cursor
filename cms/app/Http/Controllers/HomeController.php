<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\OfficeHour;
use App\Models\Partner;
use App\Models\Pillar;
use App\Models\Post;
use App\Models\Publication;
use App\Models\QuickLink;
use App\Models\ServiceCenter;
use App\Models\ServiceStep;
use App\Models\Stat;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'stats' => Stat::active()->ordered()->get(),
            'heroLinks' => QuickLink::active()->placement(QuickLink::HERO)->ordered()->get(),
            'ctaLinks' => QuickLink::active()->placement(QuickLink::SERVICE_CTA)->ordered()->get(),
            'announcements' => Announcement::active()->ordered()->get(),
            'pillars' => Pillar::active()->ordered()->get(),
            'centers' => ServiceCenter::active()->ordered()->get(),
            'steps' => ServiceStep::active()->ordered()->get(),
            'publications' => Publication::active()->ordered()->get(),
            'documents' => Document::active()->ordered()->get(),
            'posts' => Post::published()->with('category')->latestFirst()->limit((int) setting('news_home_limit', 4))->get(),
            'events' => Event::upcoming()->limit((int) setting('agenda_home_limit', 4))->get(),
            'officeHours' => OfficeHour::active()->ordered()->get(),
            'partners' => Partner::active()->ordered()->get(),
        ]);
    }
}
