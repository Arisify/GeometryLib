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
use arisify\geometry\exception\GeometryInvalidBoneException;

class Bone{
	protected string $name;
	protected bool $reset;
	protected bool $neverRender;
	/** @var string Bone that this bone is relative to. If the parent bone moves, this bone will move along with it.*/
	protected string $parent;
	/** @var Vector3|null The bone pivots around this point (in model space units).*/
	protected ?Vector3 $pivot = null;
	/** @var Vector3|null This is the initial rotation of the bone around the pivot, pre-animation (in degrees, x-then-y-then-z order).*/
	protected ?Vector3 $rotation = null;
	protected ?Vector3 $bind_pose_rotation = null;
	/** @var bool Mirrors the UV's of the un-rotated cubes along the x-axis, also causes the east/west faces to get flipped.*/
	protected bool $mirror = false;
	/** @var float|int Grow this box by this additive amount in all directions (in model space units).*/
	protected float|int $inflate = 0;
	protected bool $debug = false;

	protected int $render_group_id;
	/** @var array This is the list of cubes associated with this bone.*/
	protected array $cubes = [];
	/** @var TextureMesh[]|null ***EXPERIMENTAL*** Adds a mesh to the bone's geometry by converting texels in a texture into boxes */
	protected ?array $texture_meshes = null; // Optional
	/** @var PolyMesh[]|null ***EXPERIMENTAL*** A triangle or quad mesh object. Can be used in conjunction with cubes and texture geometry. */
	protected ?array $poly_meshes = null; // Optional
	/**
	 * @param string       $name
	 * @param Vector3|null $rotation
	 * @param Vector3      $pivot
	 * @param Cube[]       $cubes
	 * @param Vector3[]    $locators
	 * @param string|null  $parent
	 * @param bool         $mirror
	 * @param Vector3|null $bind_pose_rotation
	 */
	public function __construct(
		string           $name,
		protected ?Vector3 $rotation = null,
		protected Vector3  $pivot = new Vector3(0, 0, 0),
		protected array    $cubes = [],
		protected array    $locators = [],
		protected ?string  $parent = null,
		protected bool     $mirror = false,
		protected ?Vector3 $bind_pose_rotation = new Vector3(0,0,0)
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