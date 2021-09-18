<?php


namespace App\Services\Views;


class FontColorService implements FontColorServiceInterface
{
    public function getFontColorFromBackground(string $hex_background_color) {
        list($r, $g, $b) = sscanf($hex_background_color, "#%02x%02x%02x");
        $coef = ((0.2125 * $r) + (0.7154 * $g) + (0.0721 * $b)) / 255;

        return ($coef > 0.5) ? '#000000' : '#FFFFFF';
    }
}
