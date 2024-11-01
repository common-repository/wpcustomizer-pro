<?php
/**
 * Visual Styler FrontEnd Editor Functions
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");

/**
 * @param $tabFields array of tab fields
 * e.g $vStylerCSSOptions['tab-general']
 *
 * Render tab fields
 */
function vStyler_render_customizer_tab($tabFields){

	if(is_array($tabFields)){
		foreach($tabFields as $field){
			vStyler_render_customizer_field($field);
		}
	}
}

/**
 * @param $field array of field details
 *
 * Render field
 */
function vStyler_render_customizer_field($field){
	if(array_key_exists('field',$field)) {
		$fieldClass=isset($field['class'])?$field['class']:'';
		$fieldTitle=isset($field['title'])?$field['title']:'';
		$fieldType=isset($field['field']['type'])?$field['field']['type']:'text';
		$fielAllowUploader=isset($field['field']['allow-uploader'])?$field['field']['allow-uploader']:false;
		echo '<div class="vs-customizer-field-wrapper vs-field-type-'.$fieldType.'">';
		echo '<label>'.$fieldTitle.' ';
		echo '</label>';
		switch ($fieldType){
			case 'text': ?>
				<input class="<?php echo $fieldClass;?>" type="text" name="<?php echo $field['name'];?>" id="<?php echo $field['name'];?>" value="" />
				<?php
				break;
			case 'dropdown':
				if(is_array($field['field']['options'])){
					echo '<div class="field-combobox-wrapper">';?>
					<select class="field-combobox-list" >
						<?php
						foreach($field['field']['options'] as $k=>$v){
							?>
							<option value="<?php echo $k;?>"><?php echo $v;?></option>
						<?php
						}
						?>
					</select>
					<input class="field-combobox <?php echo $fieldClass;?>" type="text" name="<?php echo $field['name'];?>" id="<?php echo $field['name'];?>">
				<?php
					echo '</div>';
				}
				break;
			case 'slider':
				echo '<div class="field-slider-wrapper">';
				echo '<div class="field-slider-box"></div>';?>
				<input class="field-slider <?php echo $fieldClass;?>" type="text" name="<?php echo $field['name'];?>"  id="<?php echo $field['name'];?>" value="" />
				<?php
				echo '</div>';
				break;
			case 'colorpicker':
				$defaultColor=$field['default']?('data-default-color="'.$field['default'].'"'):""; ?>
				<input class="field-colorpicker <?php echo $fieldClass;?>" type="text" name="<?php echo $field['name'];?>" id="<?php echo $field['name'];?>" value="" <?php echo $defaultColor;?> />
				<?php
				break;
		}
		if($fielAllowUploader===true){
			echo '<a href="#" title="Add Image" class="upload-image-button"><span class="vs vs-icon-image"></span> Add Image..</a>';
		}
		echo '</div>';



	}

}