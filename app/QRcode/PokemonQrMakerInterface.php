<?php


namespace App\QRcode;


interface PokemonQrMakerInterface
{
    public function makeZipForAll(int $size) : string;
}
