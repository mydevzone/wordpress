<?php
/**
 * @file
 *
 * 	iProjectWebProjects_Teams ProjectsReadonly view row html function
 *
 * 	@see iProjectWebProjects_Teams::getProjectsReadonlyView()
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
 * 	Displays a iProjectWebProjects_Teams ProjectsReadonly view record
 *
 * @param object $view
 * 	the iProjectWebProjects_Teams ProjectsReadonly view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getProjects_TeamsProjectsReadonlyViewRow($view, $obj, $i, $map) { ?>
  <tr>
    <td class='firstcolumn'>
      <a id='<?php echo $obj->elId('Members', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('Members');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('Members');?>, m:"ajaxsuggest"}, this)'>
        <?php echo $obj->get('MembersDescription');?>
      </a>
    </td>
    <td>
      <?php echo $obj->get('RoleDescription');?>
    </td>
  </tr>
	<?php
}
