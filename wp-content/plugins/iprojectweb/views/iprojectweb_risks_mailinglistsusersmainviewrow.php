<?php
/**
 * @file
 *
 * 	iProjectWebRisks_MailingLists UsersMain view row html function
 *
 * 	@see iProjectWebRisks_MailingLists::getUsersMainView()
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
 * 	Displays a iProjectWebRisks_MailingLists UsersMain view record
 *
 * @param object $view
 * 	the iProjectWebRisks_MailingLists UsersMain view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getRisks_MailingListsUsersMainViewRow($view, $obj, $i, $map) { ?>
  <tr>
    <td class='firstcolumn'>
      <input type='checkbox' id='<?php echo $view->idJoin('cb', $obj->getId());?>' value='off' class='ufo-deletecb' onchange='this.value=(this.checked)?"on":"off";'>
    </td>
    <td>
      <a onclick='redirect({m:"show", oid:"<?php echo $obj->get('Projects');?>", t:"Projects"})'>
        <?php echo $obj->get('ProjectsDescription');?>
      </a>
    </td>
    <td>
      <a onclick='redirect({m:"show", oid:"<?php echo $obj->get('Risks');?>", t:"Risks"})'>
        <?php echo $obj->get('RisksDescription');?>
      </a>
    </td>
  </tr>
	<?php
}
