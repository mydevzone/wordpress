<?php
/**
 * @file
 *
 * 	iProjectWebProjects_Teams ProjectsReadonly view html template
 *
 * 	@see iProjectWebProjects_Teams ::getProjectsReadonlyView()
 */

/*  Copyright Georgiy Vasylyev, 2008-2012 | http://wp-pal.com  
 * -----------------------------------------------------------
 * iProject Web
 *
 * This product is distributed under terms of the GNU General Public License. http://www.gnu.org/licenses/gpl-2.0.txt.
 * 
 * Please read the entire license text in the license.txt file
 */

?>
  <div>
    <div class='buttons'>
      <div class='ufo-float-left'>
        <?php iProjectWebIHTML::getScroller($obj);?>
      </div>
      <div class='ufo-float-left'>
        <?php echo iProjectWebIHTML::getButton(
          array(
            'title' => IPROJECTWEB_Search,
            'events' => " onclick='doFilter($obj->jsconfig, this)'",
            'iclass' => " class='icon_filter' ",
            'bclass' => "ufo-imagebutton",
          )
        );?>
      </div>
      <div style='clear:left'></div>
    </div>
  </div>
  <div>
    <div id='divProjects_TeamsFilter' class='ufo-filter'>
      <div class='ufofilterbutton'>
        <?php echo iProjectWebIHTML::getButton(
          array(
            'label' => IPROJECTWEB_Filter,
            'events' => " onclick='filter($obj->jsconfig);'",
            'iclass' => " class='icon_filter_pane' ",
            'bclass' => "button internalimage",
          )
        );?>
      </div>
      <div class='ufo-clear-both'></div>
      <div>
        <div>
          <div>
            <label for='<?php echo $obj->sId('Members');?>'><?php echo IPROJECTWEB_Members;?></label>
            <select id='<?php echo $obj->sId('Members');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <?php iProjectWebIHTML::getAS($obj->Members);?>
          </div>
          <div>
            <label for='<?php echo $obj->sId('Role');?>'><?php echo IPROJECTWEB_Role;?></label>
            <select id='<?php echo $obj->sId('Role');?>' class='ufo-select ufo-filtersign'>
              <?php echo $obj->sList('ref');?>
            </select>
            <select id='Role' class='inputselect ufo-select ufo-filtervalue' style='width:130px'>
              <?php echo $obj->getListHTML(NULL, NULL, FALSE, 'ProjectRoles');?>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div>
    <div class='viewtable'>
      <table class='vtable'>
        <tr>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "MembersDescription",
                 'label' => IPROJECTWEB_Members,
              )
            );?>
          </th>
          <th>
            <?php iProjectWebIHTML::getColumnHeader(
              array(
                 'view' => $obj,
                 'field' => "RoleDescription",
                 'label' => IPROJECTWEB_Role,
              )
            );?>
          </th>
        </tr>
        <?php iProjectWebLayout::getRows(
          $resultset,
          'iProjectWebProjects_Teams',
          $obj,
          'iprojectweb_projects_teamsprojectsreadonlyviewrow.php',
          'getProjects_TeamsProjectsReadonlyViewRow',
          $viewmap
        );?>
      </table>
    </div>
  </div>
