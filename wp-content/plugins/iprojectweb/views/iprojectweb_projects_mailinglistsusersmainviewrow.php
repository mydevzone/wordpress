<?php
/**
 * @file
 *
 * 	iProjectWebProjects_MailingLists UsersMain view row html function
 *
 * 	@see iProjectWebProjects_MailingLists::getUsersMainView()
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
 * 	Displays a iProjectWebProjects_MailingLists UsersMain view record
 *
 * @param object $view
 * 	the iProjectWebProjects_MailingLists UsersMain view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getProjects_MailingListsUsersMainViewRow($view, $obj, $i, $map) { ?>
  <tr>
    <td class='firstcolumn'>
      <input type='checkbox' id='<?php echo $view->idJoin('cb', $obj->getId());?>' value='off' class='ufo-deletecb' onchange='this.value=(this.checked)?"on":"off";'>
    </td>
    <td>
      <a id='<?php echo $obj->elId('Projects', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('Projects');?>", t:"Projects"})' onmouseover='showInfo({t:"Projects", m2:"getASList", oid:<?php echo $obj->get('Projects');?>, m:"ajaxsuggest"}, this)'>
        <?php echo $obj->get('ProjectsDescription');?>
      </a>
    </td>
  </tr>
	<?php
}
