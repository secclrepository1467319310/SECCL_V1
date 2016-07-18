<?php

class Norma {

    function restaFechas($dFecIni, $dFecFin) {
            $dFecIni = str_replace("-", "", $dFecIni);
            $dFecIni = str_replace("/", "", $dFecIni);
            $dFecFin = str_replace("-", "", $dFecFin);
            $dFecFin = str_replace("/", "", $dFecFin);

            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
            ereg("([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

            $date1 = mktime(0, 0, 0, $aFecIni[2], $aFecIni[1], $aFecIni[3]);
            $date2 = mktime(0, 0, 0, $aFecFin[2], $aFecFin[1], $aFecFin[3]);

            return round(($date2 - $date1) / (60 * 60 * 24));
        }
}

?>
