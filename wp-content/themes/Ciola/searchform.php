<!-- Searchform -->
<?php $cb_search_box_default = ot_get_option('cb_search_box_default'); ?>

<form role="search" method="get" class="search" action="<?php echo home_url( '/' ); ?>">
    
    <input type="text" class="cb-search-field" placeholder="<?php echo $cb_search_box_default; ?>" value="" name="s" title="">
    <input class="cb-search-submit" type="submit" value="">
    
</form>


<!-- /Searchform -->