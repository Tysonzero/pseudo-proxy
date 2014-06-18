<?php
    function url($part = -1)
    {
        $url = parse_url($_SERVER['QUERY_STRING']);
        $scheme = (empty($url['scheme']) ? '' : $url['scheme'].'://');
        $host = (empty($url['host']) ? '' : $url['host']);
        $port = (empty($url['port']) ? '' : ':'.$url['port']);
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

    if (preg_replace('#^.*\.#', '', url(1)) == 'css') {
        header('Content-Type:text/css');
    }
    elseif (preg_replace('#^.*\.#', '', url(1)) == 'js') {
        header('Content-Type:text/js');
    }

    $contents = file_get_contents($_SERVER['QUERY_STRING']);

    $contents = preg_replace('#action="(/[\w\./-]*)"#', 'action="/?'.url(0).'${1}"', $contents);
    $contents = preg_replace('#href="(/[\w\./-]*)"#', 'href="/?'.url(0).'${1}"', $contents);
    $contents = preg_replace('#src="(/[\w\./-]*)"#', 'src="/?'.url(0).'${1}"', $contents);

    $contents = preg_replace('#action="(\w[\w\./-]*)"#', 'src="/?'.url().'${1}"', $contents);
    $contents = preg_replace('#href="(\w[\w\./-]*)"#', 'href="/?'.url().'${1}"', $contents);
    $contents = preg_replace('#src="(\w[\w\./-]*)"#', 'src="/?'.url().'${1}"', $contents);

    $contents = preg_replace('#action="([\w\.:/-]*)"#', 'action="/?${1}"', $contents);
    $contents = preg_replace('#href="([\w\.:/-]*)"#', 'href="/?${1}"', $contents);
    $contents = preg_replace('#src="([\w\.:/-]*)"#', 'src="/?${1}"', $contents);

    echo $contents;
?>
