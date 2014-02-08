<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "PE" (Pernambuco)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_PE.html
 */
class PE {

    /**
     * Validates given "State Registration" against "Pernambuco" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "Pernambuco" Algorithm
     *  and FALSE otherwise
     */
    public static function validate( $number ) {

        /**
         * "Pernambuco" has two different Algorithms based on "State Registration"
         * length.
         */
        if( ! self::cacepe( $number ) ) {

            return self::eFisco( $number );
        }

        return TRUE;
    }

    // Auxiliary Methods

    /**
     * Validates given "State Registration" according to eFisco rules
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "eFisco" Algorithm
     *  and FALSE otherwise
     */
    private static function eFisco( $number ) {

        $number = substr( $number, 0, 9 );

        // Checking Length

        if( strlen( $number ) != 9 ) return FALSE;

        // Finding the First Check Digit

        $sum = 0;

        for( $w = '8765432', $c = 0; $c < 7; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $cd1 = ( $sum % 11 );

        $cd1 = ( $cd1 == 0 || $cd1 == 1 ? 0 :( 11 - $cd1 ) );

        // Finding the Second Check Digit

        $substring = substr( $number, 0, 7 ) . $cd1;

        $sum    =    0;

        for( $w = '98765432', $c = 0; $c < 8; $c += 1 )
            $sum += $w{ $c } * $substring{ $c };

        $cd2 = ( $sum % 11 );

        $cd2 = ( $cd2 == 1 || $cd2 == 0 ? 0 : ( 11 - $cd2 ) );

        return ( substr( $number, -2 ) == $cd1 . $cd2 );
    }

    /**
     * Validates given "State Registration" according to "CACEPE"
     * ("Cadastro de Contribuintes do Estado de Pernambuco") rules
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "CACEPE" Algorithm
     *  and FALSE otherwise
     */
    private static function cacepe( $number ) {

        // Checking Length

        if( strlen( $number ) != 14 ) return FALSE;

        $sum = 0;

        for( $w = '5432198765432', $c = 0; $c < 13; $c += )
            $sum += $w{ $c } * $number{ $c };

        // Finding the Check Digit

        $cd = ( $sum % 11 );

        $cd = ( ( 11 - $cd ) > 9 ? ( 11 - $cd ) - 10 : ( 11 - $cd ) );

        return ( $number{ 13 } == $cd );
    }
}