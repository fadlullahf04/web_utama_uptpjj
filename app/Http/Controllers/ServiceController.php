<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Schema;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->get();

        return view('pages.services.index', compact('services'));
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        if (Schema::hasColumn($service->getTable(), 'views_count')) {
            $service->increment('views_count');
        }
        $otherServices = Service::active()->where('id', '!=', $service->id)->get();

        return view('pages.services.show', compact('service', 'otherServices'));
    }
}
