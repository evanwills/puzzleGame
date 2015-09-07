<?php

require_once(dirname(__FILE__).'/puzzleGame.abstract.class.php');

/**
 * @interface puzzleGame abstract factory method
 *
 */
class puzzleGameTriangle implements puzzleGameInterface {

	private $bridgePatterns = array(
		1 => array(
			array( 'bridges' => array( true  , false , false ) , 'mirror' => false )
		),
		2 => array(
			array( 'bridges' => array( true  , true  , false ) , 'mirror' => false )
		),
		3 => array(
			array( 'bridges' => array( true  , true  , true  ) , 'mirror' => false )
		)
	);


}



class puzzleGameSquares implements puzzleGameInterface {

	private $bridgePatterns = array(
		1 => array(
			array( 'bridges' => array( true  , false , false , false ) , 'mirror' => false )
		),
		2 => array(
			'a' => array( 'bridges' => array( true  , true  , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , false , true  , false ) , 'mirror' => false )
		),
		3 => array(
			array( 'bridges' => array( true  , true  , true  , false ) , 'mirror' => false )
		),
		4 => array(
			array( 'bridges' => array( true  , true  , true  , true  ) , 'mirror' => false )
		)
	);

}



class puzzleGameHexagon implements puzzleGameInterface {

	private $bridgePatterns = array(
		1 => array(
			array( 'key' => '1' , 'bridgeCount' => 1 , 'bridges' => array( true  , false , false , false , false , false ) , 'mirror' => false )
		),
		2 => array(
			'a' => array( 'bridges' => array( true  , true  , false , false , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , false , true  , false , false , false ) , 'mirror' => false ),
			'c' => array( 'bridges' => array( true  , false , false , true  , false , false ) , 'mirror' => false )
		),
		3 => array(
			'a' => array( 'bridges' => array( true  , true  , true  , false , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , true  , false , true  , false , false ) , 'mirror' => true  ),
			'd' => array( 'bridges' => array( true  , false , true  , false , true  , false ) , 'mirror' => false )
		),
		4 => array(
			'a' => array( 'bridges' => array( true  , true  , true  , true  , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , true  , true  , false , true  , false ) , 'mirror' => false ),
			'c' => array( 'bridges' => array( true  , true  , false , true  , true  , false ) , 'mirror' => false )
		),
		5 => array(
			array( 'bridges' => array( true  , true  , true  , true  , true  , false ) , 'mirror' => false )
		),
		6 => array(
			array( 'bridges' => array( true  , true  , true  , true  , true  , true  ) , 'mirror' => false )
		)
	);
}



class puzzleGameOctagon implements puzzleGameInterface {

	private $bridgePatterns = array(
		1 => array(
			array( 'bridges' => array( true  , false , false , false , false , false , false , false ) , 'mirror' => false )
		),
		2 => array(
			'a' => array( 'bridges' => array( true  , true  , false , false , false , false , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , false , true  , false , false , false , false , false ) , 'mirror' => false ),
			'c' => array( 'bridges' => array( true  , false , false , true  , false , false , false , false ) , 'mirror' => false ),
			'd' => array( 'bridges' => array( true  , false , false , false , true  , false , false , false ) , 'mirror' => false )
		),
		3 => array(
			'a' => array( 'bridges' => array( true  , true  , true  , false , false , false , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , true  , false , true  , false , false , false , false ) , 'mirror' => true  ),
			'c' => array( 'bridges' => array( true  , true  , false , false , true  , false , false , false ) , 'mirror' => true  ),
			'd' => array( 'bridges' => array( true  , false , true  , false , true  , false , false , false ) , 'mirror' => false ),
			'e' => array( 'bridges' => array( true  , false , true  , false , false , true  , false , false ) , 'mirror' => false ),
			'f' => array( 'bridges' => array( true  , false , true  , false , false , false , true  , false ) , 'mirror' => false )
		),
		4 => array(
			'a' => array( 'bridges' => array( true  , true  , true  , true  , false , false , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , true  , true  , false , true  , false , false , false ) , 'mirror' => true  ),
			'c' => array( 'bridges' => array( true  , true  , true  , false , false , true  , false , false ) , 'mirror' => false ),
			'd' => array( 'bridges' => array( true  , true  , false , true  , true  , false , false , false ) , 'mirror' => true  ),
			'e' => array( 'bridges' => array( true  , true  , false , true  , false , true  , false , false ) , 'mirror' => false ),
			'f' => array( 'bridges' => array( true  , true  , false , true  , false , false , true  , false ) , 'mirror' => false ),
			'g' => array( 'bridges' => array( true  , true  , false , false , true  , true  , false , false ) , 'mirror' => false ),
			'h' => array( 'bridges' => array( true  , false , true  , false , true  , false , true  , false ) , 'mirror' => false )
		),
		5 => array(

			'a' => array( 'bridges' => array( true  , true  , true  , true  , true  , false , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , true  , true  , true  , false , true  , false , false ) , 'mirror' => true  ),
			'c' => array( 'bridges' => array( true  , true  , true  , false , true  , true  , false , false ) , 'mirror' => true  ),
			'd' => array( 'bridges' => array( true  , true  , true  , false , true  , false , true  , false ) , 'mirror' => false ),
			'e' => array( 'bridges' => array( true  , true  , false , true  , true  , false , true  , false ) , 'mirror' => false ),
			'f' => array( 'bridges' => array( true  , false , true  , true  , true  , false , true  , false ) , 'mirror' => false )
		),
		6 => array(
			'a' => array( 'bridges' => array( true  , true  , true  , true  , true  , true  , false , false ) , 'mirror' => false ),
			'b' => array( 'bridges' => array( true  , true  , true  , true  , true  , false , true  , false ) , 'mirror' => false ),
			'c' => array( 'bridges' => array( true  , true  , true  , true  , false , true  , true  , false ) , 'mirror' => false ),
			'd' => array( 'bridges' => array( true  , true  , true  , false , true  , true  , true  , false ) , 'mirror' => false )
		),
		7 => array(
			array( 'bridges' => array( true  , true  , true  , true  , true  , true  , true  , false ) , 'mirror' => false )
		),
		8 => array(
			array( 'bridges' => array( true  , true  , true  , true  , true  , true  , true  , true  ) , 'mirror' => false )
	);

}
