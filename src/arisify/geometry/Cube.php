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

namespace arisify\geometry;

use pocketmine\math\Vector2;
use pocketmine\math\Vector3;

class Cube{
	public function __construct(
		public Vector3 $origin,
		public UV | Vector2 $uv,
		public ?Vector3 $size = null,
		public ?Vector3 $rotation = null,
		public ?float $inflate = null,
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