<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "AP" (Amapá)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_AP.html
 */
class AP {

    /**
     * Validates given "State Registration" against "Amapá" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to
     *  "Amapá" Algorithm and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 9 );

        // Checking Length

        if( strlen( $number ) != 9 ) return FALSE;

        // Algorithm Rule: First two digits must be 03

        if( substr( $number, 0, 2 != "03" ) ) return FALSE;

        // Finding the Check Digit

            // Algorithm Rule: Define arbitrary values according to registration number range

        $p = $d = 0;

        if( substr( $number, 1, 7 ) >= '03000001' && substr( $number, 1, 7 ) <= '03017000' ) {

            $p = 5;

        } elseif( substr( $number, 1, 7 ) >= '3017001' && substr( $number, 1, 7 ) <= '3019022' ) {

            $p = 9; $d = 1;
        }

        // Finding the Check Digit

        $sum = 0;

        for( $w = '98765432', $c = 0; $c < 8; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        // Adding the arbitrary values

        $sum = ( $p + $sum );

        $cd = ( 11 - ( $sum % 11 ) );

        $cd = ( $cd == 10 ? 0 : $cd );

        // Checking if last character match the Check Digit

        return ( $number{ 8 } == $cd );
    }
}