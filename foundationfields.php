<?php

require_once 'foundationfields.civix.php';
use CRM_Foundationfields_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function foundationfields_civicrm_config(&$config) {
  _foundationfields_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function foundationfields_civicrm_xmlMenu(&$files) {
  _foundationfields_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function foundationfields_civicrm_install() {
  _foundationfields_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function foundationfields_civicrm_postInstall() {
  _foundationfields_civix_civicrm_postInstall();

  // Via managed entities, we create a group of custom fields. Some of the fields
  // are radio fields that have options, so we ask managed entities to create
  // those options. 
  //
  // However, managed entities cannot assign each custom field to the
  // appropriate option group so we do that manually here.

  $pairs = array(
    'foundationfields_funding_area' => 'foundationfields_funding_area_values',
  );

  foreach($pairs as $field_name => $option_group_name) {
    foundationfields_assign_option_group_to_custom_field($field_name, $option_group_name); 
  }

  // In addition, we want to restrict the Proposal Info custom data group
  // to activities of the type: foundationfields_letter_of_inquiry and
  // foundationfields_proposal.
  $activity_type_ids = array();
  $activity_types = array('foundationfields_proposal', 'foundationfields_letter_of_inquiry');
  foreach($activity_types as $name) {
    $params = array('name' => $name, 'option_group_id' => 'activity_type');
    $result = civicrm_api3('OptionValue', 'getsingle', $params);
    $activity_type_ids[] = $result['value'];
  }

  $foundationfields_proposal_params = civicrm_api3('CustomGroup', 'getsingle', array('name' => 'foundationfields_proposal_info'));
  $foundationfields_proposal_params['extends_entity_column_value'] = $activity_type_ids;
  civicrm_api3('CustomGroup', 'create', $foundationfields_proposal_params);
}

/**
 * Assign option groups to fields
 *
 * @param string $field_name 
 *   string name of the field
 * @param string $option_group_name
 *   string name of option group
 *
 **/
function foundationfields_assign_option_group_to_custom_field($field_name, $option_group_name) {
  $params = array('name' => $option_group_name);
  $option_group = civicrm_api3('option_group', 'getsingle', $params);

  // Get the custom field.
  $params = array('name' => $field_name);
  $field = civicrm_api3('custom_field', 'getsingle', $params); 

  // Update the custom field.
  $field['option_group_id'] = $option_group['id'];
  civicrm_api3('custom_field', 'create', $field);
}
/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function foundationfields_civicrm_uninstall() {
  _foundationfields_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function foundationfields_civicrm_enable() {
  _foundationfields_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function foundationfields_civicrm_disable() {
  _foundationfields_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function foundationfields_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _foundationfields_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function foundationfields_civicrm_managed(&$entities) {
  _foundationfields_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function foundationfields_civicrm_caseTypes(&$caseTypes) {
  _foundationfields_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function foundationfields_civicrm_angularModules(&$angularModules) {
  _foundationfields_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function foundationfields_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _foundationfields_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function foundationfields_civicrm_entityTypes(&$entityTypes) {
  _foundationfields_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function foundationfields_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function foundationfields_civicrm_navigationMenu(&$menu) {
  _foundationfields_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _foundationfields_civix_navigationMenu($menu);
} // */
