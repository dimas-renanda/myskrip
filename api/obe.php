<?php 

function hasher($data)
{
    return md5($data."tD30b1X1rq5t");
}

function cleanHeader($string)
{
        // Remove spaces from the string
        $string = str_replace(' ', '', $string);
    
        // Find the position of the character
        $position = strpos($string, '(');
    
        if ($position !== false) {
            // Extract the substring before the character
            $string = substr($string, 0, $position);
        }
    
        return $string;
}

function extractMaxNumber($string) {
    $pattern = '/Max:(\d+)/';
    preg_match($pattern, $string, $matches);
    if (isset($matches[1])) {
        return $matches[1];
    }
    return null;
}

function isObeEval($ar,$search)
{

$filteredData = array_filter($ar, function($item) use ($search) {
    return strpos($item['name'], $search) !== false;
});

if (empty($filteredData))
{
    Echo 'Evaluasi tidak ditemukan !';
    return NULL;
}
elseif (!empty($filteredData))
{
    Echo 'Evaluasi Berhasil ditemukan !';
    return($filteredData); 
};

}

$periode = $_GET['periode'];
$kodeunit = $_GET['kodeunit'];
$kodemk = $_GET['kodemk'];

$token = hasher("$periode,$kodeunit,$kodemk");


$ch = curl_init();

$url  = 'https://obe.petra.ac.id/serviceout.php?t=get_asesmen_list&kodemk='.$kodemk."&periode=".$kodeunit."&periode=".$periode.'&kodeunit=15&token='.$token;

$homepage = file_get_contents($url);

$jsonArrayResponse = json_decode($homepage, true);

$searchString = 'UTS';

//isObeEval($jsonArrayResponse,$searchString);
$filteredarray = isObeEval($jsonArrayResponse,$searchString);

echo '<br>';

foreach($filteredarray as $data)
{

    if($data['name'] != "")
    {

        echo cleanHeader($data['name']) , '<br>';
        echo count($data['soal']),'<br>';
        
        foreach ($data['soal'] as $key => $question) 
        {
            echo  $question . "<br>";
            echo 'Max number for this question : '.extractMaxNumber($question) . "<br>";
        }
        echo '<br>';

    }

}

?>