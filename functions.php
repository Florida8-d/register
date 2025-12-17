<?php
function applyFilters(&$query, $filters)
{
    if (!empty($filters['strings'])) {
        foreach ($filters['strings'] as $key => $value) {
            $value = trim($value);
            if (!$value) {
                continue;
            }

            $query .= " and " . $key . "='" . $value . "'";
        }
    }

    if (!empty($filters['dates'])) {
        foreach ($filters['dates'] as $key => $value) {
            $value = trim($value);
            $tempVal = explode(" - ", $value);
            if (sizeof($tempVal) != 2) {
                continue;
            }

            $query .= " and " . $key . ">='" . $tempVal[0] . "' and " . $key . "<='" . $tempVal[1] . "'";
        }
    }

    if (!empty($filters['datetimes'])) {
        foreach ($filters['datetimes'] as $key => $value) {
            $value = trim($value);
            $tempVal = explode(" - ", $value);
            if (sizeof($tempVal) != 2) {
                continue;
            }

            $query .= " and " . $key . ">='" . $tempVal[0] . " 00:00:01' and " . $key . "<='" . $tempVal[1] . "' 23:59:59";
        }
    }
}

function trimArrayParams(&$array) {
    foreach ($array as $key => $value) {
        $array[$key] = trim($value);
    }
}

function validatePassword($password, $confirmation = null) {
    $message = null;
    if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)){
        $message = "Password must be more than 8 chars and have at least one character and one number.";
    }

     else if (!$message && $confirmation && $password != $confirmation) {
        $message = "Password doesnt match!";
    }

    $status = $message ? false : true;

    return ['status' => $status, 'message' => $message];
}

function random(){
  return  random_int(100000, 999999);
}


