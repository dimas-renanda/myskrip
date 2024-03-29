
<?php 
require_once "../conf/safety.php";

function hasher($data)
{
    return md5($data."tD30b1X1rq5t");
}

function cleanHeader($string)
{
        $string = str_replace(' ', '', $string);
    
        $position = strpos($string, '(');
    
        if ($position !== false) {
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

function extractSemesterValue($string) {
    $parts = explode("-", $string);

    $value = $parts[3];

    return $value;
}

function extractYearValue($string) {

    $parts = explode("-", $string);

    $value = $parts[4];

    return $value;
}

function extractClassValue($string) {
    $parts = explode("-", $string);

    $value = $parts[2];

    return $value;
}

function extractClassNameValue($string) {
    $parts = explode("-", $string);

    $value = $parts[1];

    return $value;
}

// $string = 'TF4327-ANALISIS DAN DESAIN SISTEM INFORMASI-B-3-2022';
// $value = extractSemesterValue($string);

// echo "Value: " . $value . "<br>";

function extractCode($str) {
  $parts = explode('-', $str);
  $code = $parts[0];
  return $code;
}

function isObeEval($ar,$search)
{

$filteredData = array_filter($ar, function($item) use ($search) {
    return strpos($item['name'], $search) !== false;
});

if (empty($filteredData))
{
    return $filteredData;
}
elseif (!empty($filteredData))
{
    return($filteredData); 
};

}




?>




</html>
