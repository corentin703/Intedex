<?php


namespace App\Services\Views;


interface FontColorServiceInterface
{
    public function getFontColorFromBackground(string $hex_background_color);
}
