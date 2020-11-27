<?php
$resource = "your resource;)";

// чтение cvs и сравнение тегов
// $resource путь к cvs
function compareTags($resource)
{
    $row = 1;
    if (($file = fopen($resource, "r")) !== false) {
        while (($data = fgetcsv($file, 1000, ",")) !== false) {
            if ($row != 1){
                $metaData = parse($data[0]);
                for ($i = 1; $i <= 2; $i++){
                    if ($data[$i] != $metaData[$i]){
                        echo "wrong meta tags, expected: " . $data[$i] ." - actual: ".$metaData[$i] . "<br />";
                    }
                }
            }

            $row++;
        }

        echo 'completed' . "<br />";
        fclose($file);
    }
}

//получаем данные о странице
function urlGetContents($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Cookie: test=seo"));
    $postResult = curl_exec($curl);

    if (curl_errno($curl)) {
        print curl_error($curl);
    }

    curl_close($curl);

    return $postResult;
}

// парсим полученные данные
function parse($url)
{
    $title = '';
    $description = '';

    $html = urlGetContents($url);
    $doc = new DOMDocument();
    @$doc->loadHTML($html);
    $nodes = $doc->getElementsByTagName('title');

    if (is_object($nodes->item(0))) {
        $title = $nodes->item(0)->nodeValue;
    }

    $metas = $doc->getElementsByTagName('meta');

    for ($i = 0; $i < $metas->length; $i++) {
        $meta = $metas->item($i);
        if ($meta->getAttribute('name') == 'description')
            $description = $meta->getAttribute('content');
    }

    $metaData = array($url, $title, $description);

    return $metaData;
}

compareTags($resource);