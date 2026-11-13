<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UpbjjZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UpbjjZoneController extends Controller
{
    public function index(): View
    {
        UpbjjZone::seedDefaultsIfEmpty();

        $zones = UpbjjZone::orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.upbjj-zones.index', compact('zones'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'coverage' => 'required|string',
            'partner' => 'nullable|string|max:255',
            'head_name' => 'nullable|string|max:255',
            'vice_head_name' => 'nullable|string|max:255',
            'secretary_name' => 'nullable|string|max:255',
            'coordinator_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'male_students_count' => 'required|integer|min:0',
            'female_students_count' => 'required|integer|min:0',
            'bubble_color' => 'required|string|max:30',
            'map_x' => 'nullable|numeric|min:5|max:95',
            'map_y' => 'nullable|numeric|min:5|max:95',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $totalStudents = (int) $validated['male_students_count'] + (int) $validated['female_students_count'];

        UpbjjZone::create(array_merge($validated, [
            'students_count' => $totalStudents,
            'map_x' => $validated['map_x'] ?? 50.0,
            'map_y' => $validated['map_y'] ?? 50.0,
            'order' => $validated['order'] ?? (UpbjjZone::max('order') + 1),
            'is_active' => $request->boolean('is_active', true),
        ]));

        return back()->with('success', 'Zona & Wilayah UPBJJ beserta rincian jumlah mahasiswa berhasil ditambahkan!');
    }

    public function update(Request $request, UpbjjZone $upbjj_zone): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'coverage' => 'required|string',
            'partner' => 'nullable|string|max:255',
            'head_name' => 'nullable|string|max:255',
            'vice_head_name' => 'nullable|string|max:255',
            'secretary_name' => 'nullable|string|max:255',
            'coordinator_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'male_students_count' => 'required|integer|min:0',
            'female_students_count' => 'required|integer|min:0',
            'bubble_color' => 'required|string|max:30',
            'map_x' => 'nullable|numeric|min:5|max:95',
            'map_y' => 'nullable|numeric|min:5|max:95',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $totalStudents = (int) $validated['male_students_count'] + (int) $validated['female_students_count'];

        $upbjj_zone->update(array_merge($validated, [
            'students_count' => $totalStudents,
            'map_x' => $validated['map_x'] ?? $upbjj_zone->map_x,
            'map_y' => $validated['map_y'] ?? $upbjj_zone->map_y,
            'order' => $validated['order'] ?? $upbjj_zone->order,
            'is_active' => $request->boolean('is_active'),
        ]));

        return back()->with('success', 'Data Zona, Rincian Mahasiswa Laki-Laki/Perempuan & Sebaran Peta UPBJJ berhasil diperbarui!');
    }

    public function destroy(UpbjjZone $upbjj_zone): RedirectResponse
    {
        $upbjj_zone->delete();

        return back()->with('success', 'Zona & Wilayah UPBJJ berhasil dihapus.');
    }
}
