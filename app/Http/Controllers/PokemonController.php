<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PokemonRepositoryInterface;
use App\Http\Repositories\TypeRepositoryInterface;
use App\Http\Requests\PokemonDeleteRequest;
use App\Http\Requests\PokemonStoreRequest;
use App\Http\Requests\PokemonUpdateRequest;
use App\Models\Pokemon;
use App\QRcode\PokemonQrMakerInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use ZipArchive;

class PokemonController extends Controller
{
    private PokemonRepositoryInterface $pokemonRepository;
    private TypeRepositoryInterface $typeRepository;

    /**
     * @param PokemonRepositoryInterface $pokemonRepository
     * @param TypeRepositoryInterface $typeRepository
     */
    public function __construct(PokemonRepositoryInterface $pokemonRepository, TypeRepositoryInterface $typeRepository)
    {
        $this->middleware("auth");
        $this->middleware("verified");

        $this->pokemonRepository = $pokemonRepository;
        $this->typeRepository = $typeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        Gate::authorize("is_admin");

        $pokemons = $this->pokemonRepository->getAllOrderedByNamePaginated(15);

        return view('pokemons.index', [
            "pokemons" => $pokemons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        Gate::authorize("is_admin");

        $types = $this->typeRepository->getAll();

        return view('pokemons.create', [
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PokemonStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PokemonStoreRequest $request): RedirectResponse
    {
        $data = $request->toArray();

        foreach ($data['types'] as &$type) {
            $type = intval($type);
        }

        $this->pokemonRepository->create($data);

        return redirect(route('pokemons.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param Pokemon $pokemon
     * @return View
     */
    public function edit(Request $request, Pokemon $pokemon): View
    {
        Gate::authorize("is_admin");

        $types = $this->typeRepository->getAll();

        return view('pokemons.edit', [
            "pokemon" => $pokemon,
            "types" => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PokemonUpdateRequest $request
     * @param Pokemon $pokemon
     * @return RedirectResponse
     */
    public function update(PokemonUpdateRequest $request, Pokemon $pokemon): RedirectResponse
    {
        $data = $request->toArray();

        foreach ($data['types'] as &$type) {
            $type = intval($type);
        }

        $this->pokemonRepository->update($pokemon, $data);

        return redirect(route('pokemons.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PokemonDeleteRequest $request
     * @param Pokemon $pokemon
     * @return RedirectResponse
     */
    public function destroy(PokemonDeleteRequest $request, Pokemon $pokemon): RedirectResponse
    {
        $this->pokemonRepository->delete($pokemon->id);

        return redirect(route('pokemons.index'));
    }
}
