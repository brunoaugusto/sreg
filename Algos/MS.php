<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "MS" (Mato Grosso do Sul)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_MS.html
 */
class MS {

    /**
     * Validates given "State Registration" against "Mato Grosso do Sul" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to
     *  "Mato Grosso do Sul" Algorithm and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 9 );

        // Checking Length

        if( strlen( $number ) != 9 ) return FALSE;

        // Algorithm Rule: First two digits must be 28

        if( substr( $number, 0, 2 ) != '28' ) return FALSE;

        // Finding the Check Digit

        $sum = 0;

        for( $w = '98765432', $c = 0; $c < 8; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $m  = ( $sum % 11 );

        if( $m == 0 ) {

            $cd = 0;

        } else {

            $cd = ( ( 11 - $m ) > 9 ? 0 : ( 11 - $m ) );
        }

        // Checking if last character match the Check Digit

        return ( $number{ 8 } == $cd );
    }
}