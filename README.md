# Grant Decision & Payment Dashboard

Dashboard pages for working through CiviGrant applications: approve or reject submitted grants, then mark approved grants as paid.

This is an [extension for CiviCRM](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/), licensed under [AGPL-3.0](LICENSE.txt). It requires the CiviGrant extension.

## Getting Started

After installing, two pages are added to the **Grants** menu:

- **Submitted Grants** (`civicrm/grant/submitted`) lists grants awaiting a decision. Enter a decision date and amount agreed, then click **Approve** or **Reject**. The list can be sorted by application received date.
- **Approved Grants** (`civicrm/grant/approved`) lists approved grants. Enter the money transfer date and click **Mark as Paid**.

Under **Administer › CiviGrant › Grant Decision Settings**, choose which grant statuses mean submitted, approved, rejected and paid.

Approving and rejecting needs the "edit grants" permission; the settings page needs "administer CiviCRM".

## Rules

However a grant is saved (these pages, the grant edit form or the API):

- an approved grant must have an amount granted greater than 0;
- a rejected grant always has an amount granted of 0.
