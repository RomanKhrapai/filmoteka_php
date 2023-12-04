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
        $query = [];
        $params = [];

        $mainUrl = substr($url, 0, strpos($url, "?"));
        $mainUrl = $mainUrl === '' ? $url : $mainUrl;
        $arrWords = explode('/',  $mainUrl);

        $queryArr = strpos($url, "?") ? explode('&', substr($url, strpos($url, "?") + 1)) : [];

        foreach ($queryArr as $parametr) {
            $key = substr($parametr, 0, strpos($parametr, "="));
            $value = substr($parametr, strpos($parametr, "=") + 1);
            $query[$key] = $value;
        }

        foreach ($this->pages as $key1 => $value) {
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
                    $fileDir = 'pages/' . $value;
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
