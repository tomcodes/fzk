<?php

use App\Models\Frazalakon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function (Request $request) {
    $user = Auth::user();

    $frazalakons = Frazalakon::query()
        ->when(! $user, fn ($q) => $q->where('public', true))
        ->when($request->search, fn ($q, $search) => $q->where(function ($q) use ($search) {
            $q->whereRaw('body ilike ?', ["%{$search}%"])
                ->orWhereRaw('who ilike ?', ["%{$search}%"])
                ->orWhereRaw('towho ilike ?', ["%{$search}%"])
                ->orWhereRaw('context ilike ?', ["%{$search}%"])
                ->orWhereRaw('"where" ilike ?', ["%{$search}%"])
                ->orWhereRaw('author ilike ?', ["%{$search}%"]);
        }))
        ->latest('created_at')
        ->paginate(20)
        ->withQueryString();

    $likedIds = $user ? $user->likedFrazalakons()->pluck('frazalakon_id')->all() : [];

    $frazalakons->through(fn ($fzk) => array_merge($fzk->toArray(), [
        'is_liked' => in_array($fzk->id, $likedIds),
    ]));

    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'frazalakons' => $frazalakons,
        'search' => $request->search ?? '',
    ]);
})->name('home');

Route::get('/top-47', function () {
    $user = Auth::user();

    $frazalakons = Frazalakon::query()
        ->when(! $user, fn ($q) => $q->where('public', true))
        ->orderByDesc('heart_count')
        ->limit(47)
        ->get();

    $likedIds = $user ? $user->likedFrazalakons()->pluck('frazalakon_id')->all() : [];

    $frazalakons = $frazalakons->map(fn ($fzk) => array_merge($fzk->toArray(), [
        'is_liked' => in_array($fzk->id, $likedIds),
    ]));

    return Inertia::render('Top47', [
        'frazalakons' => $frazalakons,
    ]);
})->name('top47');

Route::get('/random', function () {
    $user = Auth::user();

    $frazalakon = Frazalakon::query()
        ->when(! $user, fn ($q) => $q->where('public', true))
        ->inRandomOrder()
        ->firstOrFail();

    return redirect()->route('frazalakon.show', $frazalakon);
})->name('random');

Route::get('/denonciation', function () {
    return Inertia::render('Denonciation');
})->name('denonciation');

Route::post('/denonciation', function (Request $request) {
    $validated = $request->validate([
        'body' => 'required|string|min:3',
        'who' => 'required|string|min:1',
        'towho' => 'nullable|string',
        'context' => 'nullable|string',
        'where' => 'nullable|string',
    ]);

    $frazalakon = Frazalakon::create([
        ...$validated,
        'slug' => \Illuminate\Support\Str::slug(\Illuminate\Support\Str::limit($validated['body'], 80, '')).'-'.now()->timestamp,
        'when' => now(),
        'public' => false,
        'heart_count' => 0,
    ]);

    return redirect()->route('home')->with('success', 'Dénonciation envoyée !');
})->name('denonciation.store');

Route::post('/{frazalakon}/like', function (Frazalakon $frazalakon) {
    $user = Auth::user();

    $user->likedFrazalakons()->toggle($frazalakon->id);

    $frazalakon->update([
        'heart_count' => $frazalakon->likedBy()->count(),
    ]);

    return back();
})->middleware('auth')->name('frazalakon.like');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';

// Slug catch-all must be last to avoid conflicts with named routes
Route::get('/{frazalakon}', function (Frazalakon $frazalakon) {
    if (! $frazalakon->public && ! Auth::check()) {
        abort(404);
    }

    $user = Auth::user();

    return Inertia::render('Frazalakon/Show', [
        'frazalakon' => array_merge($frazalakon->toArray(), [
            'is_liked' => $user ? $user->likedFrazalakons()->where('frazalakon_id', $frazalakon->id)->exists() : false,
        ]),
    ]);
})->name('frazalakon.show');
