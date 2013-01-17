<?php

/**
 * @file
 *
 * 	iProjectWebMenu class definition
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
 * 	Provides an html menu for each defined role
 *
 */
class iProjectWebMenu {

	/**
	 * 	getMenu
	 *
	 * 	Main menu function
	 *
	 * @param array $menumap
	 * 	Request data
	 */
	function getMenu($menumap) {

		if (isset($menumap['r'])) {
			return '';
		}
		$role = $menumap['iprojectusr']->role->Description;
		switch ($role) {
			case 'PM': return iProjectWebMenu::getPMMenu($menumap);
			case 'SuperAdmin': return iProjectWebMenu::getSuperAdminMenu($menumap);
			case 'TeamMember': return iProjectWebMenu::getTeamMemberMenu($menumap);

			default: return '';
		}

	}

	/**
	 * 	PM role menu
	 *
	 * @param array $map
	 * 	Request data
	 */
	function getPMMenu($map) {
			?>

		
    <div class='ufomenuwrapper'>
      <div class='menupanel'>
        <ul class='ufoMenu'>
          <li>
            <a href='javascript:mcall("t=Projects&m=view")'>
              <?php echo IPROJECTWEB_Projects;?>
            </a>
          </li>
          <li>
            <a href='javascript:mcall("t=Tasks&m=view")'>
              <?php echo IPROJECTWEB_Tasks;?>
            </a>
          </li>
          <li>
            <a href='javascript:mcall("t=Users&m=view")'>
              <?php echo IPROJECTWEB_Users;?>
            </a>
          </li>
          <li class='ufoemptymenu'>
            <a href='javascript:;' class='ufoemptymenu'>
              <span>
                 <?php echo IPROJECTWEB_KnowlegeBase;?>
              </span>
            </a>
            <ul class='ufoMenui'>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_ProjectSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=ProjectStatuses&m=view")'>
                       <?php echo IPROJECTWEB_ProjectStatuses;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectField1&m=view")'>
                       <?php echo IPROJECTWEB_ProjectField1;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectField2&m=view")'>
                       <?php echo IPROJECTWEB_ProjectField2;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectRoles&m=view")'>
                       <?php echo IPROJECTWEB_ProjectRoles;?>
                     </a>
                   </li>
                 </ul>
              </li>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_TaskSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=Priorities&m=view")'>
                       <?php echo IPROJECTWEB_Priorities;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=TaskStatuses&m=view")'>
                       <?php echo IPROJECTWEB_TaskStatuses;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=TaskTypes&m=view")'>
                       <?php echo IPROJECTWEB_TaskTypes;?>
                     </a>
                   </li>
                 </ul>
              </li>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_RiskSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=RiskImpacts&m=view")'>
                       <?php echo IPROJECTWEB_RiskImpacts;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskProbabilities&m=view")'>
                       <?php echo IPROJECTWEB_RiskProbabilities;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskStatuses&m=view")'>
                       <?php echo IPROJECTWEB_RiskStatuses;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskStrategies&m=view")'>
                       <?php echo IPROJECTWEB_RiskStrategies;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskTypes&m=view")'>
                       <?php echo IPROJECTWEB_RiskTypes;?>
                     </a>
                   </li>
                 </ul>
              </li>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_UserSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=UserField1&m=view")'>
                       <?php echo IPROJECTWEB_UserField1;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=UserField2&m=view")'>
                       <?php echo IPROJECTWEB_UserField2;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=UserTypes&m=view")'>
                       <?php echo IPROJECTWEB_UserTypes;?>
                     </a>
                   </li>
                 </ul>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>

			<?php
	}

