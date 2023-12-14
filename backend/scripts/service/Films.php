<?php

namespace Palmo\Core\service;

abstract class Films
{
    abstract public function getFilms($search, $genresFiltre, $switchSort, $maxFillPage, $startItem);
    abstract public function getFilm($id);
    abstract public function addFilm($id, $title, $date, $genres, $img_url, $about);
}
