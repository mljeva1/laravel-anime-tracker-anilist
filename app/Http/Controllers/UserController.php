<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Services\AniListService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $aniListService;

     public function __construct(AniListService $aniListService)
     {
         $this->aniListService = $aniListService;
     }

    public function index()
    {
        //
        $users=User::with('role')->find(Auth::id());
        //dd($users);
        $avatars = $this->getRandomAvatars();
        return view('user.user', compact('users', 'avatars'));
    }

    public function refreshAvatars()
    {
        $avatars = $this->getRandomAvatars(true); // true znači da će se ignorirati cache
        return redirect()->back()->with('avatars', $avatars);
    }

    private function getRandomAvatars($refresh = false)
    {
        // Generiraj 6 random ID-jeva za likove
        $randomIds = collect(range(1, 6))->map(fn() => rand(1, 10000))->toArray();
        $results = [];
        
        foreach ($randomIds as $id) {
            $cacheKey = "character_{$id}";
            
            // Ako je refresh true, izbriši cache
            if ($refresh) {
                Cache::forget($cacheKey);
            }
            // Koristi AniListService za dohvaćanje podataka o liku
            $characterData = Cache::remember($cacheKey, 60*60*24, function() use ($id) {
                $response = $this->aniListService->userAvatar($id);
                return $response['data']['Character'] ?? null;
            });
            
            if ($characterData) {
                $results[] = $characterData;
            }
        }
        
        return $results;
    }

    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|url',
        ]);
        
        $user = Auth::user();
        $user->update(['avatar' => $validated['avatar']]);
        
        return redirect()->route('user.user')->with('success', 'Avatar je uspješno ažuriran.');
    }
    
    public function userAvatar()
    {
        $randomIds = collect(range(1, 7))->map(fn() => rand(1, 10000))->toArray();
        $results = [];
        
        foreach ($randomIds as $id) {
            $characterData = Cache::remember("character_{$id}", 60*60*24, function() use ($id) {
                $query = 'query ($characterId: Int) {
                    Character(id: $characterId) {
                        image {
                            medium
                            large
                        }
                        name {
                            full
                        }
                    }
                }';
                
                $variables = ['characterId' => $id];
                
                $response = Http::post('https://graphql.anilist.co', [
                    'query' => $query,
                    'variables' => $variables
                ]);
                
                return $response->json()['data']['Character'] ?? null;
            });
            
            if ($characterData) {
                $results[] = $characterData;
            }
        }
        return view('user.user', compact('results'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info("Primljeni podaci: ", $request->all());

        $validationRules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'avatar' => 'string|max:255',
        ];
        if ($request->filled('password')) {
            $validationRules['password'] = 'string|min:8|max:255';
        }
        if ($request->filled('email')) {
            $validationRules['email'] = 'email|max:255|unique:users,email,' . $id;
        }
        $validated = $request->validate($validationRules);

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->name,
            'role_id' => 2,
        ];
        if ($request->filled('email')) {
            $userData['email'] = $request->email;
        }

        if ($request->filled('avatar')) {
            $userData['avatar'] = $request->avatar;
        }

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        Log::info('Validirani podaci: ', $validated);

        $user = User::findOrFail($id);
        $user->update($userData);

        Log::info('Korisnik uspješno ažuriran:', $user->toArray());
        
        return redirect()->route('user.user')->with('success', 'Korisnik je uspješno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
