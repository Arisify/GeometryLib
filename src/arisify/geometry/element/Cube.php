<?php
/**
 * This file is part of the GeometryLib ©2022
 *
 * @author Arisify
 * @link   https://github.com/Arisify
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * •.,¸,.•*`•.,¸¸,.•*¯ ╭━━━━━━━━━━━━╮
 * •.,¸,.•*¯`•.,¸,.•*¯.|:::::::/\___/\
 * •.,¸,.•*¯`•.,¸,.•* <|:::::::(｡ ●ω●｡)
 * •.,¸,.•¯•.,¸,.•╰ *  し------し---Ｊ
 *
 */
declare(strict_types=1);

namespace arisify\geometry\element;

use pocketmine\math\Vector2;
use pocketmine\math\Vector3;

class Cube{
	/**
	 * @param Vector3      $origin   This point declares the unrotated lower corner of cube (smallest x/y/z value in model space units).
	 * @param UV|Vector2   $uv      An object or specifies the upper-left corner on the texture for the start of the texture mapping for this box.
	 * @param Vector3|null $size     The cube extends this amount relative to its origin (in model space units).
	 * @param Vector3|null $pivot If this field is specified, rotation of this cube occurs around this point, otherwise its rotation is around the center of the box.
	 * @param Vector3|null $rotation The cube is rotated by this amount (in degrees, x-then-y-then-z order) around the pivot.
	 * @param float|null   $inflate Grow this box by this additive amount in all directions (in model space units), this field overrides the bone's inflate field for this cube only.
	 * @param bool         $mirror Mirrors this cube about the unrotated x axis (effectively flipping the east / west faces), overriding the bone's 'mirror' setting for this cube.
	 */
	public function __construct(
		public Vector3 $origin,
		public UV | Vector2 $uv,
		public ?Vector3 $size = null,
		public ?Vector3 $pivot = null,
		public ?Vector3 $rotation = null,
		public ?float $inflate = null,
		public ?bool $mirror = null,
	) {}

	/**
	 * @return float
	 */
	public function getInflate() : float{
		return $this->inflate ?? 0.0;
	}

	/**
	 * @param float $inflate
	 */
	public function setInflate(float $inflate) : void{
		$this->inflate = $inflate;
	}

	/**
	 * @return Vector3
	 */
	public function getRotation() : Vector3{
		return $this->rotation ?? clone (Vector3::zero());
	}

	/**
	 * @param Vector3 $rotation
	 */
	public function setRotation(Vector3 $rotation) : void{
		$this->rotation = $rotation;
	}

	/**
	 * @return Vector3
	 */
	public function getSize() : Vector3{
		return $this->size ?? clone (Vector3::zero());
	}

	/**
	 * @param Vector3 $size
	 */
	public function setSize(Vector3 $size) : void{
		$this->size = $size;
	}

	/**
	 * Get the UV info
	 * @return UV|Vector2
	 */
	public function getUv() : Vector2|UV{
		return $this->uv;
	}

	/**
	 * @param UV|Vector2 $uv
	 */
	public function setUv(Vector2|UV $uv) : void{
		$this->uv = $uv;
	}

	/**
	 * Get the position of the cube
	 * @return Vector3
	 */
	public function getOrigin() : Vector3{
		return $this->origin;
	}

	/**
	 * @param Vector3 $origin
	 */
	public function setOrigin(Vector3 $origin) : void{
		$this->origin = $origin;
	}
}