function init_postcodeBlock(blockId, address_table_id) {
    var first_row = cj(address_table_id + ' tbody tr:first');
    first_row.before(zipcodes_getRowHtml(blockId)); 
    zipcodes_addOnChange(blockId);
    zipcodes_addAutocomplete(blockId);
}

function zipcodes_getRowHtml(blockId) {
    var html = '<tr class="zipcodes_input_row"><td>';
    html = html + 'Postcode lookup<br>';
    html = html + '<input type="text" class="form-text huge" id="zipcode_lookup_'+blockId+'" value="" />';
    html = html + '</td><td></td><td></td></tr>';
    return html;
}

function zipcodes_addAutocomplete(blockId) {
    cj('#zipcode_lookup_'+blockId).autocomplete(CRM.url('civicrm/ajax/zipcodes/autocomplete'), {
       //width: 200,
       //selectFirst: true,
       //matchContains: true       
    }).result(function(event, data) {
        zipcodes_fill(blockId);
    });
}

function zipcodes_addOnChange(blockId) {
    cj('#zipcode_lookup_'+blockId).blur(function (e) {
        zipcodes_fill(blockId);
    });
}

function zipcodes_fill(blockId) {
    var value = cj('#zipcode_lookup_'+blockId).val();
    var values = value.split(' - ');
    if(values[0] && values[1]) {
        cj('#address_' + blockId + '_postal_code').val(values[0]);
        cj('#address_' + blockId + '_city').val(values[1]);
    }
}

/**
 * 
 * remove all lookup widgets
 */
function zipcodes_reset() {
    cj('.zipcodes_input_row').remove();
}


cj(function() {
    cj.each(['show', 'hide'], function (i, ev) {
        var el = cj.fn[ev];
        cj.fn[ev] = function () {
          this.trigger(ev);
          return el.apply(this, arguments);
        };
      });
});