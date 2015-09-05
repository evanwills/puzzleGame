<?php

require_once(dirname(__FILE__).'/puzzleGame.interface.php');
require_once(dirname(__FILE__).'/puzzleGame.abstract.class.php');


/**
 *
 */
class trianglePuzzlePiece extends abstractPuzzlePiece
{
	private static $bridgePatterns = array(
		array( 'key' => '0' , 'bridgeCount' => 0 , 'bridges' => array( false , false , false )),
		array( 'key' => '1' , 'bridgeCount' => 1 , 'bridges' => array( true  , false , false )),
		array( 'key' => '2' , 'bridgeCount' => 2 , 'bridges' => array( true  , true  , false )),
		array( 'key' => 'X' , 'bridgeCount' => 3 , 'bridges' => array( true  , true  , true  ))
	);

	protected $neighbours = array( null , null , null );

	protected $faceCount = 3;

	protected $shape = 'triangle';
}



/**
 *
 */
class squarePuzzlePiece extends abstractPuzzlePiece
{
	private static $bridgePatterns = array(
		array( 'key' => '0' , 'bridgeCount' => 0 , 'bridges' => array( false , false , false , false )),
		array( 'key' => '1' , 'bridgeCount' => 1 , 'bridges' => array( true  , false , false , false )),
		array( 'key' => '2a', 'bridgeCount' => 2 , 'bridges' => array( true  , true  , false , false )),
		array( 'key' => '2b', 'bridgeCount' => 2 , 'bridges' => array( true  , false , true  , false )),
		array( 'key' => '3' , 'bridgeCount' => 3 , 'bridges' => array( true  , true  , true  , false )),
		array( 'key' => 'X' , 'bridgeCount' => 4 , 'bridges' => array( true  , true  , true  , true  ))
	);

	protected $neighbours = array( null , null , null , null );

	protected $faceCount = 4;

	protected $shape = 'square';
}



/**
 *
 */
class hexagonPuzzlePiece extends abstractPuzzlePiece
{
	private static $bridgePatterns = array(
		array( 'key' => '0' , 'bridgeCount' => 0 , 'bridges' => array( false , false , false , false , false , false )),
		array( 'key' => '1' , 'bridgeCount' => 1 , 'bridges' => array( true  , false , false , false , false , false )),

		array( 'key' => '2a', 'bridgeCount' => 2 , 'bridges' => array( true  , true  , false , false , false , false )),
		array( 'key' => '2b', 'bridgeCount' => 2 , 'bridges' => array( true  , false , true  , false , false , false )),
		array( 'key' => '2c', 'bridgeCount' => 2 , 'bridges' => array( true  , false , false , true  , false , false )),

		array( 'key' => '3a', 'bridgeCount' => 3 , 'bridges' => array( true  , true  , true  , false , false , false )),
		array( 'key' => '3b', 'bridgeCount' => 3 , 'bridges' => array( true  , true  , false , true  , false , false )),
		array( 'key' => '3c', 'bridgeCount' => 3 , 'bridges' => array( true  , true  , false , false , true  , false )),
		array( 'key' => '3d', 'bridgeCount' => 3 , 'bridges' => array( true  , false , true  , false , true  , false )),

		array( 'key' => '4a', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , true  , true  , false , false )),
		array( 'key' => '4b', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , true  , false , true  , false )),
		array( 'key' => '4c', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , false , true  , true  , false )),

		array( 'key' => '5' , 'bridgeCount' => 5 , 'bridges' => array( true  , true  , true  , true  , true  , false )),
		array( 'key' => 'X' , 'bridgeCount' => 6 , 'bridges' => array( true  , true  , true  , true  , true  , true  ))
	);

	protected $neighbours = array( null , null , null , null , null , null );

	protected $faceCount = 6;

	protected $shape = 'hexagon';
}



/**
 *
 */
