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

use pocketmine\math\Vector3;

use arisify\geometry\exception\GeometryInvalidBoneException;

class Bone{

    /* TODO: Add
         bool "debug" : opt
    */
    /**
     * @var string Animation files refer to this bone via this identifier.
     */
    protected string $name;
	protected ?bool $reset;
    /**
     * @var string|null 1.16.0+ format opt
     * Useful for items. A molang expression specifying the bone name of the parent skeletal hierarchy that this bone should use as the root transform.
     * Without this field it will look for a bone in the parent entity with the same name as this bone. If both are missing, it will assume a local
     * skeletal hierarchy (via the "parent" field). If that is also missing, it will attach to the owning entity's root transform.
     */
    protected ?string $molang;
	protected ?bool $neverRender;
	/** @var string|null Bone that this bone is relative to. If the parent bone moves, this bone will move along with it.*/
	protected ?string $parent;
	/**
     * @var Vector3|null The bone pivots around this point (in model space units).
     * If this field is specified, rotation of this cube occurs around this point, otherwise its rotation is around the center of the box.
     * Note that in 1.12 this is flipped upside-down, but is fixed in 1.14
     */
	protected ?Vector3 $pivot = null;
	/** @var Vector3|null This is the initial rotation of the bone around the pivot, pre-animation (in degrees, x-then-y-then-z order).*/
	protected ?Vector3 $rotation = null;
	protected ?Vector3 $bind_pose_rotation = null;
	/**
     * @var bool
     * Mirrors the UV's of the un-rotated cubes along the x-axis, also causes the east/west faces to get flipped.
     */
	protected bool $mirror = false;
	/**
     * @var float|int
     * Grow this box by this additive amount in all directions (in model space units), this field overrides the bone's inflate field for this cube only.
     */
	protected float|int $inflate = 0;

	protected int $render_group_id;
	/** @var array This is the list of cubes associated with this bone.*/
	protected array $cubes = [];
	/** @var TextureMesh[]|null ***EXPERIMENTAL*** Adds a mesh to the bone's format by converting texels in a texture into boxes */
	protected ?array $texture_meshes = null; // Optional
	/** @var PolyMesh[]|null ***EXPERIMENTAL*** A triangle or quad mesh object. Can be used in conjunction with cubes and texture format. */
	protected ?array $poly_mesh = null; // Optional

	protected ?array $locators = null; //Opt

    /**
     * @param string $name
     * @param array|null $cubes
     * @param Vector3|null $rotation
     * @param Vector3|null $pivot
     * @param array|null $locators
     * @param string|null $parent
     * @param bool $mirror
     * @param bool|null $reset
     * @param string|null $molang
     * @param Vector3|null $bind_pose_rotation
     * @param float|int|null $inflate
     * @param bool|null $neverRender
     * @param int|null $render_group_id
     * @param array|null $poly_mesh
     * @param array|null $texture_meshes
     */
	public function __construct(
		string         $name,
        ?string        $parent = null,
        ?Vector3       $pivot = null,
        ?Vector3       $rotation = null,
        ?bool          $mirror = null,
        float|int|null $inflate = null,
        ?bool          $debug = null,
        ?int           $render_group_id = null,
        ?array         $cubes = null,
        ?string        $molang = null,
        ?array         $locators = null,
        ?array         $poly_mesh = null,
        ?bool          $reset = null,
        ?array         $texture_meshes = null,
        ?Vector3       $bind_pose_rotation = null,
        ?bool          $neverRender = null,
	){
		$this->setName($name);
		$this->rotation = $rotation;
		$this->pivot = $pivot;
		$this->cubes = $cubes;
		$this->locators = $locators;
		$this->parent = $parent;
		$this->mirror = $mirror;
		$this->reset = $reset;
        $this->molang = $molang;
		$this->bind_pose_rotation = $bind_pose_rotation;
		$this->inflate = $inflate;
		$this->neverRender = $neverRender;
		$this->render_group_id = $render_group_id;
		$this->poly_mesh = $poly_mesh;
		$this->texture_meshes = $texture_meshes;
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