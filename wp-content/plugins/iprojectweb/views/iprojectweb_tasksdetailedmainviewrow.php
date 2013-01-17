<?php
/**
 * @file
 *
 * 	iProjectWebTasks detailedMain view row html function
 *
 * 	@see iProjectWebTasks::getDetailedMainView()
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
 * 	Displays a iProjectWebTasks detailedMain view record
 *
 * @param object $view
 * 	the iProjectWebTasks detailedMain view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getTasksDetailedMainViewRow($view, $obj, $i, $map) { ?>
  <tr class='ufohighlight <?php iProjectWebIHTML::getTrSwapClassName($i);?>'>
    <?php if ($view->ifRole('SuperAdmin', 'Owner')) : ?>
      <td class='firstcolumn'>
        <input type='checkbox' id='<?php echo $view->idJoin('cb', $obj->getId());?>' value='off' class='ufo-deletecb' onchange='this.value=(this.checked)?"on":"off";'>
      </td>
    <?php endif; ?>
    <td>
      <?php echo $obj->get('id');?>
    </td>
    <td>
      <a id='<?php echo $obj->elId('Description', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('id');?>", t:"Tasks"})' onmouseover='showInfo({t:"Tasks", m2:"getASList", oid:<?php echo $obj->get('id');?>, m:"ajaxsuggest"}, this)'>
        <?php iProjectWebIHTML::echoStr($obj->get('Description'));?>
      </a>
    </td>
    <td>
      <?php echo $obj->get('PriorityDescription');?>
    </td>
    <td>
      <?php iProjectWebIHTML::echoDate($obj->get('PlannedDeadline'), IPROJECTWEB_DateFormat, 0);?>
    </td>
    <td>
      <?php echo $obj->get('PlannedEffort');?>
    </td>
  </tr>
	<?php
}
