<?php
/**
 * @file
 *
 * 	iProjectWebFiles main view row html function
 *
 * 	@see iProjectWebFiles::getMainView()
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
 * 	Displays a iProjectWebFiles main view record
 *
 * @param object $view
 * 	the iProjectWebFiles main view object
 * @param object $obj
 * 	a db object
 * @param int $i
 * 	record index
 * @param array $map
 * 	request data
 */
function getFilesMainViewRow($view, $obj, $i, $map) {

		$obj->WebdirChecked = $obj->get('Webdir') ? 'checked' : '';
		$obj->Webdir = $obj->get('Webdir') ? 'on' : 'off';

  ?>
  <tr class='ufohighlight <?php iProjectWebIHTML::getTrSwapClassName($i);?>'>
    <td class='firstcolumn'>
      <input type='checkbox' id='<?php echo $view->idJoin('cb', $obj->getId());?>' value='off' class='ufo-deletecb' onchange='this.value=(this.checked)?"on":"off";'>
    </td>
    <td>
      <?php echo $obj->get('id');?>
    </td>
    <td>
      <?php echo $obj->get('Doctype');?>
    </td>
    <td>
      <?php echo $obj->get('Docfield');?>
    </td>
    <td>
      <?php echo $obj->get('Docid');?>
    </td>
    <td>
      <div style='width:140px;overflow:auto'>
        <?php echo $obj->get('Name');?>
      </div>
    </td>
    <td>
      <?php echo $obj->get('Size');?>
    </td>
    <td>
      <input type='checkbox' value='<?php echo $obj->Webdir;?>' DISABLED <?php echo $obj->WebdirChecked;?> class='ufo-cb checkbox ufo-formvalue' onchange='this.value=(this.checked)?"on":"off"'>
    </td>
    <td>
      <div style='width:140px;overflow:auto'>
        <?php echo $obj->get('Storagename');?>
      </div>
    </td>
    <td>
      <a id='<?php echo $obj->elId('ObjectOwner', $obj->getId());?>' class='ufo-id-link' onclick='redirect({m:"show", oid:"<?php echo $obj->get('ObjectOwner');?>", t:"Users"})' onmouseover='showInfo({t:"Users", m2:"getUserASList", oid:<?php echo $obj->get('ObjectOwner');?>, m:"ajaxsuggest"}, this)'>
        <?php echo $obj->get('ObjectOwnerDescription');?>
      </a>
    </td>
  </tr>
	<?php
}
