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

use arisify\geometry\exception\GeometryInvalidBoneException;
use pocketmine\math\Vector3;

class Bone{
	private string $name;

	/**
	 * @param string       $name
	 * @param Vector3|null $rotation
	 * @param Vector3      $pivot
	 * @param Cube[]       $cubes
	 * @param Vector3[]    $locators
	 * @param string|null  $parent
	 * @param bool         $mirror
	 */
	public function __construct(
		string           $name,
		private ?Vector3 $rotation = null,
		private Vector3  $pivot = new Vector3(0, 0, 0),
		private array    $cubes = [],
		private array    $locators = [],
		private ?string  $parent = null,
		private bool     $mirror = false,
		$bind_pose_rotation = new Vector3(0,0,0);
	) {
		$this->setName($name);
	}

	public function getName() : string{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name) : void{
		if (preg_match('~\W~', $name)) {
			throw new GeometryInvalidBoneException("Bone's name ($name) must not contain non-Ascii character!");
		}
		$this->name = $name;
	}

	/**
	 * @return Vector3
	 */
	public function getPivot() : Vector3{
		return $this->pivot;
	}

	/**
	 * @param Vector3 $pivot
	 */
	public function setPivot(Vector3 $pivot) : void{
		$this->pivot = $pivot;
	}

	/**
	 * @return Cube[]
	 */
	public function getCubes(string $name) : array{
		return $this->cubes;
	}

	/**
	 * @param Cube[] $cubes
	 */
	public function setCubes(array $cubes) : void{
		$this->cubes = $cubes;
	}

	/**
	 * @return Vector3[]
	 */
	public function getLocators() : array{
		return $this->locators;
	}

	/**
	 * @param Vector3[] $locators
	 */
	public function setLocators(array $locators) : void{
		$this->locators = $locators;
	}

	/**
	 * @return string|null
	 */
	public function getParent() : ?string{
		return $this->parent;
	}

	/**
	 * @param string|null $parent
	 */
	public function setParent(?string $parent) : void{
		$this->parent = $parent;
	}

	public function toArray(array &$default = []) : array{
		if (isset($default["rotation"])) {
			$default["rotation"] = 0;
		}
		return $default;
	}

	/**
	 * @return bool
	 */
	public function isMirror() : bool{
		return $this->mirror;
	}

	/**
	 * @param bool $mirror
	 */
	public function setMirror(bool $mirror) : void{
		$this->mirror = $mirror;
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