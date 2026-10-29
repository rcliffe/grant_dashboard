<div class="crm-content-block">
  {if $canAdminister}
    <div class="action-link">
      <a class="button" href="{crmURL p='civicrm/admin/setting/grant_dashboard' q='reset=1'}"><i class="crm-i fa-wrench" aria-hidden="true"></i> {ts}Decision Settings{/ts}</a>
    </div>
  {/if}
  {if $grants}
    <table class="selector row-highlight" id="grant-dashboard-approved-grants">
      <thead>
        <tr>
          <th>{ts}Contact{/ts}</th>
          <th>{ts}Grant Type{/ts}</th>
          <th>{ts}Amount Granted{/ts}</th>
          <th>{ts}Decision Date{/ts}</th>
          {if $canEdit}
            <th>{ts}Money Transfer Date{/ts}</th>
            <th></th>
          {/if}
          <th></th>
        </tr>
      </thead>
      <tbody>
        {foreach from=$grants item=grant}
          <tr class="{cycle values="odd-row,even-row"}" data-grant-id="{$grant.id}">
            <td><a href="{crmURL p='civicrm/contact/view' q="reset=1&cid=`$grant.contact_id`"}">{$grant['contact_id.display_name']|escape}</a></td>
            <td>{$grant['grant_type_id:label']|escape}</td>
            <td>{$grant.amount_granted|crmMoney:$grant.currency}</td>
            <td>{$grant.decision_date|crmDate}</td>
            {if $canEdit}
              <td><input type="date" class="crm-form-text grant-transfer-date" value="{$today}" aria-label="{ts}Money Transfer Date{/ts}"></td>
              <td class="nowrap">
                <button type="button" class="crm-button grant-mark-paid" data-status="{$paidStatus|escape}"><i class="crm-i fa-money" aria-hidden="true"></i> {ts}Mark as Paid{/ts}</button>
              </td>
            {/if}
            <td><a href="{crmURL p='civicrm/grant/view' q="reset=1&action=view&id=`$grant.id`&cid=`$grant.contact_id`"}">{ts}View{/ts}</a></td>
          </tr>
        {/foreach}
      </tbody>
    </table>
  {else}
    <div class="messages status no-popup">{ts}There are no grants awaiting payment.{/ts}</div>
  {/if}
</div>

{if $canEdit}
{literal}
<script type="text/javascript">
  CRM.$(function($) {
    $('#grant-dashboard-approved-grants').on('click', 'button.grant-mark-paid', function() {
      var $row = $(this).closest('tr'),
        transferDate = $row.find('.grant-transfer-date').val();

      if (!transferDate) {
        CRM.alert(ts('Please enter a money transfer date.'), ts('Missing value'), 'error');
        return;
      }

      $row.find('button, input').prop('disabled', true);
      CRM.api4('Grant', 'update', {
        where: [['id', '=', $row.data('grant-id')]],
        values: {'status_id:name': $(this).data('status'), money_transfer_date: transferDate}
      })
        .then(function() {
          CRM.status(ts('Grant marked as paid'));
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
