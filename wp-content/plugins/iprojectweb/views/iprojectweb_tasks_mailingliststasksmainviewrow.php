<?php
/**
 * @file
 *
 * 	iProjectWebTasks_MailingLists TasksMain view row html function
 *
 * 	@see iProjectWebTasks_MailingLists::getTasksMainView()
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
 * 	Displays a iProjectWebTasks_MailingLists TasksMain view record
 *
 * @param object $view
 * 	the iProjectWebTasks_MailingLists TasksMain view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getTasks_MailingListsTasksMainViewRow($view, $obj, $i, $map) { ?>
  <tr>
    <?php if ($view->ifRole('SuperAdmin', 'Owner')) : ?>
      <td class='firstcolumn'>
        <input type='checkbox' id='<?php echo $view->idJoin('cb', $obj->getId());?>' value='off' class='ufo-deletecb' onchange='this.value=(this.checked)?"on":"off";'>
      </td>
    <?php endif; ?>
    <td>
      <a id='<?php echo $obj->elId('Contacts', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('Contacts');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('Contacts');?>, m:"ajaxsuggest"}, this)'>
        <?php echo $obj->get('ContactsDescription');?>
      </a>
    </td>
  </tr>
	<?php
}
