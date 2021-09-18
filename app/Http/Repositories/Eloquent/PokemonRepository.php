<?php


namespace App\Http\Repositories\Eloquent;


use App\Http\Repositories\PokemonRepositoryInterface;
use App\Http\Repositories\TypeRepositoryInterface;
use App\Models\Pokemon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Array_;

class PokemonRepository extends BaseRepository implements PokemonRepositoryInterface
{
    private TypeRepositoryInterface $typeRepository;

    public function __construct(Pokemon $model, TypeRepositoryInterface $typeRepository)
    {
        parent::__construct($model);

        $this->typeRepository = $typeRepository;
    }

    public function getByHash(string $sha1_hash): Pokemon | null
    {
        return $this->model->where('sha1_hash', $sha1_hash)->first();
    }

    public function create(array $attributes): Model
    {
        $pokemon = parent::create($attributes);

        foreach ($attributes['types'] as $type) {
            $type = $this->typeRepository->getById($type);
            if (is_array($type)) {
                $type = $type[0];
            }

            $this->typeRepository->add_pokemon($type, $pokemon);
        }

        return $pokemon;
    }

    public function update(Model $model, array $attributes): bool
    {
        $model->types()->detach();
        foreach ($attributes['types'] as $type) {

            $type = $this->typeRepository->getById($type);
            if (is_array($type)) {
                $type = $type[0];
            }

            $this->typeRepository->add_pokemon($type, $model);
        }

        return parent::update($model, $attributes);
    }
}