class octagonPuzzlePiece extends abstractPuzzlePiece
{
	private static $bridgePatterns = array(
		array( 'key' => '0' , 'bridgeCount' => 0 , 'bridges' => array( false , false , false , false , false , false , false , false ) , 'mirror' => false ),
		array( 'key' => '1' , 'bridgeCount' => 1 , 'bridges' => array( true  , false , false , false , false , false , false , false ) , 'mirror' => false ),

		array( 'key' => '2a', 'bridgeCount' => 2 , 'bridges' => array( true  , true  , false , false , false , false , false , false ) , 'mirror' => false ),
		array( 'key' => '2b', 'bridgeCount' => 2 , 'bridges' => array( true  , false , true  , false , false , false , false , false ) , 'mirror' => false ),
		array( 'key' => '2c', 'bridgeCount' => 2 , 'bridges' => array( true  , false , false , true  , false , false , false , false ) , 'mirror' => false ),
		array( 'key' => '2d', 'bridgeCount' => 2 , 'bridges' => array( true  , false , false , false , true  , false , false , false ) , 'mirror' => false ),

		array( 'key' => '3a', 'bridgeCount' => 3 , 'bridges' => array( true  , true  , true  , false , false , false , false , false ) , 'mirror' => false ),
		array( 'key' => '3b', 'bridgeCount' => 3 , 'bridges' => array( true  , true  , false , true  , false , false , false , false ) , 'mirror' => '3e'  ),
		array( 'key' => '3c', 'bridgeCount' => 3 , 'bridges' => array( true  , true  , false , false , true  , false , false , false ) , 'mirror' => '3d'  ),
		array( 'key' => '3d', 'bridgeCount' => 3 , 'bridges' => array( true  , true  , false , false , false , true  , false , false ) , 'mirror' => '3c'  ),
		array( 'key' => '3e', 'bridgeCount' => 3 , 'bridges' => array( true  , true  , false , false , false , false , true  , false ) , 'mirror' => '3b'  ),
		array( 'key' => '3f', 'bridgeCount' => 3 , 'bridges' => array( true  , false , true  , false , true  , false , false , false ) , 'mirror' => false ),
		array( 'key' => '3g', 'bridgeCount' => 3 , 'bridges' => array( true  , false , true  , false , false , true  , false , false ) , 'mirror' => false ),
		array( 'key' => '3h', 'bridgeCount' => 3 , 'bridges' => array( true  , false , true  , false , false , false , true  , false ) , 'mirror' => false ),

		array( 'key' => '4a', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , true  , true  , false , false , false , false ) , 'mirror' => false ),
		array( 'key' => '4b', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , true  , false , true  , false , false , false ) , 'mirror' => '4d'  ),
		array( 'key' => '4c', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , true  , false , false , true  , false , false ) , 'mirror' => false ),
		array( 'key' => '4d', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , true  , false , false , false , true  , false ) , 'mirror' => '4b'  ),
		array( 'key' => '4e', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , false , true  , true  , false , false , false ) , 'mirror' => '4f'  ),
		array( 'key' => '4f', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , false , false , false , true  , true  , false ) , 'mirror' => '4e'  ),
		array( 'key' => '4g', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , false , true  , false , true  , false , false ) , 'mirror' => false ),
		array( 'key' => '4h', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , false , true  , false , false , true  , false ) , 'mirror' => false ),
		array( 'key' => '4i', 'bridgeCount' => 4 , 'bridges' => array( true  , true  , false , false , true  , true  , false , false ) , 'mirror' => false ),
		array( 'key' => '4j', 'bridgeCount' => 4 , 'bridges' => array( true  , false , true  , false , true  , false , true  , false ) , 'mirror' => false ),

		array( 'key' => '5a', 'bridgeCount' => 5 , 'bridges' => array( true  , true  , true  , true  , true  , false , false , false ) , 'mirror' => false ),
		array( 'key' => '5b', 'bridgeCount' => 5 , 'bridges' => array( true  , true  , true  , true  , false , true  , false , false ) , 'mirror' => '5e'  ),
		array( 'key' => '5c', 'bridgeCount' => 5 , 'bridges' => array( true  , true  , true  , false , true  , true  , false , false ) , 'mirror' => '5d'  ),
		array( 'key' => '5d', 'bridgeCount' => 5 , 'bridges' => array( true  , true  , false , true  , true  , true  , false , false ) , 'mirror' => '5c'  ),
		array( 'key' => '5d', 'bridgeCount' => 5 , 'bridges' => array( true  , false , true  , true  , true  , true  , false , false ) , 'mirror' => '5b'  ),
		array( 'key' => '5e', 'bridgeCount' => 5 , 'bridges' => array( true  , true  , true  , false , true  , false , true  , false ) , 'mirror' => false ),
		array( 'key' => '5f', 'bridgeCount' => 5 , 'bridges' => array( true  , true  , false , true  , true  , false , true  , false ) , 'mirror' => false ),
		array( 'key' => '5g', 'bridgeCount' => 5 , 'bridges' => array( true  , false , true  , true  , true  , false , true  , false ) , 'mirror' => false ),

		array( 'key' => '6a', 'bridgeCount' => 6 , 'bridges' => array( true  , true  , true  , true  , true  , true  , false , false ) , 'mirror' => false ),
		array( 'key' => '6b', 'bridgeCount' => 6 , 'bridges' => array( true  , true  , true  , true  , true  , false , true  , false ) , 'mirror' => false ),
		array( 'key' => '6c', 'bridgeCount' => 6 , 'bridges' => array( true  , true  , true  , true  , false , true  , true  , false ) , 'mirror' => false ),
		array( 'key' => '6d', 'bridgeCount' => 6 , 'bridges' => array( true  , true  , true  , false , true  , true  , true  , false ) , 'mirror' => false ),

		array( 'key' => '7' , 'bridgeCount' => 7 , 'bridges' => array( true  , true  , true  , true  , true  , true  , true  , false ) , 'mirror' => false ),
		array( 'key' => 'X' , 'bridgeCount' => 8 , 'bridges' => array( true  , true  , true  , true  , true  , true  , true  , true  ) , 'mirror' => false )
	);

	protected $neighbours = array( null , null , null , null , null , null , null , null );

	protected $faceCount = 8;

	protected $shape = 'octagon';
}

