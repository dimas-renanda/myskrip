
<?php 
require_once "../conf/safety.php";

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
    return NULL;
}
elseif (!empty($filteredData))
{
    return($filteredData); 
};

}




?>




</html>
