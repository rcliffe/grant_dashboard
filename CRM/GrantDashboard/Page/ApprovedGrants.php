<?php
declare(strict_types = 1);

use CRM_GrantDashboard_ExtensionUtil as E;

/**
 * Lists grants that have been approved for payment and allows them to be marked as paid.
 */
class CRM_GrantDashboard_Page_ApprovedGrants extends CRM_Core_Page {

  public function run() {
    CRM_Utils_System::setTitle(E::ts('Approved Grants'));

    $grants = \Civi\Api4\Grant::get()
      ->addSelect('id', 'contact_id', 'contact_id.display_name', 'grant_type_id:label', 'amount_granted', 'currency', 'decision_date')
      ->addWhere('status_id:name', '=', Civi::settings()->get('grant_dashboard_approved_status'))
      ->addOrderBy('decision_date', 'ASC')
      ->execute();

    $this->assign('grants', (array) $grants);
    $this->assign('canEdit', CRM_Core_Permission::check('edit grants'));
    $this->assign('canAdminister', CRM_Core_Permission::check('administer CiviCRM'));
    $this->assign('today', date('Y-m-d'));
    // grant_status option name applied by the Mark as Paid button.
    $this->assign('paidStatus', Civi::settings()->get('grant_dashboard_paid_status'));

    parent::run();
  }

}
