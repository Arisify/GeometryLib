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

class FaceUV{
	private Vector2 $uv;
	private ?Vector2 $uv_size;
	private ?string $material_instance;

	/**
	 * @param Vector2      $uv Specifies the uv origin for the face. For this face, it is the upper-left corner, when looking at the face with y being up.
	 * @param Vector2|null $uv_size The face maps this many texels from the uv origin. If not specified, the box dimensions are used instead.
	 * @param string|null  $material_instance
	 */
	public function __construct(
		Vector2  $uv,
		?Vector2 $uv_size = null,
		?string  $material_instance = null
	){
		$this->uv = $uv;
		$this->uv_size = $uv_size;
		$this->material_instance = $material_instance;
	}

	public function getUv() : Vector2{
		return $this->uv;
	}

	public function setUv(Vector2 $uv) : void{
		$this->uv = $uv;
	}

	public function getUvSize() : ?Vector2{
		return $this->uv_size;
	}

	public function setUvSize(Vector2 $uv_size) : void{
		$this->uv_size = $uv_size;
	}

	public function getMaterialInstance() : ?string{
		return $this->material_instance;
	}

	public function setMaterialInstance(string $material_instance) : void{
		$this->material_instance = $material_instance;
	}
}