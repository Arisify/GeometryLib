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

class Polymesh{
	public function __construct(
		bool $normalized_uvs,
		Vector3 $positions,
		Vector2|UV $uv,
		Vector3 $normals,
		$polys
	){

	}
	/* object "poly_mesh" : opt // ***EXPERIMENTAL*** A triangle or quad mesh object.  Can be used in conjunction with cubes and texture geometry.
        {
            bool "normalized_uvs" : opt // If true, UVs are assumed to be [0-1].  If false, UVs are assumed to be [0-texture_width] and [0-texture_height] respectively.
            array "positions" : opt
            {
                array "<any array element>"[3] : opt
                {
                    float "<any array element>" // Vertex positions for the mesh.  Can be either indexed via the "polys" section, or be a quad-list if mapped 1-to-1 to the normals and UVs sections.
                }
            }
            array "normals" : opt
            {
                array "<any array element>"[3] : opt
                {
                    float "<any array element>" // Vertex normals.  Can be either indexed via the "polys" section, or be a quad-list if mapped 1-to-1 to the positions and UVs sections.
                }
            }
            array "uvs" : opt
            {
                array "<any array element>"[2] : opt
                {
                    float "<any array element>" // Vertex UVs.  Can be either indexed via the "polys" section, or be a quad-list if mapped 1-to-1 to the positions and normals sections.
                }
            }
            array "polys"
            {
                array "<any array element>"[3,4] : opt
                {
                    array "<any array element>"[3]
                    {
                        float "<any array element>" // Poly element indices, as an array of polygons, each an array of either three or four vertices, each an array of indices into positions, normals, and UVs (in that order).
                    }
                }
            }
            string "polys"<"tri_list", "quad_list"> // If not specifying vertex indices, arrays of data must be a list of tris or quads, set by making this property either "tri_list" or "quad_list"
        }
	 */
}