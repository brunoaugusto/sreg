<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "RN" (Rio Grande do Norte)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_RN.html
 */
class RN {

    /**
     * Validates given "State Registration" against "Rio Grande do Norte" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to
     * "Rio Grande do Norte" Algorithm and FALSE otherwise
     */
    public static function validate( $number ) {

        /**
         * "Rio Grande do Norte" has two different Algorithms based on
         * "State Registration" length.
         */
        if( ! self::tenDigits( $number ) ) {

            return self::nineDigits( $number );
        }

        return TRUE;
    }

    // Auxiliary Methods

    /**
     * Validates given "State Registration" according to algorithm for
     * nine digits numbers
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to algorithm for
     *  nine digits number and FALSE otherwise
     */
    private static function nineDigits( $number ) {

        $number = substr( $number, 0, 9 );

        // Checking Length

        if( strlen( $number ) != 9 ) return FALSE;

        // Algorithm Rule: First two digits must be 20

        if( substr( $number, 0, 2 ) != 20 ) return FALSE;

        // Finding the Check Digit

        $sum = 0;

        for( $w = '98765432', $c = 0; $c < 7; $c += 1 )
            $sum += $number{ $c } * $w{ $c };

        $cd = ( ( $sum * 10 ) % 11 );

        $cd = ( $cd == 10 ? 0 : $cd );

        return ( $number{ 8 } == $cd );
    }

    /**
     * Validates given "State Registration" according to algorithm for
     * ten digits numbers
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to algorithm for
     *  ten digits number and FALSE otherwise
     */
    private static function tenDigits( $number ) {

        $number = substr( $number, 0, 10 );

        // Checking Length

        if( strlen( $number ) != 10 ) return FALSE;

        // Algorithm Rule: First two digits must be 20

        if( substr( $number, 0, 2 ) != 20 ) return FALSE;

        // Finding the Check Digit

        $sum = 0;

        $sum += $number{ 0 } * 10;

        for( $w = '98765432', $c = 1, $i = 0; $c < 8, $i < 7; $c += 1, $i += 1 )
            $sum += $number{ $c } * $w{ $i };

        $cd = ( ( $sum * 10 ) % 11 );

        $cd = ( $cd == 10 ? 0 : $cd );

        return ( $number{ 9 } == $cd );
    }
}