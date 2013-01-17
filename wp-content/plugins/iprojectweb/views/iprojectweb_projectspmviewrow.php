<?php
/**
 * @file
 *
 * 	iProjectWebProjects PM view row html function
 *
 * 	@see iProjectWebProjects::getPMView()
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
 * 	Displays a iProjectWebProjects PM view record
 *
 * @param object $view
 * 	the iProjectWebProjects PM view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getProjectsPMViewRow($view, $obj, $i, $map) { ?>
  <tr class='ufohighlight <?php iProjectWebIHTML::getTrSwapClassName($i);?>'>
    <td class='firstcolumn'>
      <?php echo $obj->get('id');?>
    </td>
    <td>
      <a id='<?php echo $obj->elId('Description', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('id');?>", t:"Projects"})' onmouseover='showInfo({t:"Projects", m2:"getASList", oid:<?php echo $obj->get('id');?>, m:"ajaxsuggest"}, this)'>
        <?php iProjectWebIHTML::echoStr($obj->get('Description'));?>
      </a>
    </td>
    <td>
      <?php echo $obj->get('StatusDescription');?>
    </td>
    <td>
      <?php iProjectWebIHTML::echoDate($obj->get('StartDate'), IPROJECTWEB_DateFormat, 0);?>
    </td>
    <td>
      <?php iProjectWebIHTML::echoDate($obj->get('FinishDate'), IPROJECTWEB_DateFormat, 0);?>
    </td>
  </tr>
	<?php
}
