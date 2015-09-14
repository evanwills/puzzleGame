
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

	this.getBridges = function () { return bridges; };

	this.getCode = function () { return code; };

	this.getID = function () { return shape.substring(0, 3) + bridgeCount + code; };

	this.getPieceType = function () { return 'PuzzlePiece'; };

	this.getShape = function () { return shape; };

	this.getOppositeFace = function (tmpFace, tmpFaceCount) {
		var originalFace = tmpFace;
		if (typeof (tmpFace) === 'number' && tmpFace !== isNaN && typeof (tmpFaceCount)  === 'number' && tmpFaceCount !== isNaN) {
			if (faceCount !== tmpFaceCount) {
				if ((faceCount / 2) === tmpFaceCount) {
					tmpFace *= 2;
				} else if ((faceCount * 2) === tmpFaceCount) {
					tmpFace /= 2;
				} else {
					throw 'PuzzlePiece.getOppositeFace() cannot handle neighbours with ' + tmpFaceCount + ' faces';
				}
			}
			if (tmpFace < faceCount) {
				half = Math.floor(faceCount / 2);
				if (tmpFace > half) {
					tmpFace -= half;
				} else if (tmpFace < half) {
					tmpFace += half;
				} else {
					throw 'puzzlePiece::getOppositeFace() cannot find the neighbour for ' + originalFace;
				}
				return tmpFace;
			} else {
				throw 'puzzlePiece::getOppositeFace() expects first parameter $face to be between 0 and ' + faceCount + '. ' + tmpFace + ' (translated from ' + originalFace + ') given.';
			}
		} else {
			if (typeof (tmpFace) !== 'number') {
				throw 'PuzzlePiece.getOppositeFace() expects first parameter \'tmpFace\' to be an number. ' + typeof (tmpFace) + ' given.';
			}
			if (typeof (tmpFaceCount) !== 'number') {
				throw 'PuzzlePiece.getOppositeFace() expects second parameter \'tmpFaceCount\' to be an number. ' + typeof (tmpFaceCount) + ' given.';
			}
		}
	};

	this.getOrientation = function () { return orientation; };

	this.hasBridge = function (tmpFace, tmpFaceCount) {
		try {
			tmpFace = this.getOppositeFace(tmpFace, tmpFaceCount);
		} catch (e) {
			console.error(e);//str_replace('getOppositeFace','hasBridge'.$e->getMessage()));
		}
		return bridges[tmpFace];
	};

	this.rotate = function (tmpSteps) {
		var end = faceCount - 1,
			old = null;
		if (tmpSteps === undefined) {
			tmpSteps = 1;
		}
		if (tmpSteps === parseInt(tmpSteps, 10) && tmpSteps > 0) {
			for (a = 0; a < tmpSteps; a += 1) {
				incrementOrientation();
				old = bridges.pop();
				bridges.unshift(old);
			}
		}
		return orientation;
	};

	this.rotateBack = function (tmpSteps) {
		var old = null;
		if (tmpSteps === undefined) {
			tmpSteps = 1;
		}
		if (tmpSteps === parseInt(tmpSteps, 10) && tmpSteps > 0) {
			for (a = 0; a < tmpSteps; a += 1) {
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
