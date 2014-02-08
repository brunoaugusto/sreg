<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "MG" (Minas Gerais)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_MG.html
 */
class MG {

    /**
     * Validates given "State Registration" against "Minas Gerais" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "Minas Gerais"
     *  Algorithm and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 13 );

        // Checking Length

        if( strlen( $number ) != 13 ) return FALSE;

        // Finding the First Check Digit

            // Algorithm Rule: An additional zero after first three characters

        $cd1 = substr_replace( $number, 0, 3, 0 );

        $sum = 0;

        for( $w = '121212121212', $c = 0; $c < 12; $c += 1 )
            $sum .= $w{ $c } * $cd1{ $c };

        $cd1 = ( 10 - ( array_sum( str_split( $sum ) ) % 10 ) );

        // Finding the Second Check Digit

            // Algorithm Rule: First 11 Digits followed by the First Check Digit

        $cd2 = substr( $number, 0, 11 ) . $cd1;

        $sum = 0;

        for( $w = array( 3, 2, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2 ), $c = 0; $c < 12; $c += 1 )
            $sum += $w{ $c } * $cd2{ $c };

        $modulus = ( $sum % 11 );

        $cd2 = ( $modulus != 0 || $modulus !=1 ? ( 11 - $modulus ) : 0 );

        // Checking if last two characters match both Check Digits

        return ( substr( $number, -2 ) == $cd1 . $cd2 );
    }
}