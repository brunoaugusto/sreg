<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "TO" (Tocatints)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_TO.html
 */
class TO {

    /**
     * Validates given "State Registration" against "Tocatints" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to
     *  "Tocatints" Algorithm and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 11 );

        // Checking Length

        if( strlen( $number ) != 11 ) return FALSE;

        /**
         * Algorithm Rule: Third and Fourth Digits must be one of the following:
         *
         * 01 => Rural Producers
         * 02 => Industry and Commerce
         * 03 => Crude/Rudimentary Companies
         * 99 => Inactive/Suspended Companies with old Registrations
         */
        if( ! in_array( substr( $number, 2, 2 ), array( '01', '02', '03', '99' ) ) )
            return FALSE;

        // Finding the Check Digit

        $sum = 0;

        // Adding first two weight outside the loop

        $sum += ( $number{ 0 } * 9 );
        $sum += ( $number{ 1 } * 8 );

        for( $w = '765432', $c = 4, $i = 0; $c < 9, $i < 6; $c += 1, $i += 1 )
            $sum += $w{ $i } * $number{ $c };

        $cd = ( $sum % 11 );

        $cd = ( $cd >= 2 ? ( 11 - $cd ) : 0 );

        // Checking if last character match the Check Digit

        return ( $number{ 10 } == $cd );
    }
}