	/**
	 * 	SuperAdmin role menu
	 *
	 * @param array $map
	 * 	Request data
	 */
	function getSuperAdminMenu($map) {
			?>

		
    <div class='ufomenuwrapper'>
      <div class='menupanel'>
        <ul class='ufoMenu'>
          <li>
            <a href='javascript:mcall("t=Users&m=view")'>
              <?php echo IPROJECTWEB_Users;?>
            </a>
          </li>
          <li>
            <a href='javascript:mcall("t=Projects&m=view")'>
              <?php echo IPROJECTWEB_Projects;?>
            </a>
          </li>
          <li>
            <a href='javascript:mcall("t=Risks&m=view")'>
              <?php echo IPROJECTWEB_Risks;?>
            </a>
          </li>
          <li>
            <a href='javascript:mcall("t=Tasks&m=view")'>
              <?php echo IPROJECTWEB_Tasks;?>
            </a>
          </li>
          <li class='ufoemptymenu'>
            <a href='javascript:;' class='ufoemptymenu'>
              <span>
                 <?php echo IPROJECTWEB_KnowlegeBase;?>
              </span>
            </a>
            <ul class='ufoMenui'>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_ProjectSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=ProjectRoles&m=view")'>
                       <?php echo IPROJECTWEB_ProjectRoles;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectStatuses&m=view")'>
                       <?php echo IPROJECTWEB_ProjectStatuses;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectField1&m=view")'>
                       <?php echo IPROJECTWEB_ProjectField1;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectField2&m=view")'>
                       <?php echo IPROJECTWEB_ProjectField2;?>
                     </a>
                   </li>
                 </ul>
              </li>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_RiskSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=RiskImpacts&m=view")'>
                       <?php echo IPROJECTWEB_RiskImpacts;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskProbabilities&m=view")'>
                       <?php echo IPROJECTWEB_RiskProbabilities;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskStatuses&m=view")'>
                       <?php echo IPROJECTWEB_RiskStatuses;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskStrategies&m=view")'>
                       <?php echo IPROJECTWEB_RiskStrategies;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskTypes&m=view")'>
                       <?php echo IPROJECTWEB_RiskTypes;?>
                     </a>
                   </li>
                 </ul>
              </li>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_TaskSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=Priorities&m=view")'>
                       <?php echo IPROJECTWEB_Priorities;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=TaskStatuses&m=view")'>
                       <?php echo IPROJECTWEB_TaskStatuses;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=TaskTypes&m=view")'>
                       <?php echo IPROJECTWEB_TaskTypes;?>
                     </a>
                   </li>
                 </ul>
              </li>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_UserSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=UserTypes&m=view")'>
                       <?php echo IPROJECTWEB_UserTypes;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=UserField1&m=view")'>
                       <?php echo IPROJECTWEB_UserField1;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=UserField2&m=view")'>
                       <?php echo IPROJECTWEB_UserField2;?>
                     </a>
                   </li>
                 </ul>
              </li>
            </ul>
          </li>
          <li>
            <a href='javascript:mcall("t=ApplicationSettings&m=show")'>
              <span>
                 <?php echo IPROJECTWEB_ApplicationSettings;?>
              </span>
            </a>
            <ul class='ufoMenui'>
              <li>
                 <a href='javascript:mcall("t=Files&m=view")'>
                   <span>
                     <?php echo IPROJECTWEB_Files;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=TaskFiles&m=view")'>
                       <?php echo IPROJECTWEB_TaskFiles;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectFiles&m=view")'>
                       <?php echo IPROJECTWEB_ProjectFiles;?>
                     </a>
                   </li>
                 </ul>
              </li>
            </ul>
          </li>
          <li>
            <a href='javascript:;' onclick='<?php echo iProjectWebUtils::getHelpLink('iproject');?>'>
              <?php echo IPROJECTWEB_Help;?>
            </a>
          </li>
        </ul>
      </div>
    </div>

			<?php
	}

	/**
	 * 	TeamMember role menu
	 *
	 * @param array $map
	 * 	Request data
	 */
	function getTeamMemberMenu($map) {
			?>

		
    <div class='ufomenuwrapper'>
      <div class='menupanel'>
        <ul class='ufoMenu'>
          <li>
            <a href='javascript:mcall("t=Projects&m=view")'>
              <?php echo IPROJECTWEB_Projects;?>
            </a>
          </li>
          <li>
            <a href='javascript:mcall("t=Tasks&m=view")'>
              <?php echo IPROJECTWEB_Tasks;?>
            </a>
          </li>
          <li>
            <a href='javascript:mcall("t=Users&m=view")'>
              <?php echo IPROJECTWEB_Users;?>
            </a>
          </li>
          <li class='ufoemptymenu'>
            <a href='javascript:;' class='ufoemptymenu'>
              <span>
                 <?php echo IPROJECTWEB_KnowlegeBase;?>
              </span>
            </a>
            <ul class='ufoMenui'>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_ProjectSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=ProjectRoles&m=view")'>
                       <?php echo IPROJECTWEB_ProjectRoles;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectStatuses&m=view")'>
                       <?php echo IPROJECTWEB_ProjectStatuses;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectField1&m=view")'>
                       <?php echo IPROJECTWEB_ProjectField1;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=ProjectField2&m=view")'>
                       <?php echo IPROJECTWEB_ProjectField2;?>
                     </a>
                   </li>
                 </ul>
              </li>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_TaskSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=Priorities&m=view")'>
                       <?php echo IPROJECTWEB_Priorities;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=TaskStatuses&m=view")'>
                       <?php echo IPROJECTWEB_TaskStatuses;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=TaskTypes&m=view")'>
                       <?php echo IPROJECTWEB_TaskTypes;?>
                     </a>
                   </li>
                 </ul>
              </li>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_RiskSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=RiskTypes&m=view")'>
                       <?php echo IPROJECTWEB_RiskTypes;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskImpacts&m=view")'>
                       <?php echo IPROJECTWEB_RiskImpacts;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskProbabilities&m=view")'>
                       <?php echo IPROJECTWEB_RiskProbabilities;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskStatuses&m=view")'>
                       <?php echo IPROJECTWEB_RiskStatuses;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=RiskStrategies&m=view")'>
                       <?php echo IPROJECTWEB_RiskStrategies;?>
                     </a>
                   </li>
                 </ul>
              </li>
              <li class='ufoemptymenu'>
                 <a href='javascript:;' class='ufoemptymenu'>
                   <span>
                     <?php echo IPROJECTWEB_UserSettings;?>
                   </span>
                 </a>
                 <ul class='ufoMenui'>
                   <li>
                     <a href='javascript:mcall("t=UserTypes&m=view")'>
                       <?php echo IPROJECTWEB_UserTypes;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=UserField1&m=view")'>
                       <?php echo IPROJECTWEB_UserField1;?>
                     </a>
                   </li>
                   <li>
                     <a href='javascript:mcall("t=UserField2&m=view")'>
                       <?php echo IPROJECTWEB_UserField2;?>
                     </a>
                   </li>
                 </ul>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>

			<?php
	}

}
