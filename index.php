<?php
    function url($part = -1)
    {
        $url = parse_url($_SERVER['QUERY_STRING']);
        $scheme = (empty($url['scheme']) ? '' : $url['scheme'].'://');
        $host = (empty($url['host']) ? '' : $url['host']);
        $port = (empty($url['port']) ? '' : $url['port']);
        $path = (empty($url['path']) ? '' : $url['path']);
        $query = (empty($url['query']) ? '' : '?'.$url['query']);
        if ($part == 0) {
            return $scheme.$host.$port;
        }
        elseif ($part == 1) {
            return $path;
        }
        else {
            return $scheme.$host.$port.$path;
        }
    };

    $contents = file_get_contents(url());

    $contents = preg_replace('#href="(/[\w\./-]*)"#', 'href="/?'.url(0).'${1}"', $contents);
    $contents = preg_replace('#src="(/[\w\./-]*)"#', 'src="/?'.url(0).'${1}"', $contents);

    $contents = preg_replace('#href="(\w[a-zA-Z/\.-]*)"#', 'href="/?'.url().'${1}"', $contents);
    $contents = preg_replace('#src="(\w[a-zA-Z/\.-]*)"#', 'src="/?'.url().'${1}"', $contents);

    $contents = preg_replace('#href="([a-zA-Z/\.:-]*)"#', 'href="/?${1}"', $contents);
    $contents = preg_replace('#src="([a-zA-Z/\.:-]*)"#', 'src="/?${1}"', $contents);

    echo $contents;
?>
