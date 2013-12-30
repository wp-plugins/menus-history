jQuery(document).ready( function() {
    loadRevisions();
    jQuery('#menus-history-menus').on('change', loadRevisions);
})

function loadRevisions() {
    var data = {
        'term_id':jQuery('#menus-history-menus').find('option:selected').val(),
        'action':'get_revisions'
    }
    
    jQuery("#menus-history-revisions").html("<p class='loader'>Loading...</p>");
    
    jQuery.post(ajaxurl, data, function(response) {
        
        if( response.empty ) {
            jQuery('#menus-history-revision').hide();
        }
        else {
             jQuery('#menus-history-revision').html("<p class='loader'>Loading...</p>").show();
        }
        
        jQuery("#menus-history-revisions").html(response.html);
        
        jQuery('#revision-list input').on('change',function(e) {
            var data = {
                'revision_id': jQuery(e.currentTarget).val(),
                'action':'get_revision'
            }
            jQuery.post(ajaxurl, data, function(response) {
                jQuery("#menus-history-revision").html(response).show();
            });
        });
        
         jQuery('#revision-list input').eq(0).click();
    },'json');
}