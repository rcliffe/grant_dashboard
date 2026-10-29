<?php
declare(strict_types = 1);

use CRM_GrantDashboard_ExtensionUtil as E;

return [
  [
    'name' => 'Navigation_CiviGrant_Navigation_Grant_Decision_Settings',
    'entity' => 'Navigation',
    'cleanup' => 'always',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'label' => E::ts('Grant Decision Settings'),
        'name' => 'Grant Decision Settings',
        'url' => 'civicrm/admin/setting/grant_dashboard?reset=1',
        'icon' => NULL,
        'permission' => 'access CiviGrant,administer CiviCRM',
        'permission_operator' => 'AND',
        'parent_id.name' => 'CiviGrant',
        'is_active' => TRUE,
        'domain_id' => 'current_domain',
      ],
      'match' => ['domain_id', 'name'],
    ],
  ],
];
