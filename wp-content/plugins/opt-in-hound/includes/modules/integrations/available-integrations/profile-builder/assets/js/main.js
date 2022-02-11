/**
 * Function that adds the Subscribe field to the global fields object
 * declared in assets/js/jquery-manage-fields-live-change.js
 *
 */
function oih_wppb_add_field() {

    if (typeof fields == "undefined") {
        return false;
    }

    fields["Opt-In Hound Subscribe"] = {
        'show_rows'	:	[
            '.row-field-title',
            '.row-field',
            '.row-oih-subscribe-message',
            '.row-oih-subscribe-default-checked',
            '.row-oih-subscribe-subscriber-lists'
        ],
        'properties':	{
            'meta_name_value' : ''
        }
    };
}

jQuery( function() {
    oih_wppb_add_field();
});