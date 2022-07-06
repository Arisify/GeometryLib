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

use arisify\geometry\exception\GeometryInvalidDescriptionException;
use pocketmine\math\Vector3;

class Description{
	private string $identifier;
	private int $texture_width;
	private int $texture_height;
	private ?float $visible_bounds_width = null;
	private ?float $visible_bounds_height = null;
	private ?Vector3 $visible_bounds_offset = null;

	private bool $preserve_model_pose;

	private bool $animationArmsDown;
	private bool $animationArmsOutFront;
	private bool $animationStationaryLegs;
	private bool $animationSingleLegAnimation;
	private bool $animationSingleArmAnimation;
	private bool $animationStatueOfLibertyArms;
	private bool $animationDontShowArmor;
	private bool $animationNoHeadBob;
	private bool $animationUpsideDown;
	private bool $animationInvertedCrouch;

	/**
	 * @param string       $identifier
	 * @param int|null     $texture_width Width of the visibility bounding box (in model space units).
	 * @param int|null     $texture_height Height of the visible bounding box (in model space units).
	 * @param float|null   $visible_bounds_width Assumed width in texels of the texture that will be bound to this geometry.
	 * @param float|null   $visible_bounds_height Assumed height in texels of the texture that will be bound to this geometry.
	 * @param Vector3|null $visible_bounds_offset Offset of the visibility bounding box from the entity location point (in model space units).
	 */
	public function __construct(
		string $identifier,
		int $texture_width = null,
		int $texture_height = null,
        float $visible_bounds_width = null,
		float $visible_bounds_height = null,
        Vector3 $visible_bounds_offset = null
	){
		$this->setIdentifier($identifier);
		$this->setTextureHeight($texture_height);
		$this->setTextureWidth($texture_width);
		$this->setVisibleBoundsHeight($visible_bounds_height);
		$this->setVisibleBoundsWidth($visible_bounds_width);
		$this->setVisibleBoundsOffset($visible_bounds_offset);
	}

	public function getIdentifier() : string{
		return $this->identifier;
	}

	public function setIdentifier(string $identifier) : void{
		if (preg_match('~\W~', $identifier)) {
			throw new GeometryInvalidDescriptionException("Geometry's identifier ($identifier) must not contain non-Ascii character!");
		}
		if (str_starts_with($identifier, "geometry.")) {
			$identifier = "geometry." . $identifier;
		}
		$this->identifier = $identifier;
	}

	/**
	 * @return int
	 */
	public function getTextureWidth() : int{
		return $this->texture_width;
	}

	/**
	 * @param int $texture_width
	 */
	public function setTextureWidth(int $texture_width) : void{
		if ($texture_width < 0) {
			throw new GeometryInvalidDescriptionException("Texture's weight should be greater than 0! $texture_width was given!");
		}
		$this->texture_width = $texture_width;
	}

	/**
	 * @return int
	 */
	public function getTextureHeight() : int{
		return $this->texture_height;
	}

	/**
	 * @param int $texture_height
	 */
	public function setTextureHeight(int $texture_height) : void{
		if ($texture_height < 0) {
			throw new GeometryInvalidDescriptionException("Texture's height should be greater than 0! $texture_height was given!");
		}
		$this->texture_height = $texture_height;
	}

	/**
	 * @return Vector3
	 */
	public function getVisibleBoundsOffset() : Vector3{
		return $this->visible_bounds_offset;
	}

	/**
	 * @param Vector3 $visible_bounds_offset
	 */
	public function setVisibleBoundsOffset(Vector3 $visible_bounds_offset) : void{
		$this->visible_bounds_offset = $visible_bounds_offset;
	}

	/**
	 * @return float
	 */
	public function getVisibleBoundsHeight() : float{
		return $this->visible_bounds_height;
	}

	/**
	 * @param float $visible_bounds_height
	 */
	public function setVisibleBoundsHeight(float $visible_bounds_height) : void{
		$this->visible_bounds_height = $visible_bounds_height;
	}

	/**
	 * @return float|int
	 */
	public function getVisibleBoundsWidth() : float|int{
		return $this->visible_bounds_width;
	}

	/**
	 * @param float|int $visible_bounds_width
	 */
	public function setVisibleBoundsWidth(float|int $visible_bounds_width) : void{
		$this->visible_bounds_width = $visible_bounds_width;
	}

	public function toArray(array &$default = []) : array{
		$default["identifier"] = $this->identifier;
		$default["texture_width"] = $this->texture_width;
		$default["texture_height"] = $this->texture_height;
		$default["visible_bounds_width"] = $this->visible_bounds_width;
		$default["visible_bounds_height"] = $this->visible_bounds_height;

		$v = $this->visible_bounds_offset;
		$default["visible_bounds_offset"] = [$v->x, $v->y, $v->z];

		return $default;
	}
}
