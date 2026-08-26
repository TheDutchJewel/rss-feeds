<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$url = 'https://www.gratissoftwaresite.nl/downloads/nieuwe-updates';

$html = file_get_contents($url);

if ($html === false) {
    die('Kan pagina niet ophalen');
}

$dom = new DOMDocument();
@$dom->loadHTML($html);

$xpath = new DOMXPath($dom);

$rows = $xpath->query('//tr');

$feed = [];

foreach ($rows as $row) {

    $tds = $xpath->query('./td', $row);

    if ($tds->length < 3) {
        continue;
    }

    $linkNode = $xpath->query('.//a', $row)->item(0);

    if (!$linkNode) {
        continue;
    }

    $naam = trim($linkNode->textContent);

    $versie = trim(
        preg_replace(
            '/\s+/',
            ' ',
            $tds->item(2)->textContent
        )
    );

    if ($naam === '' || $versie === '') {
        continue;
    }

    $href = trim($linkNode->getAttribute('href'));

    if (!preg_match('/^https?:\/\//', $href)) {
        $href = 'https://www.gratissoftwaresite.nl' . $href;
    }

    $feed[] = [
        'title'   => $naam . ' ' . $versie,
        'link'    => $href,
        'pubDate' => gmdate('D, d M Y H:i:s O')
    ];
}

$json = json_encode(
    $feed,
    JSON_PRETTY_PRINT |
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES
);

file_put_contents(
    __DIR__ . '/../feeds/gratissoftwaresite.json',
    $json
);

echo count($feed) . " items opgeslagen in gratissoftwaresite.json";
