<?php
/**
 * @file
 *
 * 	iProjectWebUsers readonly view row html function
 *
 * 	@see iProjectWebUsers::getReadonlyView()
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
 * 	Displays a iProjectWebUsers readonly view record
 *
 * @param object $view
 * 	the iProjectWebUsers readonly view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getUsersReadonlyViewRow($view, $obj, $i, $map) {

		$obj->Description = array();
		$obj->Description[] = $obj->get('Name');
		$obj->Description[] = $obj->get('Description');
		$obj->Description = iProjectWebUtils::vImplode(' ', $obj->Description);

  ?>
  <tr class='ufohighlight <?php iProjectWebIHTML::getTrSwapClassName($i);?>'>
    <td class='firstcolumn'>
      <a id='<?php echo $obj->elId('Description', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('id');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('id');?>, m:"ajaxsuggest"}, this)'>
        <?php echo $obj->Description;?>
      </a>
    </td>
    <td>
      <?php echo $obj->get('email');?>
    </td>
  </tr>
	<?php
}
