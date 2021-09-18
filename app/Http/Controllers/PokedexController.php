<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PokemonRepositoryInterface;
use App\Http\Repositories\TypeRepositoryInterface;
use App\Http\Repositories\UserRepositoryInterface;
use App\Http\Requests\DownloadQrCodeRequest;
use App\Models\Pokemon;
use App\QRcode\PokemonQrMakerInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class PokedexController extends Controller
{
    private PokemonRepositoryInterface $pokemonRepository;
    private UserRepositoryInterface  $userRepository;
    private TypeRepositoryInterface  $typeRepository;

    private PokemonQrMakerInterface $pokemonQrMaker;

    /**
     * @param PokemonRepositoryInterface $pokemonRepository
     * @param UserRepositoryInterface $userRepository
     * @param TypeRepositoryInterface $typeRepository
     * @param PokemonQrMakerInterface $pokemonQrMaker
     */
    public function __construct(
        PokemonRepositoryInterface $pokemonRepository,
        UserRepositoryInterface $userRepository,
        TypeRepositoryInterface $typeRepository,
        PokemonQrMakerInterface $pokemonQrMaker
    )
    {
        $this->middleware("auth");
        $this->middleware("verified");

        $this->pokemonRepository = $pokemonRepository;
        $this->userRepository = $userRepository;
        $this->typeRepository = $typeRepository;

        $this->pokemonQrMaker = $pokemonQrMaker;
    }

    /**
     * Display pokedex
     *
     * @return View
     */
    public function index(): View
    {
        $user = Auth::user();

        $user_types = $this->typeRepository->get_types_by_user($user);
        $types = $this->typeRepository->getAllOrderedByName();

        return view('pokedex.index', [
            'pokemons' => $user->pokemons,
            'types' => $types,
            'user_types' => $user_types,
            'user' => $user,
        ]);
    }

    /**
     * Display pokemon find page
     *
     * @param string $sha1_hash
     * @return View
     */
    public function find(string $sha1_hash): View
    {
        $pokemon = $this->pokemonRepository->getByHash($sha1_hash);

        if ($pokemon == null) {
            abort(404);
        }

        $user = Auth::user();
        $already_caught = $user->pokemons->contains($pokemon);

        return view('pokedex.catch', [
            'already_caught' => $already_caught,
            'pokemon' => $pokemon,
            'sha1_hash' => $sha1_hash,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $sha1_hash
     * @return RedirectResponse
     */
    public function save(string $sha1_hash): RedirectResponse
    {
        $pokemon = $this->pokemonRepository->getByHash($sha1_hash);

        if ($pokemon == null) {
            abort(404);
        }

        $user = Auth::user();
        $already_caught = $user->pokemons->contains($pokemon);

        if ($already_caught) {
            abort(400);
        }

        $this->userRepository->addPokemon($user, $pokemon);

        return redirect(route('pokedex.index'));
    }

    /**
     * Display qr code download form
     *
     * @return View
     */
    public function show_qr_codes_form(): View
    {
        Gate::authorize("download_qr_code");

        return view('pokedex.qrcodes');
    }

    /**
     * Handle QR code generation request
     *
     * @param DownloadQrCodeRequest $request
     * @return BinaryFileResponse
     */
    public function download_qr_codes(DownloadQrCodeRequest $request): BinaryFileResponse
    {

        $size = intval($request->get('size'));

        $zip_filename = $this->pokemonQrMaker->makeZipForAll($size);

        return response()->download(
            $zip_filename,
            'intemons_qrcodes' . date('Y-m-d_H:i:s_') . $size . ".zip"
        )->deleteFileAfterSend(true);
    }
}
