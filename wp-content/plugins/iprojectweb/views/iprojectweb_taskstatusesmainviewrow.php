<?php
/**
 * @file
 *
 * 	iProjectWebTaskStatuses main view row html function
 *
 * 	@see iProjectWebTaskStatuses::getMainView()
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
 * 	Displays a iProjectWebTaskStatuses main view record
 *
 * @param object $view
 * 	the iProjectWebTaskStatuses main view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getTaskStatusesMainViewRow($view, $obj, $i, $map) { ?>
  <tr class='ufohighlight <?php iProjectWebIHTML::getTrSwapClassName($i);?>'>
    <td class='firstcolumn'>
      <input type='checkbox' id='<?php echo $view->idJoin('cb', $obj->getId());?>' value='off' class='ufo-deletecb' onchange='this.value=(this.checked)?"on":"off";'>
    </td>
    <td>
      <?php echo $obj->get('id');?>
    </td>
    <td>
      <a onclick='redirect({m:"show", oid:"<?php echo $obj->get('id');?>", t:"TaskStatuses"})'>
        <?php iProjectWebIHTML::echoStr($obj->get('Description'));?>
      </a>
    </td>
    <td>
      <?php echo iProjectWebIHTML::getLPMover(array('jsconfig' => $view->jsconfig, 'id' => $obj->getId()));?>
    </td>
  </tr>
	<?php
}
