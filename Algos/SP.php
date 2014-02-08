<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "SP" (São Paulo)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_SP.html
 */
class SP {

    /**
     * Validates given "State Registration" against "São Paulo" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "São Paulo" Algorithm
     *  and FALSE otherwise
     */
    public static function validate( $number ) {

        /**
         * "São Paulo" has two different Algorithms based on "State Registration"
         * length.
         */
        if( ! self::industryCommerce( $number ) ) {

            return self::ruralProducer( $number );
        }

        return TRUE;
    }

    // Auxiliary Methods

    /**
     * Validates given "State Registration" according to algorithm
     * for Rural Producers
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to algorithm for
     *  Rural Producers and FALSE otherwise
     */
    private static function ruralProducer( $number ) {

        $number = substr( $number, 0, 13 );

        // Checking Length

        if( strlen( $number ) != 13 ) return FALSE;

        $number = strtoupper( $number );

        /**
         * Algorithm Rules: "State Registrations" for Rural Producers
         * must start with "P0"
         */
        if( substr( $number, 0, 2 ) != 'P0' ) return FALSE;

        // Removing the unneeded letter

        $number = str_replace( 'P', '', $number );

        // Finding the First Check Digit

        $sum = 0;

        for( $w = '1345678', $c = 0, $i = 0; $c < 8, $i < 7; $c += 1, $i += 1 )
            $sum += $w{ $i } * $number{ $c };

        // Adding the 8th weight

        $sum += ( 10 * $number{ 7 } );

        $cd = substr( ( $sum % 11 ), -1 );

        return ( $number{ 8 } == $cd );
    }

    /**
     * Validates given "State Registration" according to algorithm for
     * Industries and Commerce
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to algorithm for
     *  Industries and Commerce, and FALSE otherwise
     */
    private static function industryCommerce( $number ) {

        $number = substr( $number, 0, 12 );

        // Checking Length

        if( strlen( $number ) != 12 ) return FALSE;

        // Finding the First Check Digit (9th Digit)

        $sum = 0;

        for( $w = '1345678', $c = 0; $c < 7; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        // Adding the 8th weight

        $sum += 10 * $number{ 7 };

        $cd1 = substr( ( $sum % 11 ), -1 );

        // Finding the Second Check Digit (12th Digit)

        $sum = 0;

        // Because the 3rd weight, the two first weights are outside the loop

        $sum +=  3 * $number{ 0 };
        $sum +=  2 * $number{ 1 };
        $sum += 10 * $number{ 2 };

        for( $w = '98765432', $c = 3, $i = 0; $c < 8, $i < 8; $c += 1, $i += 1 )
            $sum += $w{ $i } * $number{ $c };

        $cd2 = substr( ( $sum % 11 ), -1 );

        return ( $number{ 8 } == $cd1 && $number{11} == $cd2 );
    }
}