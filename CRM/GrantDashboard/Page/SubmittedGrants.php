<?php
declare(strict_types = 1);

use CRM_GrantDashboard_ExtensionUtil as E;

/**
 * Lists grants with a status of "Submitted" and allows them to be approved or rejected.
 */
class CRM_GrantDashboard_Page_SubmittedGrants extends CRM_Core_Page {

  public function run() {
    CRM_Utils_System::setTitle(E::ts('Submitted Grants'));

    // Sort direction for the application received date; newest first by default.
    $sort = CRM_Utils_Request::retrieveValue('sort', 'String') === 'asc' ? 'asc' : 'desc';

    $grants = \Civi\Api4\Grant::get()
      ->addSelect('id', 'contact_id', 'contact_id.display_name', 'grant_type_id:label', 'amount_total', 'amount_requested', 'currency', 'application_received_date')
      ->addWhere('status_id:name', '=', Civi::settings()->get('grant_dashboard_submitted_status'))
      ->addOrderBy('application_received_date', strtoupper($sort))
      ->addOrderBy('id', strtoupper($sort))
      ->execute();

    $this->assign('grants', (array) $grants);
    $this->assign('sort', $sort);
    $this->assign('canEdit', CRM_Core_Permission::check('edit grants'));
    $this->assign('today', date('Y-m-d'));
    // grant_status option names applied by the Approve and Reject buttons.
    $this->assign('approvedStatus', Civi::settings()->get('grant_dashboard_approved_status'));
    $this->assign('rejectedStatus', Civi::settings()->get('grant_dashboard_rejected_status'));
    $this->assign('canAdminister', CRM_Core_Permission::check('administer CiviCRM'));

    parent::run();
  }

}
