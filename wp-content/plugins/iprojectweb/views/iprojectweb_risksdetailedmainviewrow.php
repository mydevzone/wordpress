<?php
/**
 * @file
 *
 * 	iProjectWebRisks detailedMain view row html function
 *
 * 	@see iProjectWebRisks::getDetailedMainView()
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
 * 	Displays a iProjectWebRisks detailedMain view record
 *
 * @param object $view
 * 	the iProjectWebRisks detailedMain view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getRisksDetailedMainViewRow($view, $obj, $i, $map) { ?>
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
      <a onclick='redirect({m:"show", oid:"<?php echo $obj->get('id');?>", t:"Risks"})'>
        <?php iProjectWebIHTML::echoStr($obj->get('Description'));?>
      </a>
    </td>
    <td>
      <span>
        <?php echo $obj->get('TypeDescription');?>
      </span>
    </td>
    <td>
      <span>
        <?php echo $obj->get('StatusDescription');?>
      </span>
    </td>
  </tr>
	<?php
}
