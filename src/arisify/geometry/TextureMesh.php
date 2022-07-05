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

use pocketmine\math\Vector3;

class TextureMesh{
	/**
	 * @param string       $format_version
	 * @param Vector3      $position
	 * @param string       $texture     This was empty string in 1.12 but later change to default in 1.16
	 * @param Vector3|null $rotation
	 * @param Vector3|null $scale
	 * @param Vector3|null $local_pivot This was added in format version 1.16.0
	 */
	public function __construct(
		protected string $format_version,
		private Vector3  $position,
		private string   $texture = "",
		private ?Vector3 $rotation = null,
		private ?Vector3 $scale = null,
		private ?Vector3 $local_pivot = null
	) {
		if (Utils::compareVersion($this->format_version, "1.16.0") >= 0) {
			$this->local_pivot = $local_pivot;
			if ($texture === "") {
				$this->texture = "default";
			}
		}
	}

	/**
	 * @return string
	 */
	public function getFormatVersion() : string{
		return $this->format_version;
	}

	/**
	 * @return Vector3|null
	 */
	public function getLocalPivot() : ?Vector3{
		return $this->local_pivot ?? clone (Vector3::zero());
	}

	/**
	 * @param Vector3|null $local_pivot
	 */
	public function setLocalPivot(?Vector3 $local_pivot) : void{
		$this->local_pivot = $local_pivot;
	}

	/**
	 * @return string
	 */
	public function getTexture() : string{
		return $this->texture;
	}

	/**
	 * @param string $texture
	 */
	public function setTexture(string $texture) : void{
		$this->texture = $texture;
	}

	/**
	 * @return Vector3|null
	 */
	public function getScale() : ?Vector3{
		return $this->scale;
	}

	/**
	 * @param Vector3|null $scale
	 */
	public function setScale(?Vector3 $scale) : void{
		$this->scale = $scale;
	}

	/**
	 * @return Vector3
	 */
	public function getPosition() : Vector3{
		return $this->position;
	}

	/**
	 * @param Vector3 $position
	 */
	public function setPosition(Vector3 $position) : void{
		$this->position = $position;
	}

	/**
	 * @return Vector3|null
	 */
	public function getRotation() : ?Vector3{
		return $this->rotation;
	}

	/**
	 * @param Vector3|null $rotation
	 */
	public function setRotation(?Vector3 $rotation) : void{
		$this->rotation = $rotation;
	}
}