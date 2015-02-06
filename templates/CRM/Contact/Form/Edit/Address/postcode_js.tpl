{*
 * File for the inline address block
 *}

{literal}
<script type="text/javascript">
CRM.$(function($) {
  //
  // Common
  //
  function init_postcodeBlock(blockId, address_table_id) {
    var city_field_td = $(address_table_id + ' #address_'+blockId+'_city').parent();
    var postalcode_field_td = $(address_table_id + ' #address_'+blockId+'_postal_code').parent();
    //postalcode_field_td.detach();
    city_field_td.parent().prepend(postalcode_field_td);
    var first_row = city_field_td.parent().parent().parent().parent().parent();
    first_row.before(zipcodes_getRowHtml(blockId));
    zipcodes_addOnChange(blockId);
    zipcodes_addAutocomplete(blockId);
  }

  function zipcodes_getRowHtml(blockId) {
    var html = '<tr class="zipcodes_input_row"><td>';
    html = html + 'Postal Code Lookup<br>';
    html = html + '<input type="text" class="form-text huge" id="zipcode_lookup_'+blockId+'" value="" />';
    html = html + '<input type="hidden" id="zipcode_lookup_'+blockId+'_id" />';
    html = html + '</td><td></td><td></td></tr>';
    return html;
  }
  
  function zipcodes_addAutocomplete(blockId) {
    $('#zipcode_lookup_'+blockId).autocomplete({
      source: "/civicrm/ajax/zipcodes/autocomplete",
      minLength: 1,
      select: function(event, ui) {
        $('#zipcode_lookup_'+blockId+'_id').val(ui.item.id);
        zipcodes_fill(blockId);
      }
    })
    .autocomplete("instance")._renderItem = function(ul, item) {
      return $("<li>").attr("value", item.value).append(item.label).appendTo(ul);
    }
  }
 
  function zipcodes_addOnChange(blockId) {
    $('#zipcode_lookup_'+blockId).blur(function (e) {
        zipcodes_fill(blockId);
    });
  }
  
  function zipcodes_fill(blockId) {
    var value = $('#zipcode_lookup_'+blockId+'_id').val();
    var values = value.split('|');
    if(values[0] && values[1] && values[2]) {
      if (values[2] != $('#address_' + blockId + '_country_id').val()) {
        $('#address_' + blockId + '_country_id').select2('val', values[2]);
        $('#address_' + blockId + '_country_id').change();
      }
      $('#address_' + blockId + '_postal_code').val(values[0]);
      $('#address_' + blockId + '_city').val(values[1]);
      $('#address_' + blockId + '_state_province_id').select2('val', values[3]);
    }
  }

  function zipcodes_reset() {
    $('.zipcodes_input_row').remove();
  }
  //
  // End common
  //

  function insert_row_{/literal}{$blockId}{literal}() {
    init_postcodeBlock('{/literal}{$blockId}{literal}', '#address_table_{/literal}{$blockId}{literal}');
  }

  $(function(e) {
    console.log("Calling insert_row");
    insert_row_{/literal}{$blockId}{literal}();
  });

});
</script>
{/literal}
