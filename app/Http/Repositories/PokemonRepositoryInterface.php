<?php


namespace App\Http\Repositories;


use App\Models\Pokemon;
use Illuminate\Database\Eloquent\Model;

interface PokemonRepositoryInterface extends BaseRepositoryInterface
{
    public function getByHash(string $sha1_hash): Pokemon | null;
}
