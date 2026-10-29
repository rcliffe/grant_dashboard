<?php
declare(strict_types = 1);

use CRM_GrantDashboard_ExtensionUtil as E;

return [
  [
    'name' => 'Navigation_Grants_Navigation_Submitted_Grants',
    'entity' => 'Navigation',
    'cleanup' => 'always',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'label' => E::ts('Submitted Grants'),
        'name' => 'Submitted Grants',
        'url' => 'civicrm/grant/submitted?reset=1',
        'icon' => NULL,
        'permission' => 'access CiviGrant',
        'permission_operator' => '',
        'parent_id.name' => 'Grants',
        'is_active' => TRUE,
        'weight' => 3,
        'domain_id' => 'current_domain',
      ],
      'match' => ['domain_id', 'name'],
    ],
  ],
];
