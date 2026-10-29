<?php
declare(strict_types = 1);

use CRM_GrantDashboard_ExtensionUtil as E;

return [
  'grant_dashboard_submitted_status' => [
    'name' => 'grant_dashboard_submitted_status',
    'type' => 'String',
    'html_type' => 'select',
    'html_attributes' => [
      'class' => 'crm-select2',
    ],
    'pseudoconstant' => [
      'optionGroupName' => 'grant_status',
      'keyColumn' => 'name',
    ],
    'default' => 'Submitted',
    'is_domain' => 1,
    'is_contact' => 0,
    'title' => E::ts('Submitted status'),
    'description' => E::ts('Grant status of grants awaiting a decision.'),
    'settings_pages' => ['grant_dashboard' => ['weight' => 5]],
  ],
  'grant_dashboard_approved_status' => [
    'name' => 'grant_dashboard_approved_status',
    'type' => 'String',
    'html_type' => 'select',
    'html_attributes' => [
      'class' => 'crm-select2',
    ],
    'pseudoconstant' => [
      'optionGroupName' => 'grant_status',
      'keyColumn' => 'name',
    ],
    'default' => 'Approved for Payment',
    'is_domain' => 1,
    'is_contact' => 0,
    'title' => E::ts('Approved status'),
    'description' => E::ts('Grant status applied when a submitted grant is approved.'),
    'settings_pages' => ['grant_dashboard' => ['weight' => 10]],
  ],
  'grant_dashboard_rejected_status' => [
    'name' => 'grant_dashboard_rejected_status',
    'type' => 'String',
    'html_type' => 'select',
    'html_attributes' => [
      'class' => 'crm-select2',
    ],
    'pseudoconstant' => [
      'optionGroupName' => 'grant_status',
      'keyColumn' => 'name',
    ],
    'default' => 'Ineligible',
    'is_domain' => 1,
    'is_contact' => 0,
    'title' => E::ts('Rejected status'),
    'description' => E::ts('Grant status applied when a submitted grant is rejected.'),
    'settings_pages' => ['grant_dashboard' => ['weight' => 20]],
  ],
  'grant_dashboard_paid_status' => [
    'name' => 'grant_dashboard_paid_status',
    'type' => 'String',
    'html_type' => 'select',
    'html_attributes' => [
      'class' => 'crm-select2',
    ],
    'pseudoconstant' => [
      'optionGroupName' => 'grant_status',
      'keyColumn' => 'name',
    ],
    'default' => 'Paid',
    'is_domain' => 1,
    'is_contact' => 0,
    'title' => E::ts('Paid status'),
    'description' => E::ts('Grant status applied when an approved grant is marked as paid.'),
    'settings_pages' => ['grant_dashboard' => ['weight' => 30]],
  ],
];
