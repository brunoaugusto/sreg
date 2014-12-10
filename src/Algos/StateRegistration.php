<?php

namespace Algos;

/**
 * Validates Brazilian "State Registration" Algorithm
 *
 * Brazilian "State Registration" is the registration of taxpayer
 * in Brazilian IRS equivalent records, which legalizes a business company
 * wherever it is established
 *
 * "ICMS" refers to Brazilian tax on the circulation of goods and
 * interstate/intercity transportation services
 *
 * Example:
 *
 * <code>
 * $sr = new StateRegistration( 'XX12345678' );
 *
 * echo ( $sr -> isValid() ? 'Valid' : 'Invalid' );
 * </code>
 *
 * Every "State Registration" has its own algorithm but, in general,
 * a valid "State Registration" must be between 8 and 14 characters long,
 * being the first two characters the abbreviation of State
 *
 * @author Bruno Augusto <magnusthorek.at.gmail.dot.com>
 *
 * @copyright Copyright (c) 2010-2014 Next Studios
 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
 */
class StateRegistration {

	/**
	 * Federative Unit
	 *
	 * @var string $state
	 */
	private $state;

	/**
	 * State Registration Number
	 *
	 * @var integer $number
	 */
	private $number;

	/**
	 * "State Registration" Validator Constructor
	 *
	 * @param string $sr
	 *  Given "State Registration" to be validated
	 *
	 * @throws Exception
	 *
	 *   Thrown if:
	 *   - The "Federative Unit" found in "State Registration" is not valid
	 *     as a Brazilian Federative Unit
	 *
	 *   - Matching a "State Registration" number do not results in a number
	 *     (mostly because the "Federative Unit" failed too)
	 */
	public function __construct( $sr ) {

		$sr = sprintf( '%-016s', preg_replace( '/\W/', '', trim( $sr ) ) );

		preg_match( '/([A-Za-z]{2})\s*(P?[0-9]+)/', $sr, $matches );

		list( , $state, $number ) = $matches + array( NULL, NULL, NULL );

		$state = strtoupper( $state );

		if( $this -> validateBrazilianFederativeUnits( $state ) === FALSE ) {

			throw new \Exception(

				sprintf(

					'%s does not match any Brazilian Federative Unit', $state
				)
			);
		}

		if( is_null( $number ) ) {

			throw new \Exception( 'Invalid or mal-formed State Registration Number' );
		}

		$this -> state =& $state;
		$this -> number =& $number;
	}

	/**
	 * Validates Brazilian "State Registration" by triggering match
	 * state algorithm validator
	 *
	 * @return bool
	 *  TRUE if given "State Registration" is valid and FALSE otherwise
	 */
	public function isValid() {

		$validator = sprintf( 'Algos\%s', $this -> state );

		if( ! class_exists( $validator ) ) {

			throw new \Exception(

				sprintf( 'No validator class found for state %s', $this -> state )
			);
		}

		return $validator::validate( $this -> number );
	}

	// Auxiliary Methods

	/**
	 * Validates a Brazilian "Fedarative Unit"
	 *
	 * Example:
	 * <code>
	 * echo ( uf( 'SP' ) ? 'Valid' : 'Invalid' );
	 * </code>
	 *
	 * @author Paulo Ricardo F. Santos <v1d4l0k4.at.gmail.dot.com> (original)
	 * @author Bruno Augusto <magnusthorek.at.gmail.dot.com> (improved)
	 *
	 * @copyright Copyright (c) 2010-2014 Next Studios
	 * @license http://creativecommons.org/licenses/by/3.0/   Attribution 3.0 Unported
	 *
	 * @param string $state
	 *  Given "Federative Unit" to be validated
	 *
	 * @return bool
	 *  TRUE if given "Federative Unit" is valid and FALSE otherwise
	 */
	private function validateBrazilianFederativeUnits( $state ) {

		return preg_match(

					'/^A[CLMP]|BA|CE|DF|ES|[GT]O|M[AGST]|P[ABEIR]|R[JNORS]|S[CEP]$/',

					strtoupper( $state )
				);
	}
}