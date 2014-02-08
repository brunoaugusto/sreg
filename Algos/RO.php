<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "RO" (Rondônia)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_RO.html
 */
class RO {

    /**
     * Validates given "State Registration" against "Rondônia" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "Rondônia" Algorithm
     *  and FALSE otherwise
     */
    public static function validate( $number ) {

        /**
         * "Rondônia" has two different Algorithms based on "State Registration"
         * length.
         */
        if( ! self::after2k( $number ) ) {

            return self::before2k( $number );
        }

        return TRUE;
    }

    // Auxiliary Methods

    /**
     * Validates given "State Registration" according to algorithm for
     * used before January, 8th 2000
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to algorithm
     *  used before January, 8th 2000 and FALSE otherwise
     */
    private static function before2k( $number ) {

        $number = substr( $number, 0, 9 );

        // Checking Length

        if( strlen( $number ) != 9 ) return FALSE;

        // Finding the First Check Digit

        $sum = 0;

        for( $w = '65432', $i = 0, $c = 3; $i < 5, $c < 8; $i += 1, $c += 1 )
            $sum += $number{ $c } * $w{ $i };

        $cd = 11 - ( $sum % 11 );

        $cd = ( $cd == 10 || $cd == 11 ? $cd - 10 : $cd );

        return ( $number{ 8 } == $cd );
    }

    /**
     * Validates given "State Registration" according to algorithm for
     * used after January, 8th 2000
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to algorithm
     *  used before January, 8th 2000 and FALSE otherwise
     */
    private static function after2k( $number ) {

        // Checking Length

        if( strlen( $number ) != 14 ) return FALSE;

        $sum = 0;

        for( $w = '6543298765432', $c = 0; $c < 13; $c += 1 )
            $sum += $number{ $c } * $w{ $c };

        $cd = ( 11 - ( $sum % 11 ) );

        $cd = ( $cd == 10 || $cd == 11 ? $cd - 10 : $cd );

        return ( $number{ 13 } == $cd );
    }
}