<?php
/**
 * @file
 *
 * 	iProjectWebRisks main view row html function
 *
 * 	@see iProjectWebRisks::getMainView()
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
 * 	Displays a iProjectWebRisks main view record
 *
 * @param object $view
 * 	the iProjectWebRisks main view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getRisksMainViewRow($view, $obj, $i, $map) { ?>
  <tr class='ufohighlight <?php iProjectWebIHTML::getTrSwapClassName($i);?>'>
    <td class='firstcolumn'>
      <input type='checkbox' id='<?php echo $view->idJoin('cb', $obj->getId());?>' value='off' class='ufo-deletecb' onchange='this.value=(this.checked)?"on":"off";'>
    </td>
    <td>
      <?php echo $obj->get('id');?>
    </td>
    <td>
      <a onclick='redirect({m:"show", oid:"<?php echo $obj->get('id');?>", t:"Risks"})'>
        <?php iProjectWebIHTML::echoStr($obj->get('Description'));?>
      </a>
    </td>
    <td>
      <a onclick='redirect({m:"show", oid:"<?php echo $obj->get('Status');?>", t:"RiskStatuses"})'>
        <?php echo $obj->get('StatusDescription');?>
      </a>
    </td>
    <td>
      <a onclick='redirect({m:"show", oid:"<?php echo $obj->get('Type');?>", t:"RiskTypes"})'>
        <?php echo $obj->get('TypeDescription');?>
      </a>
    </td>
    <td>
      <a id='<?php echo $obj->elId('Projects', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('Projects');?>", t:"Projects"})' onmouseover='showInfo({t:"Projects", m2:"getASList", oid:<?php echo $obj->get('Projects');?>, m:"ajaxsuggest"}, this)'>
        <?php echo $obj->get('ProjectsDescription');?>
      </a>
    </td>
  </tr>
	<?php
}
