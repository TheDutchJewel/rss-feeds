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

$feed = [];

$tables = $xpath->query('//table[contains(@class,"views-table")]');

foreach ($tables as $table) {

    $captionNode = $xpath->query('./caption', $table)->item(0);

    if (!$captionNode) {
        continue;
    }

    $datum = trim($captionNode->textContent);

    $rows = $xpath->query('./tbody/tr', $table);

    foreach ($rows as $row) {

        $linkNode = $xpath->query(
            './/td[contains(@class,"views-field-title")]//a',
            $row
        )->item(0);

        if (!$linkNode) {
            continue;
        }

        $naam = trim($linkNode->textContent);

        $versieNode = $xpath->query(
            './/td[contains(@class,"views-field-field-versienummer")]',
            $row
        )->item(0);

        if (!$versieNode) {
            continue;
        }

        $versie = trim(
            preg_replace(
                '/\s+/',
                ' ',
                $versieNode->textContent
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
            'pubDate' => $datum
        ];
    }
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
