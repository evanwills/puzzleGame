
function PuzzlePiece(pieceObj, tmpMirrorObj) {
	'use strict';
	var orientation = 0,
		bridges = [],
		bridgeCount = 0,
		faceCount = 0,
		shape = '',
		code = '',
		oppositeFaces = [],
		mirrored = false,
		mirrorObj = null,

		a = 0,
		b = 0,
		half = 0;

	if (!PuzzlePiecePattern.isPrototypeOf(pieceObj)) {
		throw 'PuzzlePiece constructor expects first parameter \'piece\' to be have \'PuzzlePiecePattern\' as it\' prototype. ' + typeof (pieceObj) + ' given.';
	}
	if (!PuzzlePieceMirror.isPrototypeOf(mirrorObj)) {
		throw 'PuzzlePiece constructor expects second parameter \'mirror\' to be have \'PuzzlePieceMirror\' as it\' prototype. ' + typeof (mirrorObj) + ' given.';
	}
	bridges = pieceObj.getBridges();
	bridgeCount = pieceObj.getBridgeCount();
	faceCount = pieceObj.getFaceCount();
	code = pieceObj.getCode();
	mirrored = pieceObj.isMirrored();
	shape = pieceObj.getShape();
	mirrorObj = tmpMirrorObj;

	half = faceCount / 2;
	for (a = 0; a < faceCount; a += 1) {
		if (a < half) {
			b = a + half;
		} else {
			b = half - a;
		}
		oppositeFaces.push(b);
	}

// ========================================================
// START: protected functions

	function incrementOrientation() {
		if (orientation === faceCount - 1) {
			orientation = 0;
		} else {
			orientation += 1;
		}
	}

	function decrementOrientation() {
		if (orientation === 0) {
			orientation = faceCount - 1;
		} else {
			orientation -= 1;
		}
	}

// END: protected functions
// ========================================================
// START: public functions

//	Object.defineProperty(this, 'Bridges' , {
//		get: function () { return bridges; },
//		set: function () { }
//	});

	this.getBridges = function () { return bridges; };

	this.getCode = function () { return code; };

	this.getID = function () { return shape.substring(0, 3) + bridgeCount + code; };

	this.getPieceType = function () { return 'PuzzlePiece'; };

	this.getShape = function () { return shape; };

	this.getOppositeFace = function (inputFace, inputFaceCount) {
		var originalFace = inputFace;
		if (inputFace === parseInt(inputFace, 10) && inputFace >= 0 && inputFaceCount === parseInt(inputFaceCount, 10) && inputFaceCount >= 0) {
			if (faceCount !== inputFaceCount) {
				if ((faceCount / 2) === inputFaceCount) {
					inputFace *= 2;
				} else if ((faceCount * 2) === inputFaceCount) {
					inputFace /= 2;
				} else {
					throw 'PuzzlePiece.getOppositeFace() cannot handle neighbours with ' + inputFaceCount + ' faces';
				}
			}
			if (inputFace < faceCount) {
				half = Math.floor(faceCount / 2);
				if (inputFace > half) {
					inputFace -= half;
				} else if (inputFace < half) {
					inputFace += half;
				} else {
					throw 'puzzlePiece::getOppositeFace() cannot find the neighbour for ' + originalFace;
				}
				return inputFace;
			} else {
				throw 'puzzlePiece::getOppositeFace() expects first parameter $face to be between 0 and ' + faceCount + '. ' + inputFace + ' (translated from ' + originalFace + ') given.';
			}
		} else {
			if (typeof (inputFace) !== 'number') {
				throw 'PuzzlePiece.getOppositeFace() expects first parameter \'tmpFace\' to be an number. ' + typeof (inputFace) + ' given.';
			}
			if (typeof (inputFaceCount) !== 'number') {
				throw 'PuzzlePiece.getOppositeFace() expects second parameter \'tmpFaceCount\' to be an integer. ' + typeof (inputFaceCount) + ' given.';
			}
		}
	};

	this.getOrientation = function () { return orientation; };

	this.hasBridge = function (inputFace, inputFaceCount) {
		try {
			inputFace = this.getOppositeFace(inputFace, inputFaceCount);
		} catch (e) {
			console.error(e);//str_replace('getOppositeFace','hasBridge'.$e->getMessage()));
		}
		return bridges[inputFace];
	};

	this.rotate = function (inputSteps) {
		var end = faceCount - 1,
			old = null;
		if (inputSteps === undefined) {
			inputSteps = 1;
		}
		if (inputSteps === parseInt(inputSteps, 10) && inputSteps > 0) {
			for (a = 0; a < inputSteps; a += 1) {
				incrementOrientation();
				old = bridges.pop();
				bridges.unshift(old);
			}
		}
		return orientation;
	};

	this.rotateBack = function (inputSteps) {
		var old = null;
		if (inputSteps === undefined) {
			inputSteps = 1;
		}
		if (inputSteps === parseInt(inputSteps, 10) && inputSteps > 0) {
			for (a = 0; a < inputSteps; a += 1) {
				decrementOrientation();
				old = bridges.shift();
				bridges.push(old);
			}
		}
		return orientation;
	};

	this.rotate180 = function () {
		var half = faceCount / 2,
			old = null;
		if (half === parseInt(half, 10)) {
			for (a = 0; a < half; a += 1) {
				incrementOrientation();
				old = bridges.pop();
				bridges.unshift(old);
			}
			return true;
		}
		return false;
	};

	this.mirrorH = function () {
		bridges = mirrorObj.mirrorH(bridges);
	};

	this.mirrorV = function () {
		bridges = mirrorObj.mirrorY(bridges);
	};

// END: public functions
// ========================================================
}
