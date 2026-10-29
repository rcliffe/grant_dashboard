<div class="crm-content-block">
  {if $canAdminister}
    <div class="action-link">
      <a class="button" href="{crmURL p='civicrm/admin/setting/grant_dashboard' q='reset=1'}"><i class="crm-i fa-wrench" aria-hidden="true"></i> {ts}Decision Settings{/ts}</a>
    </div>
  {/if}
  {if $grants}
    <table class="selector row-highlight" id="grant-dashboard-submitted-grants">
      <thead>
        <tr>
          <th>{ts}Contact{/ts}</th>
          <th>{ts}Grant Type{/ts}</th>
          <th>{ts}Amount Requested{/ts}</th>
          <th>{ts}Amount Total{/ts}</th>
          <th aria-sort="{if $sort == 'asc'}ascending{else}descending{/if}">
            {if $sort == 'asc'}
              <a href="{crmURL p='civicrm/grant/submitted' q='reset=1&sort=desc'}" title="{ts}Sort newest first{/ts}">{ts}Application Received{/ts} <i class="crm-i fa-sort-asc" aria-hidden="true"></i></a>
            {else}
              <a href="{crmURL p='civicrm/grant/submitted' q='reset=1&sort=asc'}" title="{ts}Sort oldest first{/ts}">{ts}Application Received{/ts} <i class="crm-i fa-sort-desc" aria-hidden="true"></i></a>
            {/if}
          </th>
          {if $canEdit}
            <th>{ts}Decision Date{/ts}</th>
            <th>{ts}Amount Agreed{/ts}</th>
            <th>{ts}Decision{/ts}</th>
          {/if}
          <th></th>
        </tr>
      </thead>
      <tbody>
        {foreach from=$grants item=grant}
          <tr class="{cycle values="odd-row,even-row"}" data-grant-id="{$grant.id}">
            <td><a href="{crmURL p='civicrm/contact/view' q="reset=1&cid=`$grant.contact_id`"}">{$grant['contact_id.display_name']|escape}</a></td>
            <td>{$grant['grant_type_id:label']|escape}</td>
            <td>{$grant.amount_requested|crmMoney:$grant.currency}</td>
            <td>{$grant.amount_total|crmMoney:$grant.currency}</td>
            <td>{$grant.application_received_date|crmDate}</td>
            {if $canEdit}
              <td><input type="date" class="crm-form-text grant-decision-date" value="{$today}" aria-label="{ts}Decision Date{/ts}"></td>
              <td><input type="number" class="crm-form-text grant-amount-agreed" min="0" step="0.01" size="10" value="{$grant.amount_requested}" aria-label="{ts}Amount Agreed{/ts}"></td>
              <td class="nowrap">
                <button type="button" class="crm-button grant-decision" data-action="approve" data-status="{$approvedStatus|escape}"><i class="crm-i fa-check" aria-hidden="true"></i> {ts}Approve{/ts}</button>
                <button type="button" class="crm-button grant-decision" data-action="reject" data-status="{$rejectedStatus|escape}"><i class="crm-i fa-times" aria-hidden="true"></i> {ts}Reject{/ts}</button>
              </td>
            {/if}
            <td><a href="{crmURL p='civicrm/grant/view' q="reset=1&action=view&id=`$grant.id`&cid=`$grant.contact_id`"}">{ts}View{/ts}</a></td>
          </tr>
        {/foreach}
      </tbody>
    </table>
  {else}
    <div class="messages status no-popup">{ts}There are no grants awaiting a decision.{/ts}</div>
  {/if}
</div>

{if $canEdit}
{literal}
<script type="text/javascript">
  CRM.$(function($) {
    $('#grant-dashboard-submitted-grants').on('click', 'button.grant-decision', function() {
      var $row = $(this).closest('tr'),
        status = $(this).data('status'),
        approving = $(this).data('action') === 'approve',
        decisionDate = $row.find('.grant-decision-date').val(),
        amount = $row.find('.grant-amount-agreed').val(),
        values = {'status_id:name': status, decision_date: decisionDate};

      if (!decisionDate) {
        CRM.alert(ts('Please enter a decision date.'), ts('Missing value'), 'error');
        return;
      }
      // Approved grants need an amount above 0; rejected grants are always 0.
      if (approving && (amount === '' || Number(amount) <= 0)) {
        CRM.alert(ts('An approved grant must have an amount agreed greater than 0.'), ts('Invalid amount'), 'error');
        return;
      }
      values.amount_granted = approving ? amount : 0;

      $row.find('button, input').prop('disabled', true);
      CRM.api4('Grant', 'update', {where: [['id', '=', $row.data('grant-id')]], values: values})
        .then(function() {
          CRM.status(approving ? ts('Grant approved') : ts('Grant rejected'));
          $row.fadeOut(400, function() { $row.remove(); });
        }, function(error) {
          $row.find('button, input').prop('disabled', false);
          CRM.alert(error.error_message || ts('Unable to update grant.'), ts('Error'), 'error');
        });
    });
  });
</script>
{/literal}
{/if}
