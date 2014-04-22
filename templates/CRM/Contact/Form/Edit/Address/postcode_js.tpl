{*
 * File for the inline address block
 *}

{literal}
<script type="text/javascript">
function insert_row_{/literal}{$blockId}{literal}() {
    init_postcodeBlock('{/literal}{$blockId}{literal}', '#address_table_{/literal}{$blockId}{literal}');
}

cj(function(e) {
    insert_row_{/literal}{$blockId}{literal}();
});

</script>
{/literal}