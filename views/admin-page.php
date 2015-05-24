 <div class="wrap">
        
    <h2>Menus History</h2>

    <div id="menus-history-selection" class="postbox">
        <h3 class="title">Menu</h3>
        <select id="menus-history-menus" class="widefat">
            <?php foreach( $my_menus as $menu ) : ?>
                <option value="<?php echo $menu->term_id ?>"><?php echo $menu->name ?></option>
            <?php endforeach ?>
        </select>
        
        <h3 class="title">Revisions</h3>
        
        <div id="menus-history-revisions">
        
        </div>
    </div>
    
    <div id="menus-history-revision" class="postbox">
    
    </div>
    
    <div style="clear:both"></div>

</div>