<?php

namespace Algos;

/**
 * Brazilian "State Registration" Algorithm for State "GO" (Goiás)
 *
 * @author Bruno Augusto <magnusthorek@gmail.com>
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 *
 * @see http://www.sintegra.gov.br/Cad_Estados/cad_GO.html
 */
class GO {

    /**
     * Validates given "State Registration" against "Goiás" Algorithm
     *
     * @param string|integer $number
     *  Given "State Registration" to be validated
     *
     * @return bool
     *  TRUE if given "State Registration" is valid according to "Goiás" Algorithm
     *  and FALSE otherwise
     */
    public static function validate( $number ) {

        $number = substr( $number, 0, 9 );

        // Checking Length

        if( strlen( $number ) != 9 ) return FALSE;

        // Algorithm Rule: First two digits must be 10, 15 or 20

        if( ! in_array( substr( $number, 0, 2 ), array( '10', '15', '20' ) ) )
            return FALSE;

        $sum = 0;

        for( $w = '98765432', $c = 0; $c < 8; $c += 1 )
            $sum += $w{ $c } * $number{ $c };

        $m = ( $sum % 11 );

        // Algorithm Rule: Check Digit varies according to the first 8 digits

        $substring = substr( $number, 0, 8 );

        /**
         * Algorithm Rule: If first 8 Digits are 11094402, two Check Digits are valid
         *
         * This smells like a workaround :p
         */
        if( $substring == '11094402' ) {

            return ( $number{8} == 0 || $number{8} == 1 );

        } else {

            switch( $m ) {

                case 0: $cd = 0; break;

                case 1:

                    if( $substring >= '10103105' && $substring <= '10119997' ) {
                        $cd = 1;
                    } else {
                        $cd = 0;
                    }

                break;

                default: $cd = ( 11 - $m ); break;
            }
        }

        // Checking if last character match the Check Digit

        return ( $number{ 8 } == $cd );
    }
}