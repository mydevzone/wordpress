<?php
/**
 * @file
 *
 * 	iProjectWebProjects_Teams UsersReadonly view row html function
 *
 * 	@see iProjectWebProjects_Teams::getUsersReadonlyView()
 * 	@see iProjectWebLayout::getRows()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

/**
 * 	Displays a iProjectWebProjects_Teams UsersReadonly view record
 *
 * @param object $view
 * 	the iProjectWebProjects_Teams UsersReadonly view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getProjects_TeamsUsersReadonlyViewRow($view, $obj, $i, $map) { ?>
  <tr>
    <td class='firstcolumn'>
      <a id='<?php echo $obj->elId('Projects', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('Projects');?>", t:"Projects"})' onmouseover='showInfo({t:"Projects", m2:"getASList", oid:<?php echo $obj->get('Projects');?>, m:"ajaxsuggest"}, this)'>
        <?php echo $obj->get('ProjectsDescription');?>
      </a>
    </td>
    <td>
      <?php echo $obj->get('RoleDescription');?>
    </td>
  </tr>
	<?php
}
