ColgateTheScene
===============

Themes for the Colgate The Scene Magazine

Using Ciola and Ciola Child theme.

This repo contains work done to add features and functionality to the homepage.

1) People section moved to it's own row to take up the full width.
    Change was made in the template-new-scene-home-page.php in the Ciola-child theme
    The short code calls a module that references a category to show the people section.
    Added this section
    

```html        
        <div id="mainwide" class="entry-content clearfix">
	    <section class="entry-content clearfix">
		    <?php echo do_shortcode('[module type=g category="People" amount="12" ]'); ?>
	    </section>
	</div>	   
```


		
					
2) New digest section reformatted to match the origina design spec. 
   --Extra links included
   --Category title moved to top right corner with dark red background
   --Title of the story moved down and in blue
   
3) Photo gallery added. Uses posts under the Featured Photos category. 
   --Created a new module (moduel-m.php in Ciola theme) use for rendering the photos.
   --Added jquery.colorbox-min.js and modal.js to Ciola/library/js folder for use in the photo gallery.
   --Added this to the template-new-scene-home-page.php in Ciola-child theme
   
   
```html        
   <!-- 
		
		New photo gallery section using a new module page specifically for photos.
		Section uses the jquery.colorbox-min.js and modal.js files.
	
	-->
	<div class="clearfix" id="photogallery">
		<div  class="entry-content clearfix">
		    <section class="entry-content clearfix">
			    <?php echo do_shortcode('[module type=m category="Photos" amount="12" ]'); ?>
		    </section> 
		</div>
	</div>
```


