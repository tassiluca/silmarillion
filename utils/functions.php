function getIdFromName($name){
    return preg_replace("/[^a-z]/", '', strtolower($name));
}