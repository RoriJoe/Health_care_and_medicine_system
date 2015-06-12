<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
function dateConversion ($date) {
    $mydate = DateTime::createFromFormat('d-m-Y', $date); 
    return $mydate->format('Y-m-d');
} 

function checkIfEmpty ($data, $home) {
    if ($data == null) {
        redirect ($home, 'refresh');
    }
}

function diffInMonths(DateTime $date1, DateTime $date2)
{
    $diff =  $date1->diff($date2);

    $months = $diff->y * 12 + $diff->m + $diff->d / 30;

    return (int) round($months);
}

function in_array_field($needle, $needle_field, $haystack, $strict = false) {
	if ($strict) {
		foreach ($haystack as $item)
			if (isset($item->$needle_field) && $item->$needle_field === $needle)
				return true;
	}
	else {
		foreach ($haystack as $item)
			if (isset($item->$needle_field) && $item->$needle_field == $needle)
				return true;
	}
	return false;
}

function invenDescSort($item1,$item2)
{
    if ($item1['JUMLAH_OBAT_SEKARANG'] == $item2['JUMLAH_OBAT_SEKARANG']) return 0;
    return ($item1['JUMLAH_OBAT_SEKARANG'] > $item2['JUMLAH_OBAT_SEKARANG']) ? 1 : -1;
}