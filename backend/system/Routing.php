<?php

class Router
{
    private $pages = [];

    function addRoute($url, $path)
    {

        $this->pages[$url] = $path;
    }

    function route($url)
    {
        $params = [];

        $mainUrl = parse_url($url)['path'];

        $arrWords = explode('/',  $mainUrl);

        foreach ($this->pages as $key1 => $fileDir) {
            $keyWords  = explode('/',  $key1);
            $params = [];
            if (count($keyWords) !== count($arrWords)) {
                continue;
            }

            foreach ($keyWords as $key2 => $word) {

                if (strpos($word, '$') !== false) {
                    $params[str_replace("$", "", $word)] = $arrWords[$key2];
                } elseif ($arrWords[$key2] === $word) {
                } else {
                    break;
                };

                if ($key2 + 1 == count($keyWords)) {
                    if (file_exists($fileDir)) {
                        $params['url'] = $key1;
                        require $fileDir;
                        return;
                    } else {
                        require '404.php';
                        die();
                    }
                }
            }
        }

        require '404.php';
        die();
    }
}
