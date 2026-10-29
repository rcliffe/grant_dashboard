<?php
declare(strict_types = 1);

use CRM_GrantDashboard_ExtensionUtil as E;

return [
  [
    'name' => 'Navigation_Grants_Navigation_Approved_Grants',
    'entity' => 'Navigation',
    'cleanup' => 'always',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'label' => E::ts('Approved Grants'),
        'name' => 'Approved Grants',
        'url' => 'civicrm/grant/approved?reset=1',
        'icon' => NULL,
        'permission' => 'access CiviGrant',
        'permission_operator' => '',
        'parent_id.name' => 'Grants',
        'is_active' => TRUE,
        'weight' => 4,
        'domain_id' => 'current_domain',
      ],
      'match' => ['domain_id', 'name'],
    ],
  ],
];
