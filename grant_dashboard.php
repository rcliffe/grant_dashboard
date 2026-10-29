<?php
declare(strict_types = 1);

// phpcs:disable PSR1.Files.SideEffects
require_once 'grant_dashboard.civix.php';
// phpcs:enable

use CRM_GrantDashboard_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function grant_dashboard_civicrm_config(\CRM_Core_Config $config): void {
  _grant_dashboard_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function grant_dashboard_civicrm_install(): void {
  _grant_dashboard_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function grant_dashboard_civicrm_enable(): void {
  _grant_dashboard_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_pre().
 *
 * Enforces the agreed amount for approved and rejected grants, however they are saved.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_pre
 */
function grant_dashboard_civicrm_pre(string $op, string $objectName, $id, &$params): void {
  if ($objectName !== 'Grant' || !in_array($op, ['create', 'edit'], TRUE)) {
    return;
  }
  // Only check when the status or amount is being changed, so unrelated edits aren't blocked.
  if (!array_key_exists('status_id', $params) && !array_key_exists('amount_granted', $params)) {
    return;
  }

  $existing = [];
  if ($id) {
    $existing = \Civi\Api4\Grant::get(FALSE)
      ->addSelect('status_id', 'amount_granted')
      ->addWhere('id', '=', $id)
      ->execute()
      ->first() ?? [];
  }
  $statusId = $params['status_id'] ?? $existing['status_id'] ?? NULL;
  $amount = $params['amount_granted'] ?? $existing['amount_granted'] ?? NULL;

  if ($statusId == _grant_dashboard_status_id('approved')) {
    if ((float) $amount <= 0) {
      throw new CRM_Core_Exception(E::ts('An approved grant must have an amount granted greater than 0.'));
    }
  }
  elseif ($statusId == _grant_dashboard_status_id('rejected')) {
    $params['amount_granted'] = 0;
  }
}

/**
 * Implements hook_civicrm_validateForm().
 *
 * Shows the agreed amount rules as field errors on the grant edit form.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_validateForm
 */
function grant_dashboard_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors): void {
  if ($formName !== 'CRM_Grant_Form_Grant' || empty($fields['status_id'])) {
    return;
  }
  $amount = (float) CRM_Utils_Rule::cleanMoney($fields['amount_granted'] ?? '');

  if ($fields['status_id'] == _grant_dashboard_status_id('approved') && $amount <= 0) {
    $errors['amount_granted'] = E::ts('An approved grant must have an amount granted greater than 0.');
  }
  elseif ($fields['status_id'] == _grant_dashboard_status_id('rejected') && $amount != 0) {
    $errors['amount_granted'] = E::ts('A rejected grant must have an amount granted of 0.');
  }
}

/**
 * Gets the grant_status id configured for a decision.
 *
 * @param string $decision
 *   'approved' or 'rejected'.
 *
 * @return int|null
 */
function _grant_dashboard_status_id(string $decision): ?int {
  $name = Civi::settings()->get("grant_dashboard_{$decision}_status");
  $id = CRM_Core_PseudoConstant::getKey('CRM_Grant_BAO_Grant', 'status_id', $name);
  return $id ? (int) $id : NULL;
}
