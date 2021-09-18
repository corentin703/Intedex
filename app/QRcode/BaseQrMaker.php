<?php


namespace App\QRcode;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;

class BaseQrMaker implements BaseQrMakerInterface
{
    protected function prepare(int $size) : Generator {
        return QrCode::encoding('UTF-8')
            ->size($size)
            ->merge('/public/images/logo_allokemons_squared.png')
            ->margin($size / 100)
            ->format('png');
    }
}
