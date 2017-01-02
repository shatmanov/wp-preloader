<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/chasing-dots.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/circle.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/cube-grid.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/double-bounce.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/fading-circle.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/folding-cube.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/pulse.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/rotating-plane.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/three-bounce.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/wandering-cubes.css" rel="stylesheet">
<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/wave.css" rel="stylesheet">

<link href="<?php echo WP_PRELOADER_THEMES_URL; ?>/css/ball-pulse.css" rel="stylesheet">

    <style>
    	#wppl_form {}
		#wppl_form [type="text"] {
			width: 80%;
			float: left;
			background-color: #f9f9f9;
			border: 1px solid #e0e0e0;
			outline: none;
			padding: 8px;
		}
		#wppl_form select {
			width: 80%;
			float: left;
			background-color: #f9f9f9;
			border: 1px solid #e0e0e0;
			outline: none;
			height: inherit;
			padding: 8px;
			resize: none;
			-webkit-transition: all .1s ease-in-out;
			-moz-transition: all .1s ease-in-out;
			-o-transition: all .1s ease-in-out;
			transition: all .1s ease-in-out;
		}
		<?php echo WPpreloader_spinner_classExample(get_option('wppl_spin'), get_option('wppl_color')); ?>
	</style>
    <div id="styleExample"></div>

    
    <form method="post" action="options.php" id="wppl_form">
    <?php settings_fields('WPpreloader-settings-group'); ?>
    	<table class="form-table">
            <tr valign="top">
    			<th width="210" scope="row"><?php echo __( 'On/Off WP preLoader', 'WPpreloader' ); ?></th>
    			<td width="270">
                <input type="radio" name="wppl_enable" value="on"<?php if (get_option('wppl_enable')=='on'){echo ' checked'; } ?>>on<br>
                <input type="radio" name="wppl_enable" value="off"<?php if (get_option('wppl_enable')=='off'){echo ' checked'; } ?>>off
                </td>
    			<td rowspan="5" align="center" valign="middle" id="WPpreloaderExample" style="background-color: <?php echo get_option('wppl_background'); ?>; color: <?php echo get_option('wppl_color'); ?>;">
                <span class="wppl_spin"><?php echo WPpreloader_spinner(get_option('wppl_spin')); ?></span><br />
                <span class="wppl_text"><?php echo get_option('wppl_text'); ?></span>
                </td>
    		</tr>
    		<tr valign="top">
    			<th width="210" scope="row"><?php echo __( 'Loading spinner style', 'WPpreloader' ); ?></th>
    			<td width="270">
                	<select name="wppl_spin" class="wppl_spin">
                    <?php
                	$skip = array('.', '..');
                	$files = scandir(WP_PRELOADER_INC_URL.'/css/');
                	foreach($files as $file) {
                		if(!in_array($file, $skip)){
                			if (get_option('wppl_spin')==$file){$selected = ' selected="selected"';}else{$selected = '';}
							echo '<option value="'.$file.'"'.$selected.'>'.$file.'</option>';
						}
                	}
                    ?>
                	</select></td>
   			</tr>
            <tr valign="top">
    			<th width="210" scope="row"><?php echo __( 'Loading text', 'WPpreloader' ); ?></th>
    			<td width="270"><input name="wppl_text" class="wppl_text" type="text" value="<?php echo get_option('wppl_text'); ?>"></td>
   			</tr>
    		<tr valign="top">
    			<th width="210" scope="row"><?php echo __( 'Background color', 'WPpreloader' ); ?></th>
    			<td width="270"><input type="text" class="wppl_background" value="<?php echo get_option('wppl_background'); ?>" name="wppl_background" /></td>
   			</tr>
            <tr valign="top">
    			<th width="210" scope="row"><?php echo __( 'Spinner & text color', 'WPpreloader' ); ?></th>
    			<td width="270"><input type="text" class="wppl_color" value="<?php echo get_option('wppl_color'); ?>" name="wppl_color" />
                </td>
   			</tr>
    	</table>  
        <input type="submit" class="button-primary" action="?page=WPpreloader" value="<?php echo __( 'Save', 'WPpreloader' ); ?>" />
    </form>
    
<!--<form id="featured_upload" method="post" action="#" enctype="multipart/form-data">
	<input type="file" name="my_image_upload" id="my_image_upload"  multiple="false" />
	<input type="hidden" name="post_id" id="post_id" value="55" />
	<?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
	<input id="submit_my_image_upload" name="submit_my_image_upload" type="submit" value="Upload" />
