<?php


namespace App\QRcode;


use App\Http\Repositories\PokemonRepositoryInterface;
use App\Models\Pokemon;
use Faker\Core\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;
use SimpleSoftwareIO\QrCode\Generator;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;
use ZipArchive;

class PokemonQrMaker extends BaseQrMaker implements PokemonQrMakerInterface
{
    private PokemonRepositoryInterface $pokemonRepository;

    private const QRCODES_STORAGE_PATH = 'qrcodes';
    private string $qr_codes_directory_path;

    public function __construct(PokemonRepositoryInterface $pokemonRepository)
    {
        $this->pokemonRepository = $pokemonRepository;

        $this->qr_codes_directory_path = storage_path(PokemonQrMaker::QRCODES_STORAGE_PATH) . '/';

        if (!file_exists($this->qr_codes_directory_path)) {
            mkdir($this->qr_codes_directory_path);
        }
    }

    private function generate(Pokemon $pokemon, int $size) : HtmlString {
        $auth_user_id = Auth::id();

        Log::info("$auth_user_id -> QR code generated");

        return $this->prepare($size)->generate(route('pokedex.find', $pokemon->sha1_hash));
    }

    private function new_zip_file_name() : string {
        return $this->qr_codes_directory_path . rand(1, 100) . ".zip";
    }

    public function makeZipForAll(int $size) : string {

        $pokemons = $this->pokemonRepository->getAll();

        $zip_filename = $this->new_zip_file_name();
        $zip = new ZipArchive();

        if ($zip->open($zip_filename, ZipArchive::CREATE) === TRUE)
        {
            foreach (Pokemon::rareness_display_strings as $rareness_display_string) {
                $zip->addEmptyDir($rareness_display_string);
            }

            foreach ($pokemons as &$pokemon) {
                $qr_file = $this->generate($pokemon, $size);

                $zip->addFromString(
                    Pokemon::rareness_display_strings[$pokemon->rareness] . '/' . $pokemon->name . '-' . $pokemon->sex . '.png',
                    $qr_file
                );
            }

            // All files have been added, so close the zip file.
            $zip->close();

            return $zip_filename;
        }

        throw new CannotWriteFileException("Cannot create zip file");
    }
}
