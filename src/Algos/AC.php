<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "AC" (Acre)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_AC.html
 */
class AC {

    /**
     * Validates given "State Registration" against "Acre" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "Acre"
     *  Algorithm and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 13 );

        // Checking Length

        if( strlen( $number ) != 13 ) return FALSE;

        // Algorithm Rule: First two digits must be 01

        if( substr( $number, 0, 2 != "01" ) ) return FALSE;

        // Finding the First Check Digit

        $sum = 0;

        for( $w = '43298765432', $c = 0; $c < 11; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $cd1 = ( 11 - ( $sum % 11 ) );

        $cd1 = ( $cd1 == 10 || $cd1 == 11 ? 0 : $cd1 );

        // Finding the Second Check Digit

        $sum = 0;

        for( $w = '543298765432', $c = 0; $c < 12; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $cd2 = ( 11 - ( $sum % 11 ) );

        $cd2 = ( $cd2 == 10 || $cd2 == 11 ? 0 : $cd2 );

        // Checking if last two characters match both Check Digits

        return ( substr( $number, -2 ) == $cd1 . $cd2 );
    }
}