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

    $totalCount = Frazalakon::count();
    $publishedCount = Frazalakon::where('public', true)->count();

    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'frazalakons' => $frazalakons,
        'search' => $request->search ?? '',
        'totalCount' => $totalCount,
        'publishedCount' => $publishedCount,
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
    $captchas = [
        ['question' => 'Quelle est la couleur du cheval blanc d\'Henri IV ?', 'answer' => 'blanc'],
        ['question' => 'Quel animal miaule ?', 'answer' => 'chat'],
        ['question' => 'Quel fruit est jaune et courbé ?', 'answer' => 'banane'],
        ['question' => 'Quel est le contraire de chaud ?', 'answer' => 'froid'],
        ['question' => 'Combien de roues a un vélo ?', 'answer' => '2'],
        ['question' => 'Est-ce que l\'eau ça mouille ? (oui/non)', 'answer' => 'oui'],
        ['question' => 'Quelle lettre vient après A ?', 'answer' => 'b'],
        ['question' => 'De quelle couleur sont les Schtroumpfs ?', 'answer' => 'bleu'],
        ['question' => 'Combien de côtés a un triangle ?', 'answer' => '3'],
        ['question' => 'Quel animal fait meuh ?', 'answer' => 'vache'],
        ['question' => 'Quel animal fait coin-coin ?', 'answer' => 'canard'],
        ['question' => 'Combien y a-t-il de mois dans une année ?', 'answer' => '12'],
        ['question' => 'Comment s\'appelle le fils du père Noël ? (personne, il a pas de fils)', 'answer' => 'personne'],
        ['question' => 'Quel est le premier mois de l\'année ?', 'answer' => 'janvier'],
        ['question' => 'Que met-on dans un grille-pain ?', 'answer' => 'pain'],
        ['question' => 'Épelle le mot "oui" à l\'envers', 'answer' => 'iuo'],
        ['question' => 'De quelle couleur est une orange ?', 'answer' => 'orange'],
        ['question' => 'Quelle planète a des anneaux : Saturne ou la Terre ?', 'answer' => 'saturne'],
        ['question' => 'Combien de zéros dans le nombre 100 ?', 'answer' => '2'],
        ['question' => 'Quel super-héros a une cape et un S sur la poitrine ?', 'answer' => 'superman'],
        ['question' => 'Quel est l\'animal le plus lent : le guépard ou l\'escargot ?', 'answer' => 'escargot'],
        ['question' => 'Combien font 0 + 0 ?', 'answer' => '0'],
        ['question' => 'Quel jour vient après vendredi ?', 'answer' => 'samedi'],
        ['question' => 'Est-ce que le soleil est chaud ? (oui/non)', 'answer' => 'oui'],
        ['question' => 'Quel instrument a des touches noires et blanches ?', 'answer' => 'piano'],
        ['question' => 'Combien de centimètres dans un mètre ?', 'answer' => '100'],
        ['question' => 'Quelle boisson chaude vient d\'un grain torréfié ?', 'answer' => 'café'],
        ['question' => 'Quel légume fait pleurer quand on le coupe ?', 'answer' => 'oignon'],
        ['question' => 'Quelle forme a un ballon de foot ? (ronde/carrée)', 'answer' => 'ronde'],
        ['question' => 'Quel animal porte sa maison sur son dos ?', 'answer' => 'escargot'],
        ['question' => 'Si tu as 3 pommes et que tu en manges 3, il t\'en reste combien ?', 'answer' => '0'],
        ['question' => 'Qu\'est-ce qui est blanc et qui tombe en hiver ?', 'answer' => 'neige'],
        ['question' => 'Combien de "a" dans le mot "banane" ?', 'answer' => '2'],
        ['question' => 'Quel est le plus gros : un éléphant ou une fourmi ?', 'answer' => 'éléphant'],
        ['question' => 'Sur quoi dort la Belle au bois dormant ?', 'answer' => 'lit'],
        ['question' => 'De quelle couleur est un flamant rose ?', 'answer' => 'rose'],
        ['question' => 'Combien de nains accompagnent Blanche-Neige ?', 'answer' => '7'],
        ['question' => 'Quel animal est Nemo ?', 'answer' => 'poisson'],
        ['question' => 'Quelle est la capitale de la France ?', 'answer' => 'paris'],
        ['question' => 'Quel repas on prend le matin ?', 'answer' => 'petit-déjeuner'],
        ['question' => 'Quelle est la forme d\'une pizza ?', 'answer' => 'ronde'],
        ['question' => 'Qu\'est-ce qu\'on met aux pieds pour marcher ?', 'answer' => 'chaussures'],
        ['question' => 'Combien de lettres dans le mot "chat" ?', 'answer' => '4'],
        ['question' => 'Quel est le contraire de grand ?', 'answer' => 'petit'],
        ['question' => 'Combien de cornes a une licorne ?', 'answer' => '1'],
        ['question' => 'Est-ce que les poissons savent nager ? (oui/non)', 'answer' => 'oui'],
        ['question' => 'Quel animal est le roi de la jungle ?', 'answer' => 'lion'],
        ['question' => 'Avec quoi on coupe du papier ?', 'answer' => 'ciseaux'],
        ['question' => 'Quelle couleur obtient-on en mélangeant bleu et jaune ?', 'answer' => 'vert'],
        ['question' => 'Combien d\'oreilles a un lapin ?', 'answer' => '2'],
    ];

    $captcha = $captchas[array_rand($captchas)];
    session(['captcha_answer' => mb_strtolower($captcha['answer'])]);

    return Inertia::render('Denonciation', [
        'captchaQuestion' => $captcha['question'],
    ]);
})->name('denonciation');

Route::post('/denonciation', function (Request $request) {
    $validated = $request->validate([
        'body' => 'required|string|min:3',
        'who' => 'required|string|min:1',
        'towho' => 'nullable|string',
        'context' => 'nullable|string',
        'where' => 'nullable|string',
        'captcha' => ['required', function (string $attribute, mixed $value, \Closure $fail) {
            if (mb_strtolower(trim($value)) !== session('captcha_answer')) {
                $fail('Mauvaise réponse, essaie encore.');
            }
        }],
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
