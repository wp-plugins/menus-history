 <?php if ( $revisions->have_posts() ) : ?>
        
<fieldset id="revision-list">
    <ul>
    <?php foreach( $revisions->posts as $key=>$revision ) : ?>
       <li> <label><input name="menus-history-revision" type="radio" value="<?php echo $revision->ID ?>"/> <?php echo get_the_author_meta('display_name', $revision->post_author) . '; ' . $revision->post_date . ( $key===0 ? ' <span class="latest">(Latest)</span>' : 0 ) ?></label></li>
    <?php endforeach ?>
    </ul>
</fieldset>

<?php endif ?>