</form>-->
    
<script type="text/javascript">
jQuery(document).ready(function($){	
	var wppl_backgroundOptions = {
    	change: function(event, ui){
			$("#WPpreloaderExample").css( "background-color", $(this).val() );
		}
	};
    $('.wppl_background').wpColorPicker(wppl_backgroundOptions);
	
	var wppl_colorOptions = {
    	change: function(event, ui){
			var colorwpl = $(this).val();
			$("#WPpreloaderExample").css( "color", colorwpl );
			var wppl_spin_sel = $('.wppl_spin option:selected').val();
			switch (wppl_spin_sel) {
				case 'chasing-dots.css':
					$('#styleExample').html('<style>.wppl-chasing-dots .wppl-child{background-color:'+colorwpl+'}</style>');		
				break;
			
				case 'circle.css':
					$('#styleExample').html('<style>.wppl-circle .wppl-child:before{background-color:'+colorwpl+'}</style>');	
				break;
			
				case 'cube-grid.css':
					$('#styleExample').html('<style>.wppl-cube-grid .wppl-cube{background-color:'+colorwpl+'}</style>');		
				break;
			
				case 'double-bounce.css':
					$('#styleExample').html('<style>.wppl-double-bounce .wppl-child{background-color:'+colorwpl+'}</style>');		
				break;
			
				case 'fading-circle.css':
					$('#styleExample').html('<style>.wppl-fading-circle .wppl-circle:before{background-color:'+colorwpl+'}</style>');		
				break;
			
				case 'folding-cube.css':
					$('#styleExample').html('<style>.wppl-folding-cube .wppl-cube:before{background-color:'+colorwpl+'}</style>');		
				break;
			
				case 'pulse.css':
					$('#styleExample').html('<style>.wppl-spinner-pulse{background-color:'+colorwpl+'}</style>');			
				break;
			
				case 'rotating-plane.css':
					$('#styleExample').html('<style>.wppl-rotating-plane{background-color:'+colorwpl+'}</style>');		
				break;
			
				case 'three-bounce.css':
					$('#styleExample').html('<style>.wppl-three-bounce .wppl-child{background-color:'+colorwpl+'}</style>');		
				break;
			
				case 'wandering-cubes.css':
					$('#styleExample').html('<style>.wppl-wandering-cubes .wppl-cube{background-color:'+colorwpl+'}</style>');		
				break;
			
				case 'wave.css':
					$('#styleExample').html('<style>.wppl-wave .wppl-rect{background-color:'+colorwpl+'}</style>');		
				break;
				
				case 'ball-pulse.css':
					$('#styleExample').html('<style>.wppl-ballpulse > div{background-color:'+colorwpl+'}</style>');		
				break;
					
				default:
					$('#styleExample').html('<style>.wppl-rotating-plane{background-color:'+colorwpl+'}</style>');
			}
		}
	};
    $('.wppl_color').wpColorPicker(wppl_colorOptions);
	
	$('.wppl_text').keyup(function () {
		var value = $(this).val();
		$('#WPpreloaderExample span.wppl_text').text(value);
	}).keyup();
	
	$('.wppl_spin').change(function () {
		var value = $(this).val();
		//$('#WPpreloaderExample span.wppl_spin').text(value);
		var colorwpl = $('.wppl_color').val();
		switch (value) {
			case 'chasing-dots.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-chasing-dots"><div class="wppl-child wppl-dot1"></div><div class="wppl-child wppl-dot2"></div></div>');
				$('#styleExample').html('<style>.wppl-chasing-dots .wppl-child{background-color:'+colorwpl+'}</style>');	
			break;
			
			case 'circle.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-circle"><div class="wppl-circle1 wppl-child"></div><div class="wppl-circle2 wppl-child"></div><div class="wppl-circle3 wppl-child"></div><div class="wppl-circle4 wppl-child"></div><div class="wppl-circle5 wppl-child"></div><div class="wppl-circle6 wppl-child"></div><div class="wppl-circle7 wppl-child"></div><div class="wppl-circle8 wppl-child"></div><div class="wppl-circle9 wppl-child"></div><div class="wppl-circle10 wppl-child"></div><div class="wppl-circle11 wppl-child"></div><div class="wppl-circle12 wppl-child"></div></div>');
				$('#styleExample').html('<style>.wppl-circle .wppl-child:before{background-color:'+colorwpl+'}</style>');		
			break;
			
			case 'cube-grid.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-cube-grid"><div class="wppl-cube wppl-cube1"></div><div class="wppl-cube wppl-cube2"></div><div class="wppl-cube wppl-cube3"></div><div class="wppl-cube wppl-cube4"></div><div class="wppl-cube wppl-cube5"></div><div class="wppl-cube wppl-cube6"></div><div class="wppl-cube wppl-cube7"></div><div class="wppl-cube wppl-cube8"></div><div class="wppl-cube wppl-cube9"></div></div>');	
				$('#styleExample').html('<style>.wppl-cube-grid .wppl-cube{background-color:'+colorwpl+'}</style>');		
			break;
			
			case 'double-bounce.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-double-bounce"><div class="wppl-child wppl-double-bounce1"></div><div class="wppl-child wppl-double-bounce2"></div></div>');	
				$('#styleExample').html('<style>.wppl-double-bounce .wppl-child{background-color:'+colorwpl+'}</style>');	
			break;
			
			case 'fading-circle.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-fading-circle"><div class="wppl-circle1 wppl-circle"></div><div class="wppl-circle2 wppl-circle"></div><div class="wppl-circle3 wppl-circle"></div><div class="wppl-circle4 wppl-circle"></div><div class="wppl-circle5 wppl-circle"></div><div class="wppl-circle6 wppl-circle"></div><div class="wppl-circle7 wppl-circle"></div><div class="wppl-circle8 wppl-circle"></div><div class="wppl-circle9 wppl-circle"></div><div class="wppl-circle10 wppl-circle"></div><div class="wppl-circle11 wppl-circle"></div><div class="wppl-circle12 wppl-circle"></div></div>');		
				$('#styleExample').html('<style>.wppl-fading-circle .wppl-circle:before{background-color:'+colorwpl+'}</style>');
			break;
			
			case 'folding-cube.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-folding-cube"><div class="wppl-cube1 wppl-cube"></div><div class="wppl-cube2 wppl-cube"></div><div class="wppl-cube4 wppl-cube"></div><div class="wppl-cube3 wppl-cube"></div></div>');	
				$('#styleExample').html('<style>.wppl-folding-cube .wppl-cube:before{background-color:'+colorwpl+'}</style>');	
			break;
			
			case 'pulse.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-spinner wppl-spinner-pulse"></div>');
				$('#styleExample').html('<style>.wppl-spinner-pulse{background-color:'+colorwpl+'}</style>');			
			break;
			
			case 'rotating-plane.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-rotating-plane"></div>');	
				$('#styleExample').html('<style>.wppl-rotating-plane{background-color:'+colorwpl+'}</style>');	
			break;
			
			case 'three-bounce.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-three-bounce"><div class="wppl-child wppl-bounce1"></div><div class="wppl-child wppl-bounce2"></div><div class="wppl-child wppl-bounce3"></div></div>');
				$('#styleExample').html('<style>.wppl-three-bounce .wppl-child{background-color:'+colorwpl+'}</style>');
			break;
			
			case 'wandering-cubes.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-wandering-cubes"><div class="wppl-cube wppl-cube1"></div><div class="wppl-cube wppl-cube2"></div></div>');
				$('#styleExample').html('<style>.wppl-wandering-cubes .wppl-cube{background-color:'+colorwpl+'}</style>');		
			break;
			
			case 'wave.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-wave"><div class="wppl-rect wppl-rect1"></div><div class="wppl-rect wppl-rect2"></div><div class="wppl-rect wppl-rect3"></div><div class="wppl-rect wppl-rect4"></div><div class="wppl-rect wppl-rect5"></div></div>');
				$('#styleExample').html('<style>.wppl-wave .wppl-rect{background-color:'+colorwpl+'}</style>');		
			break;
			
			case 'ball-pulse.css':
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-ballpulse"><div></div><div></div><div></div></div>');
				$('#styleExample').html('<style>.wppl-ballpulse > div{background-color:'+colorwpl+'}</style>');		
			break;
					
			default:
				$('#WPpreloaderExample span.wppl_spin').html('<div class="wppl-rotating-plane"></div>');
				$('#styleExample').html('<style>.wppl-rotating-plane{background-color:'+colorwpl+'}</style>');
		}

	});
	


});
</script>