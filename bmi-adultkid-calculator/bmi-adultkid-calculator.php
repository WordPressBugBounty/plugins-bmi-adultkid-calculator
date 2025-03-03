<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.2.2
 * @package           BMIC_calculator
 *
 * @wordpress-plugin
 * Plugin Name:       BMI Adult & Kid Calculator
 * Plugin URI:        https://www.calculator.io/bmi-calculator/
 * Description:       We have developed a free Wordpress plugin with our BMI Calculator that you can use completely free of charge.
 * Version:           1.2.2
 * Author:            BMI Calculator
 * Author URI:        https://www.calculator.io/bmi-calculator/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bmi-adultkid-calculator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) exit;


define( 'BMIC_CALC_VERSION', '1.2.2' );

function BMIAKC_adult_calc($atts) {
    $default = array(
        'lang' => 'English',
        'id_calc' => '34tg094tg34',
		'units' => 'metric',
		'redirect' => '',
		'redirect_link' => '',
    );
    $atts = shortcode_atts($default, $atts);
	wp_enqueue_script('jquery');
    ob_start();
    $lang = $atts['lang'];
    $id_calc = $atts['id_calc'];
    $units = $atts['units'];
    $units_cap = $atts['units'];
    if(isset($_GET['units'])){
        $units = $_GET['units'];
    }else{
        if($units_cap == "both"){
            $units = "metric";
        }
    }
    $redirect = $atts['redirect'];
    $redirect_link = $atts['redirect_link'];
    $backup_link = get_backup_link($lang);
    $link_option = get_link_option($lang);
    ?>
		<style>
          #calc_wrapper{
          	--family-calc-vis:<?php echo get_option('Font_family_calc_visual');?>;
            --title-color:<?php echo get_option('Font_color1_calc_visual');?>;
            --values-color:<?php echo get_option('Font_color3_calc_visual');?>;
            --text-color:<?php echo get_option('Font_color2_calc_visual');?>;
          }

          .toggle-switch {
  display: inline-block;
  position: relative;
  width: 30px;
  height: 17px;
  margin-left:15px;
  margin-top: 4px;
}

.toggle-switch input {
  display: none;
}

.toggle-switch-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  border-radius: 17px;
  transition: 0.4s;
}

.toggle-switch-slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  border-radius: 50%;
  transition: 0.4s;
}

input:checked + .toggle-switch-slider {
  background-color: #4f94d4;
}

input:checked + .toggle-switch-slider:before {
  transform: translateX(13px);
}

<?php if($units == 'metric'){
    ?>
.imperial_inputs{
    display:none;
}
    <?php
}else{
    ?>
.metric_inputs{
    display:none;
}
    <?php
}
?>
		</style>


        <div class="calc_wrapper" id="calc_wrapper">
            <div class="calc_header">
                <div class="calc_header_left">
                    <?php if($link_option == 1) {;?>
                    <a href="<?php echo esc_url($backup_link);?>" target="_blank" style="text-decoration: none;">
                    <?php };?>
                    <div class="calc_header_title">
                        <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Title"));?>
                    </div>
                    <?php if($link_option == 1) {;?>
                    </a>
                    <?php };?>
                    <?php if($link_option == 2) {;?>
                    <a href="<?php echo esc_url($backup_link);?>" target="_blank" style="text-decoration: none;">
                    <?php };?>
                    <div class="calc_header_desc">
                        <?php echo esc_attr(get_option("lang_bmi_calc".$lang."TitleDesc"));?>
                    </div>
                    <?php if($link_option == 2) {;?>
                    </a>
                    <?php };?>
                </div>
                <?php if($link_option == 3) {;?>
                <a href="<?php echo esc_url($backup_link);?>" target="_blank" style="text-decoration: none;">
                <?php };?>
                <div class="calc_header_right">
                    <img src="<?php echo plugins_url('images/bmiberegner.png',__FILE__);?>" alt="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Title"));?>">
                </div>
                <?php if($link_option == 3) {;?>
                </a>
                <?php };?>
            </div>
            <div class="custom_flex_calc_wrapper">


                <div class="calc_data">

                    <?php if($units_cap == "both"){
                        ?>

                        <style>
                            .button-group {
                                display: flex;
								width:100%
                            }

                            input[type="radio"][name="units_checkbox"] {
                                display: none;
                            }

                            .radio-label {
                                padding: 5px 10px;
                                margin: 0;
                                color: black;
                                background-color: #cccccc;
                                cursor: pointer;
                                transition: all 0.3s ease;
                            }

                            input[type="radio"]:checked + .radio-label {
                                color: white;
                                background-color: #4f94d4;
                            }
                            label[for="metric"]{
                                border-radius:5px 0 0  5px ;
                            }
                            label[for="imperial"]{
                                border-radius:0 5px 5px  0;
                            }
                        </style>
                        <div class="button-group" style="margin-bottom:16px;align-items: center;">
                            <span class="switcher_color" style="width:100%">
                            <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Units"));?>
                            </span>

                            <input type="radio" id="metric" name="units_checkbox" value="metric" checked>
                            <label for="metric" class="radio-label">Metric</label>

                            <input type="radio" id="imperial" name="units_checkbox" value="imperial">
                            <label for="imperial" class="radio-label">Imperial</label>
                        </div>
                        <?php

                    }else{
                        ?>
                        <style>
                            .button-group {
                                display: flex;
								width:100%
                            }

                            input[type="radio"][name="units_checkbox"] {
                                display: none;
                            }

                            .radio-label {
                                padding: 5px 10px;
                                margin: 0;
                                color: black;
                                background-color: #cccccc;
                                cursor: pointer;
                                transition: all 0.3s ease;
                            }

                            input[type="radio"]:checked + .radio-label {
                                color: white;
                                background-color: #4f94d4;
                            }
                            label[for="metric"]{
                                border-radius:5px 0 0  5px ;
                            }
                            label[for="imperial"]{
                                border-radius:0 5px 5px  0;
                            }
                        </style>
                        <div class="button-group" style="margin-bottom:16px;align-items: center;display: none;">
                            <span class="switcher_color" style="width:100%">
                            <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Units"));?>
                            </span>

                            <input type="radio" id="metric" name="units_checkbox" value="metric" checked>
                            <label for="metric" class="radio-label">Metric</label>

                            <input type="radio" id="imperial" name="units_checkbox" value="imperial">
                            <label for="imperial" class="radio-label">Imperial</label>
                        </div>

                        <?php
                    }?>

                        <div class="metric_inputs">
                            <div class="calc_data_height">
                                <span for="calc_height_input">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Height"));?>
                                </span>
                                <input id="calc_height_input" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."YourHeight"));?>">
                                <div class="calc_placeholder">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Cm"));?>
                                </div>
                            </div>
                            <div for="calc_height_input" class="alert-mess">
                                <?php echo esc_attr(get_option("lang_bmi_calc".$lang."HeightReg"));?>
                            </div>
                            <div class="calc_data_weight">
                                <span for="calc_weight_input">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Weight"));?>
                                </span>
                                <input id="calc_weight_input"  class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."YourWeight"));?>">
                                <div class="calc_placeholder">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Kg"));?>
                                </div>
                            </div>
                            <div for="calc_weight_input" class="alert-mess">
                                <?php echo esc_attr(get_option("lang_bmi_calc".$lang."WeightReg"));?>
                            </div>

                        </div>


                        <div class="imperial_inputs">
                            <div class="calc_data_height">
                                <span for="calc_height_input">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Height"));?>
                                </span>
                                <div class="custom_flex_wrapper">
                                    <input id="calc_height_input_ft" style="width:45%" class="calc_input_custom" type="text" placeholder="">
                                    <input id="calc_height_input_in" style="width:45%" class="calc_input_custom" type="text" placeholder="">
                                    <div class="calc_placeholder year">
                                        <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Ft"));?>
                                    </div>
                                    <div class="calc_placeholder">
                                        <?php echo esc_attr(get_option("lang_bmi_calc".$lang."In"));?>
                                    </div>
                                </div>
                            </div>
                            <div for="calc_height_input_ft" class="alert-mess">
                                <?php echo esc_attr(get_option("lang_bmi_calc".$lang."HeightRegFt"));?>
                            </div>
                            <div class="calc_data_weight">
                                <span for="calc_weight_input">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Weight"));?>
                                </span>
                                <div class="custom_flex_wrapper">
                                    <input id="calc_weight_input_lb" style="width:45%" class="calc_input_custom" type="text" placeholder="">
                                    <input id="calc_weight_input_st" style="width:45%" class="calc_input_custom" type="text" placeholder="">
                                    <div class="calc_placeholder year">
                                        <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Lb"));?>
                                    </div>
                                    <div class="calc_placeholder">
                                        <?php echo esc_attr(get_option("lang_bmi_calc".$lang."St"));?>
                                    </div>
                                </div>
                            </div>
                            <div for="calc_weight_input_lb" class="alert-mess">
                                <?php echo esc_attr(get_option("lang_bmi_calc".$lang."WeightRegLb"));?>
                            </div>
                        </div>

                        <div class="calc_input_button" id="calc_input_button">
                            <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Calculate"));?> <img style="width:9px;height:12px" src="<?php echo plugins_url('images/Arrow.png',__FILE__);?>" >
                        </div>



                </div>




                <div class="calc_info">
                    <div class="calc_info_placeholder <?php echo esc_attr($id_calc);?>">
                        <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Placeholder"));?>
                    </div>
                    <div class="calc_info_data <?php echo esc_attr($id_calc);?>" style="display:none">
                        <div class="calc_info_data_title">
                            <?php echo esc_attr(get_option("lang_bmi_calc".$lang."BMI"));?>
                        </div>
                        <div style="margin-bottom:50px" class="calc_info_data_value" id="calc_bmi">
                        </div>
                        <div class="calc_info_data_title">
                            <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Category"));?>
                        </div>
                        <div class="calc_info_data_value" id="calc_conclusion">
                        </div>
                        <div class="calc_info_line">
                            <div class="calc_info_line_result_wrapper">
                                <div class="calc_info_line_result">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."You"));?>
                                </div>
                            </div>

                            <div class="calc_info_line_underweight">
                                <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>
                            </div>
                            <div class="calc_info_line_healthy">
                                <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>
                            </div>
                            <div class="calc_info_line_overweight">
                                <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>
                            </div>
                            <div class="calc_info_line_obese">
                                <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>
                            </div>
                        </div>


                        <div class="calc_info_conclusion" id="calc_info_conclusion">
                            <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Normal1"));?> <span id="healthy_weight" class="calc_info_data_value"></span> <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Normal2"));?>
                        </div>

                        <div class="calc_info_conclusion" id="calc_info_conclusionLb" style="display:none">
                            <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Normal1"));?> <span id="healthy_weightLb" class="calc_info_data_value"></span> <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Normal2Lb"));?>
                        </div>



                    </div>
                </div>
            </div>
        </div>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        (function( $ ) {


            var units = '<?php echo esc_attr($units);?>';

            $('input[name="units_checkbox"]').on('change',function(){
                if ($(this).val() == 'imperial')
                {
                    $('.imperial_inputs').css('display','block');
                    $('.metric_inputs').css('display','none');


                    units = 'imperial';
                }else{
                    $('.imperial_inputs').css('display','none');
                    $('.metric_inputs').css('display','block');


                    units = 'metric';
                }
            })


            function moveRect(e){
                switch(e.key){

                    case "Enter":  // если нажата клавиша влево
                        var can = true;
                        if(units == 'metric'){
                            $('#calc_height_input').each(function(){
                                if(parseInt($(this).val()) < 125 || parseInt($(this).val()) > 225 || !Number.isInteger(parseInt($(this).val())) || $(this).val()[0]=='0'){
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                    $(this).addClass('alert');
                                    can = false;
                                }else{
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                    $(this).removeClass('alert');
                                    height = $(this).val()
                                }


                            })
                            $('#calc_weight_input').each(function(){

                                    if(parseFloat($(this).val()) < 10 || parseFloat($(this).val()) > 500 || fweight(parseFloat($(this).val())) > 1 || parseFloat($(this).val())!=$(this).val() || $(this).val()[0]=='0'){
                                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                        $(this).addClass('alert');
                                        can = false;
                                    }else{
                                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                        $(this).removeClass('alert');
                                        weight = parseFloat($(this).val());
                                    }

                            })
                            //console.log(can);
                            if(can){
                                <?php if($redirect==1){
                                ?>
                        document.location.href = "<?php echo esc_url($redirect_link); ?>?redirect=1&height="+height+"&weight="+weight+"&units="+units+"&ft="+$('#calc_height_input_ft').val()+"&in="+$('#calc_height_input_in').val()+"&lb="+$('#calc_weight_input_lb').val()+"&st="+$('#calc_weight_input_st').val()+"#calc_wrapper";
                                <?php

                            }else{
                                ?>
                                $('#calc_input_button').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Recalculate"));?> <img src="<?php echo plugins_url('images/Vector Smart Object.png',__FILE__);?>" >');
                                $('#calc_input_button').addClass('re');

                                var bmi = (parseFloat(weight)/(parseInt(height)/100*parseInt(height)/100)).toFixed(2);
                                console.log(bmi);
                                if( bmi <=18.49 ){
                                    $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                    $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                    $('#calc_bmi').html(bmi);
                                    $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>');
                                    var left = 0;
                                    if(bmi > 12){

                                        left = (bmi - 12)*($('.calc_info_line_underweight').width()/6.5);
                                        console.log(left);
                                    }
                                    $('.calc_info_line_result_wrapper').css('left',(left-30)+'px' );
                                }
                                if(bmi >= 18.5 && bmi <=24.99 ){
                                    $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                    $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                    $('#calc_bmi').html(bmi);
                                    $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>');

                                    var left = 0;
                                    if(bmi > 18.5){
                                        left = (bmi - 18.5)*($('.calc_info_line_healthy').width()/6.5);
                                    }
                                    $('.calc_info_line_result_wrapper').css('left',((left+$('.calc_info_line_underweight').width())-30)+'px' );
                                }
                                if(bmi >= 25 && bmi <=29.99 ){
                                    $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                    $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                    $('#calc_bmi').html(bmi);
                                    $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>');
                                    var left = 0;
                                    if(bmi > 25){
                                        left = (bmi - 25)*($('.calc_info_line_overweight').width()/5);
                                    }
                                    $('.calc_info_line_result_wrapper').css('left',((left+$('.calc_info_line_underweight').width()+$('.calc_info_line_healthy').width())-30)+'px' );
                                }
                                if(bmi >= 30 ){
                                    $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                    $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                    $('#calc_bmi').html(bmi);
                                    $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>');
                                    var left = 0;
                                    if(bmi > 30){
                                        left = (bmi - 30)*($('.calc_info_line_obese').width()/5);
                                    }
                                    if(bmi > 35){
                                        left = $('.calc_info_line_obese').width();
                                    }
                                    $('.calc_info_line_result_wrapper').css('left',((left+$('.calc_info_line_underweight').width()+$('.calc_info_line_healthy').width() +$('.calc_info_line_overweight').width())-30)+'px' );
                                }
                                var healthy_min = Math.round(18.5 * (parseInt(height)/100*parseInt(height)/100));
                                var healthy_max = Math.round(24.99 * (parseInt(height)/100*parseInt(height)/100));



                                if(units == 'metric'){
                                    $('#healthy_weight').html(healthy_min+' - '+healthy_max);
                                    $('#calc_info_conclusionLb').css('display','none');
                                    $('#calc_info_conclusion').css('display','block');
                                }else{
                                    $('#healthy_weightLb').html(Math.round(healthy_min*2.20462)+' - '+Math.round(healthy_max*2.20462));
                                    $('#calc_info_conclusionLb').css('display','block');
                                    $('#calc_info_conclusion').css('display','none');
                                }
                                //$('#healthy_weightLb').html(Math.round(healthy_min*2.20462)+' - '+Math.round(healthy_max*2.20462));


                                <?php } ?>
                            }
                        }else{








                            var feets = $('#calc_height_input_ft').val();
                            var inches = $('#calc_height_input_in').val();
                            if(isNaN(parseFloat(feets))){
                                feets = 0;
                            }
                            if(isNaN(parseFloat(inches))){
                                inches = 0;
                            }
                            var height_imp = ((parseFloat(feets) + parseFloat(inches) / 12) * 30.48).toFixed(0);

                            if(height_imp < 125 || height_imp > 225 ){
                                $('.alert-mess[for="calc_height_input_ft"]').css('opacity','1');
                                $('#calc_height_input_ft').addClass('alert');
                                $('#calc_height_input_in').addClass('alert');
                                can = false;
                            }else{
                                $('.alert-mess[for="calc_height_input_ft"]').css('opacity','0');
                                $('#calc_height_input_ft').removeClass('alert');
                                $('#calc_height_input_in').removeClass('alert');
                            }

                            height = height_imp;


                            var pounds = $('#calc_weight_input_lb').val();
                            var stones = $('#calc_weight_input_st').val();
                            if(isNaN(parseFloat(pounds))){
                                pounds = 0;
                            }
                            if(isNaN(parseFloat(stones))){
                                stones = 0;
                                console.log('alo')
                            }
                            var weight_imp = ((parseFloat(pounds) + parseFloat(stones) / 14) / 2.20462 ).toFixed(0);

                            if(weight_imp < 10 || weight_imp > 500){
                                $('.alert-mess[for="calc_weight_input_lb"]').css('opacity','1');
                                $('#calc_weight_input_lb').addClass('alert');
                                $('#calc_weight_input_st').addClass('alert');
                                can = false;
                            }else{
                                $('.alert-mess[for="calc_weight_input_lb"]').css('opacity','0');
                                $('#calc_weight_input_lb').removeClass('alert');
                                $('#calc_weight_input_st').removeClass('alert');
                            }
                            console.log(parseFloat(stones))
                            weight = weight_imp;
                            //console.log(can);
                            if(can){
                                <?php if($redirect==1){
                                ?>
                        document.location.href = "<?php echo esc_url($redirect_link); ?>?redirect=1&height="+height+"&weight="+weight+"&units="+units+"&ft="+$('#calc_height_input_ft').val()+"&in="+$('#calc_height_input_in').val()+"&lb="+$('#calc_weight_input_lb').val()+"&st="+$('#calc_weight_input_st').val()+"#calc_wrapper";
                                <?php

                            }else{
                                ?>
                                $('#calc_input_button').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Recalculate"));?> <img src="<?php echo plugins_url('images/Vector Smart Object.png',__FILE__);?>" >');
                                $('#calc_input_button').addClass('re');

                                var bmi = (parseFloat(weight)/(parseInt(height)/100*parseInt(height)/100)).toFixed(2);
                                console.log(bmi);
                                if( bmi <=18.49 ){
                                    $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                    $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                    $('#calc_bmi').html(bmi);
                                    $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>');
                                    var left = 0;
                                    if(bmi > 12){

                                        left = (bmi - 12)*($('.calc_info_line_underweight').width()/6.5);
                                        console.log(left);
                                    }
                                    $('.calc_info_line_result_wrapper').css('left',(left-30)+'px' );
                                }
                                if(bmi >= 18.5 && bmi <=24.99 ){
                                    $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                    $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                    $('#calc_bmi').html(bmi);
                                    $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>');

                                    var left = 0;
                                    if(bmi > 18.5){
                                        left = (bmi - 18.5)*($('.calc_info_line_healthy').width()/6.5);
                                    }
                                    $('.calc_info_line_result_wrapper').css('left',((left+$('.calc_info_line_underweight').width())-30)+'px' );
                                }
                                if(bmi >= 25 && bmi <=29.99 ){
                                    $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                    $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                    $('#calc_bmi').html(bmi);
                                    $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>');
                                    var left = 0;
                                    if(bmi > 25){
                                        left = (bmi - 25)*($('.calc_info_line_overweight').width()/5);
                                    }
                                    $('.calc_info_line_result_wrapper').css('left',((left+$('.calc_info_line_underweight').width()+$('.calc_info_line_healthy').width())-30)+'px' );
                                }
                                if(bmi >= 30 ){
                                    $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                    $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                    $('#calc_bmi').html(bmi);
                                    $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>');
                                    var left = 0;
                                    if(bmi > 30){
                                        left = (bmi - 30)*($('.calc_info_line_obese').width()/5);
                                    }
                                    if(bmi > 35){
                                        left = $('.calc_info_line_obese').width();
                                    }
                                    $('.calc_info_line_result_wrapper').css('left',((left+$('.calc_info_line_underweight').width()+$('.calc_info_line_healthy').width() +$('.calc_info_line_overweight').width())-30)+'px' );
                                }
                                var healthy_min = Math.round(18.5 * (parseInt(height)/100*parseInt(height)/100));
                                var healthy_max = Math.round(24.99 * (parseInt(height)/100*parseInt(height)/100));

                                if(units == 'metric'){
                                    $('#healthy_weight').html(healthy_min+' - '+healthy_max);
                                    $('#calc_info_conclusionLb').css('display','none');
                                    $('#calc_info_conclusion').css('display','block');
                                }else{
                                    $('#healthy_weightLb').html(Math.round(healthy_min*2.20462)+' - '+Math.round(healthy_max*2.20462));
                                    $('#calc_info_conclusionLb').css('display','block');
                                    $('#calc_info_conclusion').css('display','none');
                                }




                                <?php } ?>

                            }







                        }
                        break;
                }
            }
            function check_imperial(can){
                var feets = $('#calc_height_input_ft').val();
                var inches = $('#calc_height_input_in').val();
                if(isNaN(parseFloat(feets))){
                    feets = 0;
                }
                if(isNaN(parseFloat(inches))){
                    inches = 0;
                }
                var height_imp = ((parseFloat(feets) + parseFloat(inches) / 12) * 30.48).toFixed(0);

                if(height_imp < 125 || height_imp > 225 ){
                    $('.alert-mess[for="calc_height_input_ft"]').css('opacity','1');
                    $('#calc_height_input_ft').addClass('alert');
                    $('#calc_height_input_in').addClass('alert');
                    can = false;
                }else{
                    $('.alert-mess[for="calc_height_input_ft"]').css('opacity','0');
                    $('#calc_height_input_ft').removeClass('alert');
                    $('#calc_height_input_in').removeClass('alert');
                }

                height = height_imp;


                var pounds = $('#calc_weight_input_lb').val();
                var stones = $('#calc_weight_input_st').val();
                if(isNaN(parseFloat(pounds))){
                    pounds = 0;
                }
                if(isNaN(parseFloat(stones))){
                    stones = 0;
                    console.log('alo')
                }
                var weight_imp = ((parseFloat(pounds) + parseFloat(stones) / 14) / 2.20462 ).toFixed(0);

                if(weight_imp < 10 || weight_imp > 500){
                    $('.alert-mess[for="calc_weight_input_lb"]').css('opacity','1');
                    $('#calc_weight_input_lb').addClass('alert');
                    $('#calc_weight_input_st').addClass('alert');
                    can = false;
                }else{
                    $('.alert-mess[for="calc_weight_input_lb"]').css('opacity','0');
                    $('#calc_weight_input_lb').removeClass('alert');
                    $('#calc_weight_input_st').removeClass('alert');
                }
                console.log(parseFloat(stones))
                weight = weight_imp;
                return can;
            }
            addEventListener("keydown", moveRect);
            const fweight = x => ( (x.toString().includes('.')) ? (x.toString().split('.').pop().length) : (0) );
            var height = '';
            var weight = '';
            var checkingRegExp = new RegExp(/^(\d)$/g);
            $('#calc_height_input').on('input',function(){
                if(/^[\d.]*$/.test($(this).val())  && $(this).val().split(".").length < 3){
                    height = $(this).val();
                }else{
                    $(this).val(height);
                }

                if(parseInt($(this).val()) < 125 || parseInt($(this).val()) > 225 || !Number.isInteger(parseInt($(this).val())) || $(this).val()[0]=='0'){
                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                    $(this).addClass('alert');
                }else{
                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                    $(this).removeClass('alert');
                }
            })
            $('#calc_weight_input').on('input',function(){
                if(/^[\d.]*$/.test($(this).val()) && $(this).val().split(".").length < 3 ){
                    weight = $(this).val();
                }else{
                    $(this).val(weight);
                }
                    if(parseFloat($(this).val()) < 10 || parseFloat($(this).val()) > 500 || fweight(parseFloat($(this).val())) > 1 || parseFloat($(this).val())!=$(this).val() || $(this).val()[0]=='0'){
                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                        $(this).addClass('alert');
                        can = false;
                    }else{
                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                        $(this).removeClass('alert');
                    }
            })
            var prev1 = 0;
            var prev2 = 0;
            var prev3 = 0;
            var prev4 = 0;

            $('#calc_height_input_ft').on('input',function(){
                if(/^[\d.]*$/.test($(this).val())){
                    prev1 = $(this).val();
                }else{
                    $(this).val(prev1);
                }
                var can = check_imperial(true);
            })
            $('#calc_height_input_in').on('input',function(){
                if(/^[\d.]*$/.test($(this).val())){
                    prev2 = $(this).val();
                }else{
                    $(this).val(prev2);
                }
                var can = check_imperial(true);
            })
            $('#calc_weight_input_lb').on('input',function(){
                if(/^[\d.]*$/.test($(this).val())){
                    prev3 = $(this).val();
                }else{
                    $(this).val(prev3);
                }
                var can = check_imperial(true);
            })
            $('#calc_weight_input_st').on('input',function(){
                if(/^[\d.]*$/.test($(this).val())){
                    prev4 = $(this).val();
                }else{
                    $(this).val(prev4);
                }
                var can = check_imperial(true);
            })








            $('#calc_input_button').on('click',function(){
                var can = true;


                if(units == 'metric'){


                    $('#calc_height_input').each(function(){


                            if(parseInt($(this).val()) < 125 || parseInt($(this).val()) > 225 || !Number.isInteger(parseInt($(this).val())) || $(this).val()[0]=='0'){
                                $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                $(this).addClass('alert');
                                can = false;
                            }else{
                                $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                $(this).removeClass('alert');
                                height = $(this).val();
                            }

                    })
                    $('#calc_weight_input').each(function(){


                            if(parseFloat($(this).val()) < 10 || parseFloat($(this).val()) > 500 || fweight(parseFloat($(this).val())) > 1 || parseFloat($(this).val())!=$(this).val() || $(this).val()[0]=='0'){
                                $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                $(this).addClass('alert');
                                can = false;
                            }else{
                                $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                $(this).removeClass('alert');
                                weight = $(this).val();
                            }

                    })
                }else{

                    if(can){
                        can = check_imperial(true);
                    }


                }
                //console.log(can);
                if(can){
                    <?php if($redirect==1){
                        ?>
                        document.location.href = "<?php echo esc_url($redirect_link); ?>?redirect=1&height="+height+"&weight="+weight+"&units="+units+"&ft="+$('#calc_height_input_ft').val()+"&in="+$('#calc_height_input_in').val()+"&lb="+$('#calc_weight_input_lb').val()+"&st="+$('#calc_weight_input_st').val()+"#calc_wrapper";
                        <?php

                    }else{
                        ?>

                    $('#calc_input_button').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Recalculate"));?> <img src="<?php echo plugins_url('images/Vector Smart Object.png',__FILE__);?>" >');
                    $('#calc_input_button').addClass('re');
                    console.log(weight)
                    console.log(height)
                    var bmi = (parseFloat(weight)/(parseInt(height)/100*parseInt(height)/100)).toFixed(2);
                    console.log(bmi);
                    if( bmi <=18.49 ){
                        $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                        $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                        $('#calc_bmi').html(bmi);
                        $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>');
                        var left = 0;
                        if(bmi > 12){

                            left = (bmi - 12)*($('.calc_info_line_underweight').width()/6.5);
                            console.log(left);
                        }
                        $('.calc_info_line_result_wrapper').css('left',(left-30)+'px' );
                    }
                    if(bmi >= 18.5 && bmi <=24.99 ){
                        $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                        $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                        $('#calc_bmi').html(bmi);
                        $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>');

                        var left = 0;
                        if(bmi > 18.5){
                            left = (bmi - 18.5)*($('.calc_info_line_healthy').width()/6.5);
                        }
                        $('.calc_info_line_result_wrapper').css('left',((left+$('.calc_info_line_underweight').width())-30)+'px' );
                    }
                    if(bmi >= 25 && bmi <=29.99 ){
                        $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                        $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                        $('#calc_bmi').html(bmi);
                        $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>');
                        var left = 0;
                        if(bmi > 25){
                            left = (bmi - 25)*($('.calc_info_line_overweight').width()/5);
                        }
                        $('.calc_info_line_result_wrapper').css('left',((left+$('.calc_info_line_underweight').width()+$('.calc_info_line_healthy').width())-30)+'px' );
                    }
                    if(bmi >= 30 ){
                        $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                        $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                        $('#calc_bmi').html(bmi);
                        $('#calc_conclusion').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>');
                        var left = 0;
                        if(bmi > 30){
                            left = (bmi - 30)*($('.calc_info_line_obese').width()/5);
                        }
                        if(bmi > 35){
                            left = $('.calc_info_line_obese').width();
                        }
                        $('.calc_info_line_result_wrapper').css('left',((left+$('.calc_info_line_underweight').width()+$('.calc_info_line_healthy').width() +$('.calc_info_line_overweight').width())-30)+'px' );
                    }
                    var healthy_min = Math.round(18.5 * (parseInt(height)/100*parseInt(height)/100));
                    var healthy_max = Math.round(24.99 * (parseInt(height)/100*parseInt(height)/100));

                    if(units == 'metric'){
                        $('#healthy_weight').html(healthy_min+' - '+healthy_max);
                        $('#calc_info_conclusionLb').css('display','none');
                        $('#calc_info_conclusion').css('display','block');
                    }else{
                        $('#healthy_weightLb').html(Math.round(healthy_min*2.20462)+' - '+Math.round(healthy_max*2.20462));
                        $('#calc_info_conclusionLb').css('display','block');
                        $('#calc_info_conclusion').css('display','none');
                    }

                <?php } ?>
                }
            })
<?php if(!empty($_GET['redirect']) && $_GET['redirect']==1){
 ?>
if('<?php echo esc_attr($_GET['units']);?>'=='metric'){
    $('#calc_height_input').val('<?php echo esc_attr($_GET['height']);?>');
    $('#calc_weight_input').val('<?php echo esc_attr($_GET['weight']);?>');
    height = <?php echo esc_attr($_GET['height']);?>;
    weight = <?php echo esc_attr($_GET['weight']);?>;
}else{
    $('input[name="units_checkbox"][value="imperial"]').prop('checked', true).change();
    units = 'imperial';
    $('#calc_height_input_ft').val('<?php echo esc_attr($_GET['ft']);?>');
    $('#calc_height_input_in').val('<?php echo esc_attr($_GET['in']);?>');
    $('#calc_weight_input_lb').val('<?php echo esc_attr($_GET['lb']);?>');
    $('#calc_weight_input_st').val('<?php echo esc_attr($_GET['st']);?>');
    height = <?php echo esc_attr($_GET['height']);?>;
    weight = <?php echo esc_attr($_GET['weight']);?>;
}




        $('#calc_input_button').click();
 <?php
}?>
        })( jQuery );
})

    </script>
    <?php
    $buf = ob_get_contents() ;
    ob_end_clean();
    return $buf;
}
add_shortcode('BMIAKC_adult_calc', 'BMIAKC_adult_calc');

function BMIAKC_kid_calc($atts) {
    $default = array(
        'lang' => 'English',
        'id_calc' => '34534fr443t',
		'units' => 'metric',
		'redirect' => '',
		'redirect_link' => '',
    );
    $atts = shortcode_atts($default, $atts);

    ob_start();

    $lang = $atts['lang'];
    $id_calc = $atts['id_calc'];

    $units = $atts['units'];
    $units_cap = $atts['units'];
    if(isset($_GET['units'])){
        $units = $_GET['units'];
    }else{
        if($units_cap == "both"){
            $units = "metric";
        }
    }

    $redirect = $atts['redirect'];
    $redirect_link = $atts['redirect_link'];


$percentile_arr2 = '0   -0,0631 13,3363 0,09272 10  10,8    11,2    11,5    11,8    12,1    12,5    13,3    14,2    14,7    15  15,5    15,9    16,6    17,8
1   0,3448  14,5679 0,09556 10,7    11,6    12,1    12,4    12,9    13,2    13,6    14,6    15,5    16,1    16,4    17  17,3    18  19,3
2   0,1749  15,7679 0,09371 11,7    12,6    13,2    13,5    14  14,3    14,8    15,8    16,8    17,4    17,8    18,4    18,8    19,5    20,9
3   0,0643  16,3574 0,09254 12,3    13,2    13,7    14  14,5    14,9    15,4    16,4    17,4    18  18,4    19  19,4    20,3    21,7
4   -0,0191 16,6703 0,09166 12,6    13,5    14  14,3    14,8    15,2    15,7    16,7    17,7    18,3    18,8    19,4    19,8    20,6    22,1
5   -0,0864 16,8386 0,09096 12,8    13,7    14,2    14,5    15  15,3    15,8    16,8    17,9    18,5    18,9    19,6    20  20,8    22,4
6   -0,1429 16,9083 0,09036 12,9    13,7    14,3    14,6    15,1    15,4    15,9    16,9    18  18,6    19  19,6    20,1    20,9    22,5
7   -0,1916 16,902  0,08984 12,9    13,8    14,3    14,6    15,1    15,4    15,9    16,9    18  18,6    19  19,6    20,1    20,9    22,5
8   -0,2344 16,8404 0,08939 12,9    13,7    14,3    14,6    15  15,4    15,9    16,8    17,9    18,5    18,9    19,6    20  20,8    22,4
9   -0,2725 16,7406 0,08898 12,8    13,7    14,2    14,5    15  15,3    15,8    16,7    17,8    18,4    18,8    19,4    19,9    20,7    22,3
10  -0,3068 16,6184 0,08861 12,8    13,6    14,1    14,4    14,9    15,2    15,7    16,6    17,7    18,2    18,7    19,3    19,7    20,6    22,1
11  -0,3381 16,4875 0,08828 12,7    13,5    14  14,3    14,8    15,1    15,5    16,5    17,5    18,1    18,5    19,1    19,6    20,4    22
12  -0,3667 16,3568 0,08797 12,6    13,4    13,9    14,2    14,6    15  15,4    16,4    17,4    17,9    18,4    19  19,4    20,2    21,8
13  -0,3932 16,2311 0,08768 12,5    13,3    13,8    14,1    14,5    14,8    15,3    16,2    17,2    17,8    18,2    18,8    19,2    20,1    21,6
14  -0,4177 16,1128 0,08741 12,5    13,3    13,7    14  14,4    14,7    15,2    16,1    17,1    17,7    18,1    18,7    19,1    19,9    21,5
15  -0,4407 16,0028 0,08716 12,4    13,2    13,7    13,9    14,3    14,6    15,1    16  17  17,5    17,9    18,6    19  19,8    21,3
16  -0,4623 15,9017 0,08693 12,3    13,1    13,6    13,8    14,3    14,6    15  15,9    16,9    17,4    17,8    18,4    18,8    19,7    21,2
17  -0,4825 15,8096 0,08671 12,3    13  13,5    13,8    14,2    14,5    14,9    15,8    16,8    17,3    17,7    18,3    18,7    19,5    21,1
18  -0,5017 15,7263 0,0865  12,2    13  13,4    13,7    14,1    14,4    14,8    15,7    16,7    17,2    17,6    18,2    18,6    19,4    21
19  -0,5199 15,6517 0,0863  12,2    12,9    13,4    13,6    14,1    14,3    14,8    15,7    16,6    17,2    17,5    18,1    18,5    19,3    20,9
20  -0,5372 15,5855 0,08612 12,2    12,9    13,3    13,6    14  14,3    14,7    15,6    16,5    17,1    17,5    18,1    18,5    19,3    20,8
21  -0,5537 15,5278 0,08594 12,1    12,8    13,3    13,6    14  14,2    14,7    15,5    16,5    17  17,4    18  18,4    19,2    20,7
22  -0,5695 15,4787 0,08577 12,1    12,8    13,3    13,5    13,9    14,2    14,6    15,5    16,4    17  17,3    17,9    18,3    19,1    20,6
23  -0,5846 15,438  0,0856  12,1    12,8    13,2    13,5    13,9    14,2    14,6    15,4    16,4    16,9    17,3    17,9    18,3    19,1    20,6
24  -0,5989 15,4052 0,08545 12,1    12,8    13,2    13,5    13,9    14,1    14,6    15,4    16,3    16,9    17,3    17,8    18,2    19  20,5
25  -0,5684 15,659  0,08452 12,3    13  13,4    13,7    14,1    14,4    14,8    15,7    16,6    17,1    17,5    18,1    18,5    19,3    20,8
26  -0,5684 15,6308 0,08449 12,3    13  13,4    13,7    14,1    14,4    14,8    15,6    16,6    17,1    17,5    18,1    18,5    19,3    20,7
27  -0,5684 15,6037 0,08446 12,2    13  13,4    13,7    14  14,3    14,8    15,6    16,5    17,1    17,4    18  18,4    19,2    20,7
28  -0,5684 15,5777 0,08444 12,2    12,9    13,4    13,6    14  14,3    14,7    15,6    16,5    17  17,4    18  18,4    19,2    20,7
29  -0,5684 15,5523 0,08443 12,2    12,9    13,4    13,6    14  14,3    14,7    15,6    16,5    17  17,4    18  18,4    19,2    20,6
30  -0,5684 15,5276 0,08444 12,2    12,9    13,3    13,6    14  14,3    14,7    15,5    16,5    17  17,4    17,9    18,3    19,1    20,6
31  -0,5684 15,5034 0,08448 12,2    12,9    13,3    13,6    14  14,2    14,7    15,5    16,4    17  17,3    17,9    18,3    19,1    20,6
32  -0,5684 15,4798 0,08455 12,1    12,8    13,3    13,5    13,9    14,2    14,6    15,5    16,4    16,9    17,3    17,9    18,3    19,1    20,5
33  -0,5684 15,4572 0,08467 12,1    12,8    13,3    13,5    13,9    14,2    14,6    15,5    16,4    16,9    17,3    17,9    18,3    19  20,5
34  -0,5684 15,4356 0,08484 12,1    12,8    13,2    13,5    13,9    14,2    14,6    15,4    16,4    16,9    17,3    17,9    18,2    19  20,5
35  -0,5684 15,4155 0,08506 12,1    12,8    13,2    13,5    13,9    14,1    14,6    15,4    16,3    16,9    17,3    17,8    18,2    19  20,5
36  -0,5684 15,3968 0,08535 12  12,8    13,2    13,5    13,8    14,1    14,5    15,4    16,3    16,9    17,2    17,8    18,2    19  20,5
37  -0,5684 15,3796 0,08569 12  12,7    13,2    13,4    13,8    14,1    14,5    15,4    16,3    16,8    17,2    17,8    18,2    19  20,5
38  -0,5684 15,3638 0,08609 12  12,7    13,2    13,4    13,8    14,1    14,5    15,4    16,3    16,8    17,2    17,8    18,2    19  20,5
39  -0,5684 15,3493 0,08654 12  12,7    13,1    13,4    13,8    14,1    14,5    15,3    16,3    16,8    17,2    17,8    18,2    19  20,5
40  -0,5684 15,3358 0,08704 11,9    12,7    13,1    13,4    13,8    14  14,5    15,3    16,3    16,8    17,2    17,8    18,2    19  20,5
41  -0,5684 15,3233 0,08757 11,9    12,6    13,1    13,3    13,7    14  14,5    15,3    16,3    16,8    17,2    17,8    18,2    19  20,6
42  -0,5684 15,3116 0,08813 11,9    12,6    13,1    13,3    13,7    14  14,4    15,3    16,3    16,8    17,2    17,8    18,2    19  20,6
43  -0,5684 15,3007 0,08872 11,9    12,6    13  13,3    13,7    14  14,4    15,3    16,3    16,8    17,2    17,8    18,2    19,1    20,6
44  -0,5684 15,2905 0,08931 11,8    12,6    13  13,3    13,7    14  14,4    15,3    16,3    16,8    17,2    17,8    18,2    19,1    20,6
45  -0,5684 15,2814 0,08991 11,8    12,5    13  13,3    13,7    14  14,4    15,3    16,3    16,8    17,2    17,8    18,3    19,1    20,7
46  -0,5684 15,2732 0,09051 11,8    12,5    13  13,2    13,7    13,9    14,4    15,3    16,3    16,8    17,2    17,8    18,3    19,1    20,7
47  -0,5684 15,2661 0,0911  11,8    12,5    13  13,2    13,6    13,9    14,4    15,3    16,3    16,8    17,2    17,9    18,3    19,1    20,7
48  -0,5684 15,2602 0,09168 11,7    12,5    12,9    13,2    13,6    13,9    14,4    15,3    16,3    16,8    17,2    17,9    18,3    19,2    20,8
49  -0,5684 15,2556 0,09227 11,7    12,5    12,9    13,2    13,6    13,9    14,4    15,3    16,3    16,8    17,2    17,9    18,3    19,2    20,8
50  -0,5684 15,2523 0,09286 11,7    12,4    12,9    13,2    13,6    13,9    14,3    15,3    16,3    16,8    17,3    17,9    18,3    19,2    20,9
51  -0,5684 15,2503 0,09345 11,7    12,4    12,9    13,2    13,6    13,9    14,3    15,3    16,3    16,8    17,3    17,9    18,4    19,2    20,9
52  -0,5684 15,2496 0,09403 11,7    12,4    12,9    13,1    13,6    13,9    14,3    15,2    16,3    16,9    17,3    17,9    18,4    19,3    21
53  -0,5684 15,2502 0,0946  11,6    12,4    12,9    13,1    13,6    13,9    14,3    15,3    16,3    16,9    17,3    17,9    18,4    19,3    21
54  -0,5684 15,2519 0,09515 11,6    12,4    12,9    13,1    13,6    13,9    14,3    15,3    16,3    16,9    17,3    18  18,4    19,3    21
55  -0,5684 15,2544 0,09568 11,6    12,4    12,9    13,1    13,5    13,9    14,3    15,3    16,3    16,9    17,3    18  18,4    19,4    21,1
56  -0,5684 15,2575 0,09618 11,6    12,4    12,8    13,1    13,5    13,8    14,3    15,3    16,3    16,9    17,3    18  18,5    19,4    21,1
57  -0,5684 15,2612 0,09665 11,6    12,4    12,8    13,1    13,5    13,8    14,3    15,3    16,3    16,9    17,4    18  18,5    19,4    21,2
58  -0,5684 15,2653 0,09709 11,6    12,3    12,8    13,1    13,5    13,8    14,3    15,3    16,3    16,9    17,4    18  18,5    19,4    21,2
59  -0,5684 15,2698 0,0975  11,6    12,3    12,8    13,1    13,5    13,8    14,3    15,3    16,3    16,9    17,4    18,1    18,5    19,5    21,3
60  -0,5684 15,2747 0,09789 11,6    12,3    12,8    13,1    13,5    13,8    14,3    15,3    16,3    17  17,4    18,1    18,6    19,5    21,3
61  -0,8886 15,2441 0,09692 11,689  12,412  12,874  13,133  13,55   13,846  14,306  15,244  16,306  16,936  17,388  18,103  18,598  19,605  21,594
62  -0,9068 15,2434 0,09738 11,682  12,405  12,868  13,126  13,544  13,84   14,301  15,243  16,311  16,945  17,402  18,124  18,624  19,643  21,662
63  -0,9248 15,2433 0,09783 11,676  12,399  12,861  13,12   13,538  13,835  14,298  15,243  16,317  16,956  17,416  18,145  18,65   19,681  21,731
64  -0,9427 15,2438 0,09829 11,671  12,393  12,855  13,114  13,533  13,831  14,294  15,244  16,324  16,967  17,431  18,167  18,677  19,721  21,802
65  -0,9605 15,2448 0,09875 11,665  12,387  12,85   13,109  13,529  13,827  14,292  15,245  16,331  16,979  17,447  18,189  18,705  19,763  21,876
66  -0,978  15,2464 0,0992  11,661  12,382  12,845  13,104  13,525  13,824  14,29   15,246  16,339  16,991  17,463  18,212  18,734  19,804  21,95
67  -0,9954 15,2487 0,09966 11,657  12,378  12,841  13,1    13,521  13,821  14,288  15,249  16,347  17,005  17,481  18,237  18,764  19,848  22,027
68  -1,0126 15,2516 0,10012 11,653  12,374  12,837  13,097  13,518  13,819  14,287  15,252  16,357  17,019  17,499  18,262  18,795  19,892  22,106
69  -1,0296 15,2551 0,10058 11,649  12,37   12,834  13,094  13,516  13,817  14,287  15,255  16,367  17,034  17,518  18,289  18,827  19,938  22,187
70  -1,0464 15,2592 0,10104 11,646  12,367  12,831  13,091  13,514  13,816  14,287  15,259  16,377  17,049  17,537  18,316  18,86   19,985  22,27
71  -1,063  15,2641 0,10149 11,645  12,365  12,829  13,09   13,513  13,816  14,288  15,264  16,388  17,065  17,558  18,344  18,894  20,033  22,354
72  -1,0794 15,2697 0,10195 11,643  12,363  12,828  13,089  13,513  13,816  14,29   15,27   16,401  17,083  17,579  18,373  18,929  20,082  22,441
73  -1,0956 15,276  0,10241 11,642  12,362  12,827  13,088  13,513  13,817  14,292  15,276  16,414  17,101  17,601  18,403  18,966  20,133  22,531
74  -1,1115 15,2831 0,10287 11,641  12,361  12,826  13,088  13,514  13,818  14,295  15,283  16,427  17,12   17,625  18,434  19,003  20,186  22,623
75  -1,1272 15,2911 0,10333 11,641  12,361  12,827  13,089  13,516  13,821  14,299  15,291  16,442  17,14   17,649  18,466  19,042  20,239  22,717
76  -1,1427 15,2998 0,10379 11,642  12,362  12,828  13,09   13,518  13,824  14,303  15,3    16,458  17,161  17,674  18,5    19,081  20,295  22,813
77  -1,1579 15,3095 0,10425 11,643  12,363  12,83   13,093  13,521  13,828  14,309  15,31   16,475  17,183  17,701  18,534  19,123  20,352  22,912
78  -1,1728 15,32   0,10471 11,645  12,365  12,832  13,096  13,525  13,832  14,315  15,32   16,492  17,206  17,728  18,57   19,165  20,41   23,013
79  -1,1875 15,3314 0,10517 11,647  12,368  12,836  13,099  13,53   13,838  14,322  15,331  16,511  17,23   17,757  18,607  19,209  20,47   23,117
80  -1,2019 15,3439 0,10562 11,651  12,372  12,84   13,104  13,535  13,844  14,33   15,344  16,53   17,255  17,787  18,645  19,254  20,531  23,222
81  -1,216  15,3572 0,10608 11,654  12,376  12,845  13,11   13,542  13,851  14,339  15,357  16,551  17,281  17,818  18,685  19,3    20,594  23,331
82  -1,2298 15,3717 0,10654 11,659  12,381  12,851  13,116  13,549  13,86   14,349  15,372  16,573  17,309  17,85   18,726  19,348  20,659  23,443
83  -1,2433 15,3871 0,107   11,664  12,387  12,857  13,123  13,557  13,869  14,36   15,387  16,596  17,337  17,883  18,768  19,397  20,726  23,557
84  -1,2565 15,4036 0,10746 11,671  12,394  12,865  13,131  13,566  13,879  14,371  15,404  16,62   17,367  17,918  18,812  19,448  20,794  23,674
85  -1,2693 15,4211 0,10792 11,677  12,401  12,873  13,14   13,576  13,89   14,384  15,421  16,645  17,398  17,954  18,857  19,501  20,864  23,793
86  -1,2819 15,4397 0,10837 11,685  12,41   12,882  13,15   13,587  13,902  14,398  15,44   16,671  17,43   17,991  18,903  19,554  20,935  23,914
87  -1,2941 15,4593 0,10883 11,693  12,419  12,892  13,16   13,599  13,914  14,412  15,459  16,699  17,464  18,03   18,951  19,609  21,009  24,039
88  -1,306  15,4798 0,10929 11,702  12,429  12,903  13,172  13,611  13,928  14,428  15,48   16,727  17,499  18,069  19  19,666  21,084  24,167
89  -1,3175 15,5014 0,10974 11,712  12,439  12,915  13,184  13,625  13,943  14,444  15,501  16,757  17,534  18,11   19,05   19,723  21,16   24,295
90  -1,3287 15,524  0,1102  11,722  12,451  12,927  13,197  13,639  13,958  14,462  15,524  16,788  17,571  18,152  19,102  19,783  21,239  24,428
91  -1,3395 15,5476 0,11065 11,733  12,463  12,94   13,211  13,655  13,974  14,48   15,548  16,819  17,609  18,195  19,154  19,843  21,318  24,562
92  -1,3499 15,5723 0,1111  11,745  12,476  12,954  13,226  13,671  13,992  14,499  15,572  16,852  17,648  18,24   19,208  19,905  21,399  24,698
93  -1,36   15,5979 0,11156 11,757  12,489  12,969  13,241  13,688  14,01   14,52   15,598  16,887  17,689  18,286  19,264  19,969  21,483  24,838
94  -1,3697 15,6246 0,11201 11,77   12,504  12,984  13,257  13,706  14,029  14,541  15,625  16,922  17,73   18,333  19,321  20,034  21,567  24,979
95  -1,379  15,6523 0,11246 11,783  12,519  13,001  13,275  13,724  14,049  14,563  15,652  16,958  17,773  18,381  19,379  20,1    21,653  25,122
96  -1,388  15,681  0,11291 11,798  12,535  13,018  13,293  13,744  14,07   14,586  15,681  16,995  17,817  18,43   19,438  20,167  21,74   25,268
97  -1,3966 15,7107 0,11335 11,813  12,551  13,036  13,312  13,764  14,091  14,61   15,711  17,034  17,862  18,48   19,498  20,235  21,828  25,415
98  -1,4047 15,7415 0,1138  11,828  12,569  13,055  13,331  13,786  14,114  14,635  15,742  17,073  17,908  18,532  19,56   20,305  21,919  25,565
99  -1,4125 15,7732 0,11424 11,845  12,587  13,075  13,352  13,808  14,137  14,661  15,773  17,114  17,955  18,585  19,623  20,376  22,01   25,716
100 -1,4199 15,8058 0,11469 11,862  12,605  13,095  13,373  13,831  14,162  14,687  15,806  17,156  18,004  18,639  19,687  20,449  22,103  25,871
101 -1,427  15,8394 0,11513 11,879  12,625  13,116  13,395  13,854  14,187  14,715  15,839  17,198  18,053  18,693  19,752  20,522  22,198  26,026
102 -1,4336 15,8738 0,11557 11,897  12,645  13,137  13,418  13,879  14,213  14,743  15,874  17,242  18,103  18,749  19,818  20,597  22,293  26,183
103 -1,4398 15,909  0,11601 11,915  12,666  13,159  13,441  13,904  14,239  14,772  15,909  17,286  18,154  18,806  19,885  20,672  22,389  26,341
104 -1,4456 15,9451 0,11644 11,934  12,687  13,182  13,465  13,93   14,266  14,802  15,945  17,331  18,206  18,864  19,953  20,748  22,486  26,499
105 -1,4511 15,9818 0,11688 11,954  12,708  13,206  13,489  13,956  14,294  14,832  15,982  17,377  18,259  18,922  20,022  20,826  22,584  26,661
106 -1,4561 16,0194 0,11731 11,974  12,731  13,23   13,514  13,983  14,323  14,864  16,019  17,424  18,313  18,982  20,092  20,904  22,683  26,821
107 -1,4607 16,0575 0,11774 11,994  12,753  13,254  13,54   14,011  14,352  14,895  16,058  17,472  18,367  19,042  20,162  20,983  22,783  26,983
108 -1,465  16,0964 0,11816 12,014  12,776  13,279  13,566  14,039  14,382  14,928  16,096  17,52   18,422  19,102  20,233  21,062  22,882  27,144
109 -1,4688 16,1358 0,11859 12,035  12,8    13,305  13,592  14,067  14,412  14,96   16,136  17,569  18,478  19,164  20,305  21,142  22,983  27,308
110 -1,4723 16,1759 0,11901 12,057  12,824  13,331  13,62   14,097  14,443  14,994  16,176  17,618  18,535  19,226  20,378  21,223  23,084  27,471
111 -1,4753 16,2166 0,11943 12,078  12,848  13,357  13,647  14,126  14,474  15,028  16,217  17,669  18,592  19,289  20,451  21,304  23,186  27,633
112 -1,478  16,258  0,11985 12,1    12,873  13,384  13,675  14,156  14,506  15,063  16,258  17,72   18,65   19,352  20,524  21,386  23,289  27,798
113 -1,4803 16,2999 0,12026 12,122  12,898  13,411  13,704  14,187  14,538  15,098  16,3    17,771  18,708  19,416  20,598  21,468  23,391  27,96
114 -1,4823 16,3425 0,12067 12,145  12,924  13,439  13,733  14,218  14,571  15,134  16,343  17,823  18,767  19,481  20,673  21,551  23,494  28,123
115 -1,4838 16,3858 0,12108 12,168  12,95   13,467  13,762  14,25   14,605  15,17   16,386  17,876  18,827  19,546  20,749  21,635  23,598  28,286
116 -1,485  16,4298 0,12148 12,191  12,976  13,496  13,792  14,283  14,639  15,207  16,43   17,93   18,887  19,612  20,825  21,719  23,701  28,448
117 -1,4859 16,4746 0,12188 12,215  13,003  13,525  13,823  14,316  14,674  15,245  16,475  17,984  18,949  19,679  20,902  21,804  23,806  28,611
118 -1,4864 16,52   0,12228 12,24   13,031  13,555  13,854  14,349  14,709  15,283  16,52   18,039  19,011  19,746  20,979  21,889  23,911  28,774
119 -1,4866 16,5663 0,12268 12,264  13,059  13,585  13,886  14,384  14,745  15,323  16,566  18,096  19,074  19,815  21,058  21,976  24,017  28,937
120 -1,4864 16,6133 0,12307 12,29   13,088  13,616  13,919  14,418  14,782  15,362  16,613  18,152  19,137  19,884  21,137  22,063  24,123  29,098
121 -1,4859 16,6612 0,12346 12,315  13,117  13,648  13,952  14,454  14,819  15,403  16,661  18,21   19,202  19,954  21,217  22,151  24,23   29,26
122 -1,4851 16,71   0,12384 12,342  13,147  13,681  13,986  14,491  14,858  15,445  16,71   18,269  19,267  20,025  21,298  22,239  24,337  29,421
123 -1,4839 16,7595 0,12422 12,368  13,177  13,714  14,02   14,528  14,897  15,487  16,76   18,328  19,334  20,097  21,379  22,328  24,444  29,581
124 -1,4825 16,81   0,1246  12,396  13,208  13,747  14,055  14,566  14,937  15,53   16,81   18,389  19,401  20,17   21,462  22,418  24,553  29,742
125 -1,4807 16,8614 0,12497 12,424  13,24   13,782  14,092  14,604  14,977  15,574  16,861  18,45   19,469  20,244  21,545  22,509  24,661  29,901
126 -1,4787 16,9136 0,12534 12,452  13,272  13,817  14,128  14,644  15,019  15,619  16,914  18,512  19,538  20,318  21,629  22,601  24,77   30,06
127 -1,4763 16,9667 0,12571 12,481  13,305  13,852  14,165  14,684  15,061  15,664  16,967  18,575  19,608  20,394  21,714  22,693  24,88   30,219
128 -1,4737 17,0208 0,12607 12,511  13,339  13,889  14,204  14,724  15,104  15,71   17,021  18,64   19,679  20,47   21,8    22,786  24,991  30,377
129 -1,4708 17,0757 0,12643 12,54   13,373  13,926  14,242  14,766  15,147  15,758  17,076  18,705  19,751  20,547  21,887  22,88   25,102  30,534
130 -1,4677 17,1316 0,12678 12,571  13,408  13,964  14,282  14,809  15,192  15,806  17,132  18,771  19,824  20,626  21,974  22,975  25,213  30,69
131 -1,4642 17,1883 0,12713 12,602  13,444  14,002  14,322  14,852  15,237  15,854  17,188  18,838  19,898  20,705  22,063  23,07   25,325  30,845
132 -1,4606 17,2459 0,12748 12,634  13,48   14,041  14,363  14,896  15,283  15,904  17,246  18,906  19,973  20,785  22,152  23,167  25,438  31,002
133 -1,4567 17,3044 0,12782 12,666  13,516  14,081  14,405  14,94   15,33   15,955  17,304  18,974  20,048  20,866  22,242  23,264  25,55   31,155
134 -1,4526 17,3637 0,12816 12,699  13,554  14,122  14,447  14,986  15,378  16,006  17,364  19,044  20,125  20,948  22,333  23,361  25,664  31,309
135 -1,4482 17,4238 0,12849 12,732  13,592  14,163  14,49   15,032  15,426  16,058  17,424  19,114  20,202  21,03   22,424  23,459  25,777  31,46
136 -1,4436 17,4847 0,12882 12,766  13,63   14,205  14,533  15,078  15,475  16,11   17,485  19,186  20,28   21,113  22,516  23,558  25,891  31,612
137 -1,4389 17,5464 0,12914 12,801  13,669  14,247  14,578  15,126  15,525  16,164  17,546  19,258  20,359  21,197  22,609  23,658  26,005  31,761
138 -1,4339 17,6088 0,12946 12,835  13,709  14,29   14,623  15,174  15,575  16,218  17,609  19,331  20,439  21,282  22,703  23,758  26,12   31,91
139 -1,4288 17,6719 0,12978 12,87   13,749  14,333  14,668  15,222  15,626  16,273  17,672  19,404  20,519  21,368  22,797  23,858  26,235  32,06
140 -1,4235 17,7357 0,13009 12,906  13,79   14,377  14,714  15,271  15,678  16,328  17,736  19,478  20,6    21,454  22,892  23,959  26,35   32,206
141 -1,418  17,8001 0,1304  12,942  13,831  14,422  14,76   15,321  15,73   16,384  17,8    19,553  20,682  21,54   22,987  24,061  26,465  32,353
142 -1,4123 17,8651 0,1307  12,978  13,872  14,467  14,807  15,371  15,782  16,441  17,865  19,629  20,764  21,628  23,082  24,162  26,579  32,496
143 -1,4065 17,9306 0,13099 13,015  13,914  14,512  14,855  15,422  15,836  16,498  17,931  19,705  20,846  21,715  23,178  24,264  26,694  32,638
144 -1,4006 17,9966 0,13129 13,052  13,956  14,558  14,902  15,473  15,889  16,555  17,997  19,781  20,929  21,803  23,275  24,366  26,809  32,781
145 -1,3945 18,063  0,13158 13,089  13,999  14,604  14,95   15,524  15,943  16,613  18,063  19,858  21,013  21,892  23,371  24,469  26,924  32,922
146 -1,3883 18,1297 0,13186 13,126  14,041  14,65   14,999  15,576  15,997  16,671  18,13   19,935  21,096  21,98   23,467  24,571  27,038  33,059
147 -1,3819 18,1967 0,13214 13,164  14,084  14,696  15,047  15,628  16,052  16,73   18,197  20,012  21,18   22,069  23,564  24,673  27,152  33,196
148 -1,3755 18,2639 0,13241 13,201  14,127  14,743  15,096  15,68   16,106  16,788  18,264  20,09   21,264  22,157  23,66   24,775  27,265  33,33
149 -1,3689 18,3312 0,13268 13,239  14,17   14,79   15,145  15,733  16,161  16,847  18,331  20,167  21,348  22,246  23,756  24,876  27,378  33,463
150 -1,3621 18,3986 0,13295 13,276  14,213  14,836  15,193  15,785  16,216  16,906  18,399  20,245  21,432  22,335  23,853  24,978  27,49   33,594
151 -1,3553 18,466  0,13321 13,314  14,256  14,883  15,242  15,837  16,271  16,965  18,466  20,323  21,516  22,423  23,948  25,079  27,601  33,723
152 -1,3483 18,5333 0,13347 13,351  14,299  14,93   15,291  15,889  16,325  17,024  18,533  20,4    21,6    22,511  24,044  25,179  27,712  33,85
153 -1,3413 18,6006 0,13372 13,389  14,342  14,976  15,34   15,942  16,38   17,082  18,601  20,477  21,683  22,599  24,139  25,279  27,821  33,974
154 -1,3341 18,6677 0,13397 13,426  14,385  15,023  15,388  15,994  16,435  17,141  18,668  20,555  21,766  22,687  24,233  25,378  27,929  34,097
155 -1,3269 18,7346 0,13421 13,463  14,428  15,069  15,437  16,046  16,489  17,2    18,735  20,631  21,849  22,774  24,327  25,477  28,036  34,216
156 -1,3195 18,8012 0,13445 13,499  14,47   15,115  15,485  16,097  16,544  17,258  18,801  20,708  21,931  22,86   24,42   25,574  28,143  34,333
157 -1,3121 18,8675 0,13469 13,536  14,512  15,161  15,533  16,149  16,598  17,316  18,868  20,784  22,013  22,946  24,513  25,671  28,248  34,449
158 -1,3046 18,9335 0,13492 13,572  14,554  15,207  15,581  16,2    16,651  17,373  18,934  20,859  22,094  23,032  24,605  25,767  28,352  34,561
159 -1,297  18,9991 0,13514 13,608  14,595  15,252  15,628  16,251  16,705  17,431  18,999  20,934  22,175  23,116  24,695  25,862  28,454  34,67
160 -1,2894 19,0642 0,13537 13,643  14,636  15,297  15,675  16,301  16,758  17,488  19,064  21,009  22,255  23,201  24,786  25,956  28,556  34,779
161 -1,2816 19,1289 0,13559 13,678  14,677  15,341  15,722  16,351  16,81   17,544  19,129  21,083  22,335  23,284  24,875  26,05   28,655  34,884
162 -1,2739 19,1931 0,1358  13,713  14,718  15,386  15,768  16,401  16,862  17,6    19,193  21,156  22,413  23,367  24,963  26,141  28,753  34,986
163 -1,2661 19,2567 0,13601 13,748  14,758  15,429  15,814  16,451  16,914  17,656  19,257  21,229  22,491  23,448  25,05   26,232  28,85   35,086
164 -1,2583 19,3197 0,13622 13,781  14,797  15,472  15,859  16,499  16,965  17,711  19,32   21,301  22,569  23,529  25,137  26,322  28,946  35,185
165 -1,2504 19,382  0,13642 13,815  14,836  15,515  15,904  16,547  17,016  17,765  19,382  21,372  22,645  23,609  25,222  26,41   29,039  35,279
166 -1,2425 19,4437 0,13662 13,848  14,875  15,557  15,948  16,595  17,066  17,819  19,444  21,443  22,72   23,688  25,306  26,497  29,132  35,373
167 -1,2345 19,5045 0,13681 13,88   14,913  15,599  15,992  16,642  17,115  17,872  19,504  21,512  22,795  23,765  25,388  26,583  29,222  35,461
168 -1,2266 19,5647 0,137   13,912  14,95   15,64   16,035  16,688  17,164  17,925  19,565  21,581  22,868  23,842  25,47   26,667  29,311  35,549
169 -1,2186 19,624  0,13719 13,943  14,987  15,68   16,077  16,734  17,212  17,977  19,624  21,648  22,94   23,918  25,55   26,75   29,398  35,634
170 -1,2107 19,6824 0,13738 13,973  15,023  15,72   16,119  16,779  17,259  18,028  19,682  21,715  23,012  23,992  25,629  26,832  29,484  35,719
171 -1,2027 19,74   0,13756 14,003  15,058  15,759  16,16   16,823  17,306  18,078  19,74   21,781  23,082  24,065  25,707  26,912  29,568  35,799
172 -1,1947 19,7966 0,13774 14,033  15,093  15,797  16,2    16,867  17,352  18,127  19,797  21,845  23,151  24,137  25,783  26,991  29,65   35,877
173 -1,1867 19,8523 0,13791 14,061  15,127  15,834  16,239  16,909  17,397  18,176  19,852  21,909  23,219  24,208  25,857  27,067  29,729  35,951
174 -1,1788 19,907  0,13808 14,089  15,16   15,871  16,278  16,951  17,441  18,223  19,907  21,971  23,285  24,277  25,93   27,143  29,808  36,024
175 -1,1708 19,9607 0,13825 14,116  15,193  15,907  16,316  16,992  17,484  18,27   19,961  22,032  23,35   24,345  26,002  27,217  29,884  36,094
176 -1,1629 20,0133 0,13841 14,143  15,224  15,942  16,353  17,033  17,527  18,316  20,013  22,092  23,414  24,411  26,072  27,288  29,958  36,161
177 -1,1549 20,0648 0,13858 14,168  15,255  15,976  16,389  17,072  17,568  18,361  20,065  22,151  23,477  24,477  26,141  27,359  30,031  36,227
178 -1,147  20,1152 0,13873 14,194  15,285  16,01   16,425  17,11   17,609  18,404  20,115  22,208  23,538  24,54   26,207  27,427  30,1    36,288
179 -1,139  20,1644 0,13889 14,218  15,314  16,042  16,459  17,147  17,648  18,447  20,164  22,264  23,598  24,602  26,273  27,494  30,169  36,348
180 -1,1311 20,2125 0,13904 14,241  15,343  16,074  16,492  17,184  17,687  18,489  20,212  22,319  23,656  24,663  26,336  27,559  30,235  36,404
181 -1,1232 20,2595 0,1392  14,263  15,37   16,105  16,525  17,219  17,724  18,529  20,26   22,373  23,713  24,722  26,398  27,623  30,3    36,461
182 -1,1153 20,3053 0,13934 14,285  15,397  16,135  16,557  17,254  17,761  18,569  20,305  22,425  23,768  24,779  26,458  27,684  30,361  36,511
183 -1,1074 20,3499 0,13949 14,306  15,423  16,164  16,587  17,287  17,796  18,608  20,35   22,476  23,822  24,836  26,517  27,744  30,422  36,561
184 -1,0996 20,3934 0,13963 14,326  15,448  16,192  16,617  17,32   17,831  18,645  20,393  22,525  23,875  24,89   26,574  27,802  30,48   36,608
185 -1,0917 20,4357 0,13977 14,345  15,472  16,219  16,646  17,352  17,864  18,682  20,436  22,573  23,926  24,943  26,629  27,858  30,536  36,652
186 -1,0838 20,4769 0,13991 14,364  15,495  16,245  16,674  17,382  17,897  18,717  20,477  22,62   23,976  24,995  26,683  27,913  30,591  36,695
187 -1,076  20,517  0,14005 14,381  15,517  16,27   16,701  17,412  17,928  18,752  20,517  22,666  24,025  25,045  26,735  27,966  30,643  36,735
188 -1,0681 20,556  0,14018 14,398  15,539  16,295  16,727  17,441  17,959  18,785  20,556  22,71   24,072  25,094  26,785  28,017  30,693  36,772
189 -1,0603 20,5938 0,14031 14,415  15,56   16,319  16,752  17,469  17,989  18,818  20,594  22,754  24,117  25,141  26,834  28,066  30,742  36,806
190 -1,0525 20,6306 0,14044 14,43   15,58   16,342  16,777  17,496  18,018  18,849  20,631  22,795  24,162  25,187  26,882  28,114  30,789  36,84
191 -1,0447 20,6663 0,14057 14,445  15,599  16,363  16,8    17,522  18,045  18,88   20,666  22,836  24,205  25,231  26,928  28,16   30,834  36,871
192 -1,0368 20,7008 0,1407  14,458  15,617  16,384  16,823  17,547  18,072  18,909  20,701  22,876  24,247  25,274  26,972  28,205  30,877  36,899
193 -1,029  20,7344 0,14082 14,472  15,635  16,405  16,845  17,571  18,098  18,938  20,734  22,914  24,287  25,316  27,015  28,248  30,918  36,925
194 -1,0212 20,7668 0,14094 14,484  15,651  16,424  16,866  17,595  18,123  18,966  20,767  22,951  24,326  25,356  27,056  28,289  30,957  36,948
195 -1,0134 20,7982 0,14106 14,496  15,667  16,443  16,886  17,617  18,148  18,992  20,798  22,987  24,364  25,395  27,096  28,329  30,995  36,97
196 -1,0055 20,8286 0,14118 14,506  15,682  16,461  16,905  17,639  18,171  19,018  20,829  23,021  24,4    25,433  27,134  28,367  31,031  36,989
197 -0,9977 20,858  0,1413  14,517  15,697  16,478  16,924  17,66   18,193  19,043  20,858  23,055  24,436  25,469  27,171  28,404  31,065  37,008
198 -0,9898 20,8863 0,14142 14,526  15,71   16,494  16,941  17,679  18,215  19,067  20,886  23,087  24,47   25,504  27,207  28,439  31,098  37,024
199 -0,9819 20,9137 0,14153 14,535  15,723  16,509  16,958  17,699  18,235  19,09   20,914  23,119  24,503  25,538  27,241  28,473  31,128  37,036
200 -0,974  20,9401 0,14164 14,543  15,735  16,524  16,974  17,717  18,255  19,112  20,94   23,149  24,535  25,57   27,273  28,505  31,157  37,047
201 -0,9661 20,9656 0,14176 14,55   15,746  16,538  16,989  17,734  18,274  19,133  20,966  23,178  24,565  25,601  27,305  28,536  31,186  37,058
202 -0,9582 20,9901 0,14187 14,556  15,757  16,551  17,004  17,751  18,292  19,154  20,99   23,206  24,595  25,631  27,335  28,566  31,212  37,066
203 -0,9503 21,0138 0,14198 14,562  15,767  16,564  17,018  17,767  18,31   19,173  21,014  23,233  24,623  25,66   27,364  28,594  31,236  37,072
204 -0,9423 21,0367 0,14208 14,568  15,777  16,576  17,031  17,783  18,327  19,193  21,037  23,259  24,651  25,688  27,392  28,62   31,259  37,075
205 -0,9344 21,0587 0,14219 14,573  15,785  16,587  17,044  17,797  18,343  19,211  21,059  23,285  24,677  25,715  27,418  28,646  31,281  37,078
206 -0,9264 21,0801 0,1423  14,577  15,793  16,597  17,056  17,811  18,358  19,228  21,08   23,309  24,703  25,741  27,444  28,672  31,302  37,08
207 -0,9184 21,1007 0,1424  14,581  15,801  16,607  17,067  17,825  18,373  19,245  21,101  23,333  24,727  25,766  27,469  28,695  31,321  37,079
208 -0,9104 21,1206 0,1425  14,584  15,808  16,617  17,078  17,838  18,388  19,262  21,121  23,355  24,751  25,79   27,492  28,717  31,339  37,077
209 -0,9024 21,1399 0,14261 14,587  15,815  16,626  17,088  17,85   18,401  19,277  21,14   23,378  24,774  25,813  27,515  28,739  31,357  37,076
210 -0,8944 21,1586 0,14271 14,589  15,821  16,635  17,098  17,862  18,414  19,292  21,159  23,399  24,796  25,836  27,537  28,76   31,373  37,072
211 -0,8863 21,1768 0,14281 14,591  15,827  16,643  17,108  17,873  18,427  19,307  21,177  23,42   24,818  25,857  27,558  28,78   31,388  37,067
212 -0,8783 21,1944 0,14291 14,593  15,832  16,65   17,116  17,884  18,439  19,321  21,194  23,44   24,839  25,878  27,578  28,799  31,403  37,061
213 -0,8703 21,2116 0,14301 14,594  15,837  16,658  17,125  17,895  18,451  19,335  21,212  23,46   24,859  25,899  27,598  28,817  31,417  37,055
214 -0,8623 21,2282 0,14311 14,595  15,842  16,665  17,133  17,905  18,463  19,348  21,228  23,479  24,879  25,919  27,617  28,835  31,43   37,048
215 -0,8542 21,2444 0,1432  14,596  15,846  16,671  17,141  17,915  18,474  19,361  21,244  23,498  24,898  25,938  27,635  28,852  31,441  37,038
216 -0,8462 21,2603 0,1433  14,596  15,85   16,678  17,149  17,924  18,485  19,374  21,26   23,516  24,917  25,957  27,653  28,868  31,453  37,031
217 -0,8382 21,2757 0,1434  14,596  15,854  16,683  17,156  17,933  18,495  19,386  21,276  23,534  24,936  25,975  27,671  28,884  31,464  37,022
218 -0,8301 21,2908 0,14349 14,596  15,857  16,689  17,163  17,942  18,505  19,398  21,291  23,551  24,953  25,993  27,687  28,899  31,474  37,011
219 -0,8221 21,3055 0,14359 14,595  15,86   16,694  17,169  17,95   18,515  19,41   21,306  23,568  24,971  26,01   27,704  28,915  31,484  37,002
220 -0,814  21,32   0,14368 14,594  15,863  16,7    17,176  17,959  18,524  19,421  21,32   23,585  24,988  26,027  27,719  28,929  31,493  36,99
221 -0,806  21,3341 0,14377 14,593  15,866  16,705  17,182  17,967  18,534  19,432  21,334  23,601  25,004  26,043  27,734  28,942  31,502  36,978
222 -0,798  21,348  0,14386 14,592  15,869  16,709  17,188  17,975  18,543  19,443  21,348  23,617  25,021  26,059  27,749  28,956  31,51   36,966
223 -0,7899 21,3617 0,14396 14,59   15,871  16,714  17,193  17,982  18,552  19,454  21,362  23,633  25,037  26,076  27,764  28,969  31,519  36,955
224 -0,7819 21,3752 0,14405 14,589  15,873  16,718  17,199  17,99   18,56   19,464  21,375  23,648  25,053  26,091  27,779  28,982  31,526  36,943
225 -0,7738 21,3884 0,14414 14,587  15,875  16,722  17,204  17,997  18,569  19,475  21,388  23,663  25,068  26,106  27,793  28,995  31,533  36,929
226 -0,7658 21,4014 0,14423 14,585  15,876  16,726  17,21   18,004  18,577  19,485  21,401  23,678  25,084  26,121  27,807  29,007  31,54   36,917
227 -0,7577 21,4143 0,14432 14,583  15,878  16,73   17,215  18,011  18,585  19,495  21,414  23,693  25,099  26,136  27,82   29,019  31,547  36,903
228 -0,7496 21,4269 0,14441 14,58   15,879  16,734  17,22   18,017  18,593  19,504  21,427  23,707  25,113  26,151  27,833  29,03   31,553  36,889';
$percentile_arr = '0    -0,3053 13,4069 0,0956  10,1    10,8    11,3    11,5    11,9    12,2    12,6    13,4    14,3    14,8    15,2    15,8    16,1    16,9    18,3
1   0,2708  14,9441 0,09027 11,2    12  12,6    12,8    13,3    13,6    14,1    14,9    15,9    16,4    16,7    17,3    17,6    18,3    19,6
2   0,1118  16,3195 0,08677 12,4    13,3    13,8    14,1    14,6    14,9    15,4    16,3    17,3    17,8    18,2    18,8    19,2    19,9    21,3
3   0,0068  16,8987 0,08495 13  13,9    14,4    14,7    15,2    15,5    16  16,9    17,9    18,5    18,8    19,4    19,8    20,6    22
4   -0,0727 17,1579 0,08378 13,3    14,1    14,7    15  15,4    15,7    16,2    17,2    18,2    18,7    19,1    19,7    20,1    20,9    22,3
5   -0,137  17,2919 0,08296 13,4    14,3    14,8    15,1    15,6    15,9    16,4    17,3    18,3    18,9    19,2    19,8    20,2    21  22,4
6   -0,1913 17,3422 0,08234 13,5    14,4    14,9    15,2    15,6    15,9    16,4    17,3    18,3    18,9    19,3    19,9    20,3    21,1    22,5
7   -0,2385 17,3288 0,08183 13,6    14,4    14,9    15,2    15,6    15,9    16,4    17,3    18,3    18,9    19,3    19,9    20,3    21,1    22,5
8   -0,2802 17,2647 0,0814  13,5    14,4    14,9    15,1    15,6    15,9    16,3    17,3    18,2    18,8    19,2    19,8    20,2    21  22,4
9   -0,3176 17,1662 0,08102 13,5    14,3    14,8    15,1    15,5    15,8    16,3    17,2    18,1    18,7    19,1    19,7    20,1    20,8    22,3
10  -0,3516 17,0488 0,08068 13,4    14,2    14,7    15  15,4    15,7    16,2    17  18  18,6    18,9    19,5    19,9    20,7    22,1
11  -0,3828 16,9239 0,08037 13,3    14,1    14,6    14,9    15,3    15,6    16  16,9    17,9    18,4    18,8    19,4    19,8    20,5    22
12  -0,4115 16,7981 0,08009 13,3    14  14,5    14,8    15,2    15,5    15,9    16,8    17,7    18,3    18,7    19,2    19,6    20,4    21,8
13  -0,4382 16,6743 0,07982 13,2    13,9    14,4    14,7    15,1    15,4    15,8    16,7    17,6    18,1    18,5    19,1    19,5    20,2    21,6
14  -0,463  16,5548 0,07958 13,1    13,9    14,3    14,6    15  15,3    15,7    16,6    17,5    18  18,4    18,9    19,3    20,1    21,5
15  -0,4863 16,4409 0,07935 13  13,8    14,2    14,5    14,9    15,2    15,6    16,4    17,4    17,9    18,2    18,8    19,2    19,9    21,3
16  -0,5082 16,3335 0,07913 13  13,7    14,2    14,4    14,8    15,1    15,5    16,3    17,2    17,8    18,1    18,7    19,1    19,8    21,2
17  -0,5289 16,2329 0,07892 12,9    13,6    14,1    14,3    14,7    15  15,4    16,2    17,1    17,6    18  18,6    18,9    19,7    21,1
18  -0,5484 16,1392 0,07873 12,8    13,6    14  14,2    14,6    14,9    15,3    16,1    17  17,5    17,9    18,5    18,8    19,6    21
19  -0,5669 16,0528 0,07854 12,8    13,5    13,9    14,2    14,6    14,8    15,2    16,1    16,9    17,4    17,8    18,4    18,7    19,5    20,8
20  -0,5846 15,9743 0,07836 12,7    13,4    13,9    14,1    14,5    14,8    15,2    16  16,9    17,4    17,7    18,3    18,6    19,4    20,7
21  -0,6014 15,9039 0,07818 12,7    13,4    13,8    14,1    14,4    14,7    15,1    15,9    16,8    17,3    17,6    18,2    18,6    19,3    20,6
22  -0,6174 15,8412 0,07802 12,7    13,3    13,8    14  14,4    14,6    15  15,8    16,7    17,2    17,6    18,1    18,5    19,2    20,6
23  -0,6328 15,7852 0,07786 12,6    13,3    13,7    14  14,3    14,6    15  15,8    16,7    17,1    17,5    18  18,4    19,1    20,5
24  -0,6473 15,7356 0,07771 12,6    13,3    13,7    13,9    14,3    14,5    14,9    15,7    16,6    17,1    17,4    18  18,3    19,1    20,4
25  -0,584  15,98   0,07792 12,8    13,5    13,9    14,1    14,5    14,8    15,2    16  16,9    17,4    17,7    18,3    18,6    19,4    20,7
26  -0,5497 15,9414 0,078   12,7    13,4    13,8    14,1    14,5    14,7    15,1    15,9    16,8    17,3    17,7    18,2    18,6    19,3    20,6
27  -0,5166 15,9036 0,07808 12,7    13,4    13,8    14  14,4    14,7    15,1    15,9    16,8    17,3    17,6    18,2    18,5    19,2    20,6
28  -0,485  15,8667 0,07818 12,6    13,3    13,8    14  14,4    14,7    15,1    15,9    16,7    17,2    17,6    18,1    18,5    19,2    20,5
29  -0,4552 15,8306 0,07829 12,6    13,3    13,7    14  14,4    14,6    15  15,8    16,7    17,2    17,5    18,1    18,4    19,1    20,5
30  -0,4274 15,7953 0,07841 12,5    13,3    13,7    13,9    14,3    14,6    15  15,8    16,7    17,2    17,5    18  18,4    19,1    20,4
31  -0,4016 15,7606 0,07854 12,5    13,2    13,7    13,9    14,3    14,5    15  15,8    16,6    17,1    17,5    18  18,4    19,1    20,3
32  -0,3782 15,7267 0,07867 12,5    13,2    13,6    13,9    14,2    14,5    14,9    15,7    16,6    17,1    17,4    18  18,3    19  20,3
33  -0,3572 15,6934 0,07882 12,4    13,1    13,6    13,8    14,2    14,5    14,9    15,7    16,6    17  17,4    17,9    18,3    19  20,2
34  -0,3388 15,661  0,07897 12,4    13,1    13,5    13,8    14,2    14,4    14,9    15,7    16,5    17  17,4    17,9    18,2    18,9    20,2
35  -0,3231 15,6294 0,07914 12,4    13,1    13,5    13,8    14,1    14,4    14,8    15,6    16,5    17  17,3    17,9    18,2    18,9    20,2
36  -0,3101 15,5988 0,07931 12,3    13  13,5    13,7    14,1    14,4    14,8    15,6    16,5    17  17,3    17,8    18,2    18,9    20,1
37  -0,3    15,5693 0,0795  12,3    13  13,5    13,7    14,1    14,4    14,8    15,6    16,4    16,9    17,3    17,8    18,1    18,8    20,1
38  -0,2927 15,541  0,07969 12,3    13  13,4    13,7    14,1    14,3    14,7    15,5    16,4    16,9    17,2    17,8    18,1    18,8    20,1
39  -0,2884 15,514  0,0799  12,2    12,9    13,4    13,6    14  14,3    14,7    15,5    16,4    16,9    17,2    17,7    18,1    18,8    20
40  -0,2869 15,4885 0,08012 12,2    12,9    13,4    13,6    14  14,3    14,7    15,5    16,4    16,8    17,2    17,7    18,1    18,8    20
41  -0,2881 15,4645 0,08036 12,2    12,9    13,3    13,6    14  14,2    14,7    15,5    16,3    16,8    17,2    17,7    18  18,7    20
42  -0,2919 15,442  0,08061 12,1    12,9    13,3    13,6    13,9    14,2    14,6    15,4    16,3    16,8    17,1    17,7    18  18,7    20
43  -0,2981 15,421  0,08087 12,1    12,8    13,3    13,5    13,9    14,2    14,6    15,4    16,3    16,8    17,1    17,7    18  18,7    20
44  -0,3067 15,4013 0,08115 12,1    12,8    13,3    13,5    13,9    14,2    14,6    15,4    16,3    16,8    17,1    17,7    18  18,7    20
45  -0,3174 15,3827 0,08144 12,1    12,8    13,2    13,5    13,9    14,2    14,6    15,4    16,3    16,8    17,1    17,6    18  18,7    20
46  -0,3303 15,3652 0,08174 12,1    12,8    13,2    13,5    13,9    14,1    14,5    15,4    16,2    16,7    17,1    17,6    18  18,7    20
47  -0,3452 15,3485 0,08205 12  12,8    13,2    13,5    13,8    14,1    14,5    15,3    16,2    16,7    17,1    17,6    18  18,7    20
48  -0,3622 15,3326 0,08238 12  12,7    13,2    13,4    13,8    14,1    14,5    15,3    16,2    16,7    17,1    17,6    18  18,7    20
49  -0,3811 15,3174 0,08272 12  12,7    13,2    13,4    13,8    14,1    14,5    15,3    16,2    16,7    17,1    17,6    18  18,7    20
50  -0,4019 15,3029 0,08307 12  12,7    13,2    13,4    13,8    14,1    14,5    15,3    16,2    16,7    17,1    17,6    18  18,7    20,1
51  -0,4245 15,2891 0,08343 12  12,7    13,1    13,4    13,8    14  14,5    15,3    16,2    16,7    17,1    17,6    18  18,7    20,1
52  -0,4488 15,2759 0,0838  12  12,7    13,1    13,4    13,8    14  14,4    15,3    16,2    16,7    17,1    17,6    18  18,7    20,1
53  -0,4747 15,2633 0,08418 11,9    12,7    13,1    13,3    13,7    14  14,4    15,3    16,2    16,7    17,1    17,6    18  18,7    20,1
54  -0,5019 15,2514 0,08457 11,9    12,6    13,1    13,3    13,7    14  14,4    15,3    16,2    16,7    17  17,6    18  18,8    20,2
55  -0,5303 15,24   0,08496 11,9    12,6    13,1    13,3    13,7    14  14,4    15,2    16,2    16,7    17  17,6    18  18,8    20,2
56  -0,5599 15,2291 0,08536 11,9    12,6    13,1    13,3    13,7    14  14,4    15,2    16,1    16,7    17  17,6    18  18,8    20,3
57  -0,5905 15,2188 0,08577 11,9    12,6    13  13,3    13,7    14  14,4    15,2    16,1    16,7    17,1    17,6    18  18,8    20,3
58  -0,6223 15,2091 0,08617 11,9    12,6    13  13,3    13,7    13,9    14,4    15,2    16,1    16,7    17,1    17,6    18  18,8    20,3
59  -0,6552 15,2    0,08659 11,9    12,6    13  13,3    13,7    13,9    14,4    15,2    16,1    16,7    17,1    17,7    18,1    18,9    20,4
60  -0,6892 15,1916 0,087   11,9    12,6    13  13,3    13,6    13,9    14,3    15,2    16,1    16,7    17,1    17,7    18,1    18,9    20,5
61  -0,7387 15,2641 0,0839  12,041  12,72   13,148  13,384  13,764  14,03   14,441  15,264  16,172  16,7    17,074  17,656  18,052  18,845  20,355
62  -0,7621 15,2616 0,08414 12,039  12,716  13,144  13,38   13,759  14,026  14,437  15,262  16,173  16,703  17,079  17,665  18,065  18,865  20,392
63  -0,7856 15,2604 0,08439 12,037  12,714  13,14   13,377  13,756  14,023  14,434  15,26   16,175  16,708  17,086  17,677  18,08   18,887  20,432
64  -0,8089 15,2605 0,08464 12,037  12,712  13,138  13,374  13,754  14,02   14,432  15,26   16,179  16,714  17,095  17,689  18,096  18,911  20,474
65  -0,8322 15,2619 0,0849  12,038  12,711  13,137  13,373  13,752  14,019  14,432  15,262  16,184  16,722  17,106  17,704  18,114  18,937  20,519
66  -0,8554 15,2645 0,08516 12,039  12,712  13,137  13,373  13,752  14,019  14,432  15,264  16,191  16,732  17,118  17,721  18,134  18,965  20,567
67  -0,8785 15,2684 0,08543 12,042  12,713  13,138  13,374  13,753  14,02   14,434  15,268  16,198  16,743  17,131  17,739  18,156  18,995  20,618
68  -0,9015 15,2737 0,0857  12,045  12,715  13,14   13,376  13,755  14,023  14,437  15,274  16,208  16,755  17,146  17,759  18,18   19,028  20,671
69  -0,9243 15,2801 0,08597 12,049  12,718  13,143  13,379  13,758  14,026  14,441  15,28   16,218  16,769  17,163  17,78   18,205  19,062  20,726
70  -0,9471 15,2877 0,08625 12,054  12,722  13,146  13,382  13,762  14,031  14,446  15,288  16,23   16,784  17,181  17,804  18,232  19,098  20,785
71  -0,9697 15,2965 0,08653 12,06   12,727  13,151  13,387  13,767  14,036  14,452  15,296  16,244  16,801  17,201  17,828  18,261  19,136  20,846
72  -0,9921 15,3062 0,08682 12,066  12,733  13,157  13,393  13,773  14,042  14,459  15,306  16,258  16,819  17,221  17,854  18,291  19,176  20,91
73  -1,0144 15,3169 0,08711 12,073  12,739  13,163  13,399  13,78   14,049  14,467  15,317  16,273  16,838  17,244  17,882  18,323  19,217  20,975
74  -1,0365 15,3285 0,08741 12,08   12,746  13,17   13,406  13,787  14,057  14,476  15,328  16,29   16,858  17,267  17,911  18,356  19,261  21,044
75  -1,0584 15,3408 0,08771 12,088  12,753  13,177  13,413  13,795  14,065  14,485  15,341  16,307  16,879  17,291  17,941  18,39   19,305  21,114
76  -1,0801 15,354  0,08802 12,096  12,761  13,185  13,422  13,804  14,075  14,495  15,354  16,326  16,902  17,317  17,972  18,426  19,352  21,188
77  -1,1017 15,3679 0,08833 12,105  12,769  13,193  13,43   13,813  14,084  14,506  15,368  16,345  16,925  17,343  18,004  18,463  19,4    21,263
78  -1,123  15,3825 0,08865 12,114  12,778  13,202  13,439  13,823  14,095  14,518  15,382  16,365  16,949  17,37   18,038  18,501  19,449  21,341
79  -1,1441 15,3978 0,08898 12,124  12,787  13,212  13,449  13,833  14,105  14,529  15,398  16,386  16,974  17,399  18,073  18,541  19,501  21,421
80  -1,1649 15,4137 0,08931 12,133  12,797  13,222  13,459  13,843  14,117  14,542  15,414  16,407  17  17,428  18,108  18,582  19,553  21,504
81  -1,1856 15,4302 0,08964 12,143  12,807  13,232  13,47   13,855  14,128  14,555  15,43   16,429  17,026  17,458  18,145  18,623  19,607  21,588
82  -1,206  15,4473 0,08998 12,154  12,817  13,242  13,481  13,866  14,141  14,569  15,447  16,452  17,054  17,489  18,183  18,666  19,662  21,675
83  -1,2261 15,465  0,09033 12,164  12,828  13,253  13,492  13,878  14,153  14,582  15,465  16,476  17,082  17,521  18,221  18,71   19,719  21,764
84  -1,246  15,4832 0,09068 12,175  12,839  13,265  13,504  13,891  14,166  14,597  15,483  16,5    17,111  17,554  18,261  18,756  19,777  21,855
85  -1,2656 15,5019 0,09103 12,186  12,85   13,276  13,516  13,904  14,18   14,612  15,502  16,525  17,14   17,588  18,301  18,801  19,836  21,948
86  -1,2849 15,521  0,09139 12,198  12,861  13,288  13,528  13,917  14,194  14,627  15,521  16,55   17,17   17,622  18,343  18,848  19,896  22,044
87  -1,304  15,5407 0,09176 12,209  12,873  13,301  13,54   13,93   14,208  14,643  15,541  16,577  17,202  17,657  18,385  18,897  19,958  22,142
88  -1,3228 15,5608 0,09213 12,221  12,885  13,313  13,553  13,944  14,223  14,659  15,561  16,603  17,233  17,692  18,428  18,945  20,021  22,243
89  -1,3414 15,5814 0,09251 12,232  12,897  13,326  13,567  13,958  14,238  14,675  15,581  16,631  17,265  17,729  18,472  18,996  20,086  22,346
90  -1,3596 15,6023 0,09289 12,244  12,909  13,339  13,58   13,972  14,253  14,692  15,602  16,658  17,298  17,766  18,517  19,047  20,151  22,45
91  -1,3776 15,6237 0,09327 12,257  12,922  13,352  13,594  13,987  14,268  14,709  15,624  16,686  17,332  17,803  18,562  19,098  20,218  22,557
92  -1,3953 15,6455 0,09366 12,269  12,935  13,365  13,608  14,002  14,284  14,726  15,646  16,715  17,366  17,842  18,609  19,151  20,286  22,667
93  -1,4126 15,6677 0,09406 12,281  12,948  13,379  13,622  14,017  14,3    14,744  15,668  16,744  17,4    17,881  18,656  19,205  20,356  22,779
94  -1,4297 15,6903 0,09445 12,294  12,961  13,393  13,636  14,033  14,317  14,762  15,69   16,774  17,435  17,921  18,704  19,259  20,426  22,892
95  -1,4464 15,7133 0,09486 12,307  12,975  13,407  13,651  14,049  14,333  14,781  15,713  16,804  17,471  17,961  18,753  19,315  20,498  23,009
96  -1,4629 15,7368 0,09526 12,32   12,988  13,422  13,666  14,065  14,35   14,799  15,737  16,835  17,508  18,002  18,802  19,371  20,57   23,127
97  -1,479  15,7606 0,09567 12,333  13,002  13,436  13,681  14,081  14,368  14,819  15,761  16,867  17,544  18,044  18,852  19,428  20,645  23,249
98  -1,4947 15,7848 0,09609 12,346  13,016  13,451  13,697  14,098  14,385  14,838  15,785  16,898  17,582  18,086  18,904  19,486  20,72   23,373
99  -1,5101 15,8094 0,09651 12,359  13,03   13,466  13,712  14,115  14,403  14,858  15,809  16,931  17,62   18,129  18,956  19,545  20,797  23,499
100 -1,5252 15,8344 0,09693 12,373  13,045  13,482  13,728  14,132  14,421  14,878  15,834  16,963  17,659  18,172  19,008  19,605  20,874  23,627
101 -1,5399 15,8597 0,09735 12,386  13,059  13,497  13,745  14,149  14,44   14,898  15,86   16,996  17,698  18,216  19,061  19,666  20,953  23,756
102 -1,5542 15,8855 0,09778 12,4    13,074  13,513  13,761  14,167  14,459  14,919  15,886  17,03   17,738  18,261  19,115  19,727  21,033  23,89
103 -1,5681 15,9116 0,09821 12,414  13,089  13,529  13,778  14,185  14,478  14,94   15,912  17,064  17,778  18,306  19,17   19,789  21,114  24,024
104 -1,5817 15,9381 0,09864 12,428  13,104  13,545  13,795  14,203  14,497  14,961  15,938  17,099  17,818  18,352  19,225  19,852  21,196  24,161
105 -1,5948 15,9651 0,09907 12,442  13,12   13,562  13,812  14,222  14,517  14,983  15,965  17,134  17,86   18,399  19,281  19,916  21,278  24,3
106 -1,6076 15,9925 0,09951 12,457  13,135  13,579  13,83   14,241  14,537  15,005  15,992  17,17   17,902  18,446  19,338  19,981  21,363  24,442
107 -1,6199 16,0205 0,09994 12,472  13,152  13,596  13,848  14,26   14,558  15,028  16,02   17,206  17,944  18,493  19,395  20,046  21,448  24,585
108 -1,6318 16,049  0,10038 12,487  13,168  13,614  13,866  14,28   14,579  15,051  16,049  17,243  17,987  18,542  19,453  20,112  21,534  24,731
109 -1,6433 16,0781 0,10082 12,502  13,185  13,632  13,885  14,3    14,6    15,074  16,078  17,28   18,031  18,591  19,513  20,18   21,622  24,879
110 -1,6544 16,1078 0,10126 12,518  13,202  13,65   13,904  14,321  14,622  15,098  16,108  17,319  18,076  18,641  19,573  20,248  21,711  25,029
111 -1,6651 16,1381 0,1017  12,534  13,22   13,669  13,924  14,343  14,645  15,123  16,138  17,357  18,121  18,692  19,634  20,317  21,801  25,182
112 -1,6753 16,1692 0,10214 12,55   13,238  13,689  13,944  14,364  14,668  15,149  16,169  17,397  18,168  18,744  19,696  20,388  21,892  25,337
113 -1,6851 16,2009 0,10259 12,567  13,256  13,708  13,965  14,387  14,691  15,175  16,201  17,438  18,215  18,797  19,759  20,459  21,985  25,495
114 -1,6944 16,2333 0,10303 12,584  13,275  13,729  13,986  14,41   14,716  15,201  16,233  17,479  18,263  18,85   19,823  20,531  22,078  25,654
115 -1,7032 16,2665 0,10347 12,602  13,295  13,75   14,008  14,433  14,741  15,228  16,266  17,521  18,311  18,905  19,887  20,605  22,173  25,814
116 -1,7116 16,3004 0,10391 12,62   13,315  13,771  14,031  14,458  14,766  15,256  16,3    17,564  18,361  18,96   19,953  20,679  22,269  25,977
117 -1,7196 16,3351 0,10435 12,639  13,336  13,794  14,054  14,483  14,793  15,285  16,335  17,608  18,412  19,016  20,02   20,754  22,366  26,142
118 -1,7271 16,3704 0,10478 12,658  13,357  13,816  14,078  14,508  14,82   15,314  16,37   17,652  18,462  19,073  20,087  20,83   22,463  26,306
119 -1,7341 16,4065 0,10522 12,677  13,379  13,84   14,102  14,534  14,847  15,344  16,406  17,697  18,515  19,13   20,155  20,907  22,562  26,474
120 -1,7407 16,4433 0,10566 12,697  13,401  13,863  14,127  14,561  14,875  15,375  16,443  17,743  18,568  19,189  20,225  20,985  22,662  26,644
121 -1,7468 16,4807 0,10609 12,718  13,423  13,888  14,152  14,588  14,904  15,406  16,481  17,79   18,621  19,248  20,294  21,063  22,762  26,814
122 -1,7525 16,5189 0,10652 12,738  13,446  13,913  14,178  14,616  14,933  15,438  16,519  17,837  18,675  19,308  20,365  21,142  22,864  26,985
123 -1,7578 16,5578 0,10695 12,76   13,47   13,938  14,205  14,644  14,963  15,471  16,558  17,886  18,73   19,369  20,436  21,223  22,966  27,158
124 -1,7626 16,5974 0,10738 12,781  13,494  13,964  14,232  14,673  14,994  15,504  16,597  17,935  18,786  19,431  20,509  21,304  23,069  27,332
125 -1,767  16,6376 0,1078  12,803  13,519  13,99   14,259  14,703  15,025  15,538  16,638  17,984  18,843  19,493  20,581  21,385  23,173  27,505
126 -1,771  16,6786 0,10823 12,826  13,544  14,017  14,287  14,733  15,056  15,572  16,679  18,035  18,9    19,556  20,656  21,468  23,278  27,682
127 -1,7745 16,7203 0,10865 12,849  13,569  14,045  14,316  14,764  15,089  15,607  16,72   18,086  18,958  19,62   20,73   21,551  23,383  27,857
128 -1,7777 16,7628 0,10906 12,872  13,596  14,073  14,346  14,796  15,122  15,643  16,763  18,138  19,017  19,685  20,805  21,635  23,488  28,032
129 -1,7804 16,8059 0,10948 12,896  13,622  14,102  14,376  14,828  15,156  15,679  16,806  18,191  19,077  19,75   20,881  21,72   23,595  28,21
130 -1,7828 16,8497 0,10989 12,92   13,649  14,131  14,406  14,86   15,19   15,717  16,85   18,244  19,137  19,816  20,958  21,805  23,702  28,387
131 -1,7847 16,8941 0,1103  12,945  13,677  14,161  14,437  14,893  15,225  15,754  16,894  18,298  19,198  19,883  21,035  21,891  23,81   28,564
132 -1,7862 16,9392 0,1107  12,97   13,705  14,191  14,469  14,927  15,26   15,793  16,939  18,353  19,26   19,95   21,113  21,977  23,917  28,74
133 -1,7873 16,985  0,1111  12,996  13,734  14,222  14,501  14,962  15,296  15,832  16,985  18,408  19,322  20,018  21,191  22,064  24,025  28,916
134 -1,7881 17,0314 0,1115  13,022  13,763  14,253  14,533  14,996  15,333  15,871  17,031  18,464  19,385  20,087  21,27   22,151  24,134  29,093
135 -1,7884 17,0784 0,11189 13,048  13,792  14,285  14,566  15,032  15,37   15,911  17,078  18,521  19,449  20,156  21,35   22,239  24,242  29,267
136 -1,7884 17,1262 0,11228 13,075  13,822  14,317  14,6    15,068  15,408  15,952  17,126  18,578  19,513  20,226  21,43   22,327  24,351  29,442
137 -1,788  17,1746 0,11266 13,102  13,853  14,35   14,634  15,105  15,447  15,993  17,175  18,636  19,578  20,296  21,51   22,416  24,46   29,614
138 -1,7873 17,2236 0,11304 13,13   13,884  14,383  14,669  15,142  15,486  16,035  17,224  18,695  19,643  20,367  21,591  22,505  24,569  29,787
139 -1,7861 17,2734 0,11342 13,157  13,915  14,417  14,704  15,179  15,525  16,078  17,273  18,754  19,71   20,439  21,673  22,595  24,679  29,959
140 -1,7846 17,324  0,11379 13,186  13,947  14,452  14,741  15,218  15,566  16,122  17,324  18,815  19,777  20,512  21,756  22,685  24,789  30,129
141 -1,7828 17,3752 0,11415 13,215  13,98   14,487  14,777  15,257  15,607  16,166  17,375  18,875  19,844  20,585  21,838  22,775  24,898  30,297
142 -1,7806 17,4272 0,11451 13,245  14,013  14,523  14,814  15,297  15,648  16,211  17,427  18,937  19,913  20,658  21,922  22,866  25,008  30,464
143 -1,778  17,4799 0,11487 13,275  14,047  14,559  14,852  15,337  15,691  16,256  17,48   19  19,982  20,733  22,006  22,958  25,118  30,63
144 -1,7751 17,5334 0,11522 13,305  14,081  14,596  14,891  15,378  15,734  16,302  17,533  19,063  20,052  20,808  22,09   23,05   25,228  30,794
145 -1,7719 17,5877 0,11556 13,337  14,116  14,634  14,93   15,42   15,778  16,349  17,588  19,127  20,122  20,884  22,175  23,142  25,338  30,955
146 -1,7684 17,6427 0,1159  13,368  14,152  14,672  14,97   15,463  15,822  16,397  17,643  19,191  20,193  20,96   22,261  23,235  25,448  31,116
147 -1,7645 17,6985 0,11623 13,4    14,188  14,711  15,01   15,506  15,867  16,446  17,698  19,257  20,265  21,037  22,347  23,328  25,558  31,273
148 -1,7604 17,7551 0,11656 13,433  14,225  14,751  15,051  15,55   15,913  16,495  17,755  19,323  20,338  21,115  22,434  23,422  25,668  31,43
149 -1,7559 17,8124 0,11688 13,466  14,262  14,791  15,093  15,594  15,96   16,545  17,812  19,39   20,411  21,194  22,521  23,516  25,778  31,584
150 -1,7511 17,8704 0,1172  13,5    14,3    14,831  15,136  15,64   16,007  16,595  17,87   19,457  20,486  21,273  22,609  23,61   25,888  31,736
151 -1,7461 17,9292 0,11751 13,534  14,338  14,873  15,179  15,685  16,055  16,646  17,929  19,526  20,56   21,352  22,697  23,705  25,998  31,886
152 -1,7408 17,9887 0,11781 13,569  14,377  14,915  15,222  15,732  16,103  16,698  17,989  19,595  20,636  21,433  22,785  23,8    26,107  32,033
153 -1,7352 18,0488 0,11811 13,604  14,417  14,957  15,266  15,779  16,153  16,751  18,049  19,665  20,711  21,513  22,874  23,895  26,216  32,178
154 -1,7293 18,1096 0,11841 13,639  14,457  15  15,311  15,827  16,202  16,804  18,11   19,735  20,788  21,595  22,964  23,991  26,326  32,322
155 -1,7232 18,171  0,11869 13,675  14,497  15,044  15,357  15,875  16,253  16,858  18,171  19,806  20,865  21,676  23,053  24,086  26,434  32,46
156 -1,7168 18,233  0,11898 13,711  14,538  15,087  15,402  15,923  16,303  16,912  18,233  19,877  20,943  21,759  23,144  24,182  26,543  32,6
157 -1,7102 18,2955 0,11925 13,748  14,58   15,132  15,448  15,973  16,355  16,967  18,296  19,949  21,021  21,841  23,234  24,278  26,65   32,733
158 -1,7033 18,3586 0,11952 13,785  14,621  15,177  15,495  16,023  16,407  17,023  18,359  20,022  21,099  21,924  23,324  24,373  26,758  32,865
159 -1,6962 18,4221 0,11979 13,822  14,663  15,222  15,542  16,073  16,459  17,079  18,422  20,095  21,178  22,008  23,415  24,47   26,865  32,996
160 -1,6888 18,486  0,12005 13,86   14,706  15,268  15,59   16,123  16,512  17,135  18,486  20,168  21,257  22,091  23,505  24,565  26,972  33,122
161 -1,6811 18,5502 0,1203  13,897  14,748  15,313  15,637  16,174  16,565  17,192  18,55   20,241  21,336  22,174  23,596  24,66   27,077  33,243
162 -1,6732 18,6148 0,12055 13,935  14,791  15,36   15,685  16,225  16,618  17,248  18,615  20,315  21,416  22,258  23,686  24,755  27,181  33,364
163 -1,6651 18,6795 0,12079 13,973  14,834  15,406  15,733  16,276  16,672  17,306  18,68   20,389  21,495  22,341  23,776  24,85   27,285  33,48
164 -1,6568 18,7445 0,12102 14,011  14,877  15,452  15,782  16,328  16,726  17,363  18,744  20,463  21,574  22,425  23,866  24,944  27,387  33,592
165 -1,6482 18,8095 0,12125 14,049  14,92   15,499  15,83   16,379  16,779  17,42   18,81   20,537  21,654  22,508  23,955  25,037  27,488  33,701
166 -1,6394 18,8746 0,12148 14,087  14,963  15,545  15,879  16,431  16,833  17,478  18,875  20,611  21,733  22,591  24,044  25,131  27,589  33,809
167 -1,6304 18,9398 0,1217  14,125  15,007  15,592  15,927  16,483  16,887  17,535  18,94   20,685  21,812  22,674  24,133  25,223  27,688  33,913
168 -1,6211 19,005  0,12191 14,163  15,05   15,639  15,976  16,534  16,941  17,593  19,005  20,758  21,891  22,757  24,221  25,315  27,786  34,011
169 -1,6116 19,0701 0,12212 14,201  15,093  15,685  16,024  16,586  16,995  17,651  19,07   20,832  21,97   22,839  24,309  25,406  27,882  34,107
170 -1,602  19,1351 0,12233 14,239  15,136  15,731  16,073  16,638  17,049  17,708  19,135  20,906  22,049  22,921  24,396  25,496  27,979  34,202
171 -1,5921 19,2    0,12253 14,276  15,178  15,778  16,121  16,689  17,103  17,766  19,2    20,979  22,127  23,003  24,482  25,586  28,073  34,292
172 -1,5821 19,2648 0,12272 14,314  15,221  15,824  16,169  16,741  17,157  17,823  19,265  21,052  22,204  23,084  24,568  25,674  28,165  34,378
173 -1,5719 19,3294 0,12291 14,351  15,264  15,87   16,217  16,792  17,21   17,88   19,329  21,125  22,282  23,164  24,653  25,762  28,257  34,462
174 -1,5615 19,3937 0,1231  14,387  15,306  15,916  16,265  16,843  17,264  17,937  19,394  21,197  22,359  23,244  24,738  25,849  28,347  34,544
175 -1,551  19,4578 0,12328 14,424  15,348  15,961  16,313  16,894  17,317  17,994  19,458  21,269  22,436  23,324  24,822  25,935  28,436  34,622
176 -1,5403 19,5217 0,12346 14,46   15,39   16,007  16,36   16,944  17,37   18,051  19,522  21,341  22,512  23,403  24,905  26,021  28,524  34,698
177 -1,5294 19,5853 0,12363 14,497  15,432  16,052  16,407  16,995  17,423  18,107  19,585  21,413  22,587  23,482  24,987  26,105  28,609  34,769
178 -1,5185 19,6486 0,1238  14,532  15,473  16,097  16,454  17,045  17,475  18,163  19,649  21,484  22,663  23,56   25,069  26,189  28,695  34,84
179 -1,5074 19,7117 0,12396 14,568  15,514  16,142  16,501  17,095  17,528  18,219  19,712  21,554  22,737  23,637  25,149  26,271  28,778  34,906
180 -1,4961 19,7744 0,12412 14,603  15,555  16,186  16,547  17,145  17,58   18,275  19,774  21,625  22,812  23,714  25,229  26,352  28,86   34,97
181 -1,4848 19,8367 0,12428 14,638  15,595  16,23   16,593  17,194  17,631  18,33   19,837  21,694  22,885  23,79   25,309  26,433  28,941  35,034
182 -1,4733 19,8987 0,12443 14,673  15,636  16,274  16,639  17,243  17,683  18,385  19,899  21,764  22,958  23,865  25,387  26,513  29,021  35,093
183 -1,4617 19,9603 0,12458 14,707  15,676  16,318  16,685  17,292  17,734  18,439  19,96   21,832  23,031  23,94   25,465  26,592  29,099  35,151
184 -1,45   20,0215 0,12473 14,741  15,715  16,361  16,73   17,34   17,784  18,494  20,022  21,901  23,103  24,014  25,542  26,67   29,176  35,208
185 -1,4382 20,0823 0,12487 14,774  15,754  16,404  16,775  17,389  17,835  18,548  20,082  21,969  23,174  24,088  25,618  26,747  29,252  35,261
186 -1,4263 20,1427 0,12501 14,807  15,793  16,446  16,819  17,436  17,885  18,601  20,143  22,036  23,245  24,161  25,693  26,823  29,326  35,313
187 -1,4143 20,2026 0,12514 14,84   15,832  16,488  16,864  17,484  17,935  18,654  20,203  22,103  23,315  24,233  25,767  26,897  29,399  35,36
188 -1,4022 20,2621 0,12528 14,872  15,869  16,53   16,907  17,531  17,984  18,707  20,262  22,169  23,385  24,304  25,841  26,971  29,472  35,41
189 -1,39   20,3211 0,12541 14,904  15,907  16,571  16,95   17,577  18,032  18,759  20,321  22,235  23,453  24,375  25,913  27,044  29,542  35,455
190 -1,3777 20,3796 0,12554 14,935  15,944  16,612  16,993  17,623  18,081  18,811  20,38   22,3    23,522  24,445  25,985  27,116  29,612  35,499
191 -1,3653 20,4376 0,12567 14,966  15,981  16,652  17,035  17,669  18,129  18,862  20,438  22,364  23,589  24,514  26,056  27,188  29,68   35,542
192 -1,3529 20,4951 0,12579 14,997  16,017  16,692  17,078  17,714  18,176  18,913  20,495  22,428  23,656  24,582  26,126  27,258  29,747  35,582
193 -1,3403 20,5521 0,12591 15,027  16,053  16,732  17,119  17,759  18,223  18,964  20,552  22,491  23,722  24,65   26,195  27,326  29,813  35,62
194 -1,3277 20,6085 0,12603 15,056  16,088  16,77   17,16   17,803  18,27   19,014  20,608  22,554  23,787  24,717  26,263  27,395  29,877  35,658
195 -1,3149 20,6644 0,12615 15,085  16,123  16,809  17,2    17,847  18,316  19,063  20,664  22,616  23,852  24,783  26,33   27,462  29,941  35,693
196 -1,3021 20,7197 0,12627 15,113  16,157  16,847  17,24   17,89   18,361  19,112  20,72   22,677  23,916  24,849  26,397  27,528  30,003  35,728
197 -1,2892 20,7745 0,12638 15,141  16,191  16,884  17,28   17,933  18,406  19,161  20,774  22,738  23,979  24,913  26,462  27,593  30,064  35,759
198 -1,2762 20,8287 0,1265  15,168  16,224  16,921  17,319  17,975  18,451  19,208  20,829  22,798  24,042  24,977  26,527  27,657  30,124  35,792
199 -1,2631 20,8824 0,12661 15,195  16,257  16,958  17,357  18,017  18,495  19,256  20,882  22,857  24,104  25,04   26,591  27,72   30,182  35,821
200 -1,2499 20,9355 0,12672 15,221  16,289  16,994  17,395  18,058  18,538  19,303  20,936  22,916  24,165  25,102  26,653  27,782  30,24   35,849
201 -1,2366 20,9881 0,12683 15,247  16,32   17,029  17,433  18,099  18,581  19,349  20,988  22,974  24,226  25,164  26,715  27,844  30,296  35,875
202 -1,2233 21,04   0,12694 15,272  16,351  17,064  17,47   18,139  18,624  19,395  21,04   23,032  24,285  25,225  26,777  27,904  30,351  35,901
203 -1,2098 21,0914 0,12704 15,297  16,382  17,098  17,506  18,179  18,666  19,44   21,091  23,088  24,344  25,284  26,836  27,963  30,405  35,924
204 -1,1962 21,1423 0,12715 15,321  16,412  17,132  17,542  18,218  18,707  19,485  21,142  23,145  24,402  25,344  26,896  28,021  30,458  35,947
205 -1,1826 21,1925 0,12726 15,344  16,442  17,165  17,577  18,256  18,748  19,529  21,192  23,2    24,46   25,402  26,954  28,079  30,51   35,97
206 -1,1688 21,2423 0,12736 15,367  16,471  17,198  17,613  18,295  18,788  19,573  21,242  23,255  24,517  25,46   27,012  28,135  30,56   35,989
207 -1,155  21,2914 0,12746 15,389  16,499  17,231  17,647  18,332  18,828  19,616  21,291  23,309  24,573  25,516  27,068  28,19   30,61   36,007
208 -1,141  21,34   0,12756 15,411  16,527  17,262  17,681  18,369  18,868  19,659  21,34   23,363  24,628  25,572  27,124  28,245  30,658  36,024
209 -1,127  21,388  0,12767 15,432  16,554  17,293  17,714  18,406  18,906  19,701  21,388  23,416  24,683  25,628  27,179  28,299  30,706  36,042
210 -1,1129 21,4354 0,12777 15,452  16,581  17,324  17,747  18,442  18,944  19,742  21,435  23,468  24,737  25,683  27,233  28,352  30,752  36,057
211 -1,0986 21,4822 0,12787 15,472  16,607  17,354  17,779  18,477  18,982  19,783  21,482  23,52   24,79   25,736  27,287  28,403  30,797  36,071
212 -1,0843 21,5285 0,12797 15,491  16,633  17,383  17,81   18,512  19,019  19,823  21,528  23,571  24,843  25,789  27,339  28,454  30,841  36,084
213 -1,0699 21,5742 0,12807 15,51   16,658  17,412  17,841  18,547  19,056  19,863  21,574  23,621  24,895  25,842  27,391  28,504  30,885  36,096
214 -1,0553 21,6193 0,12816 15,528  16,683  17,441  17,872  18,581  19,092  19,903  21,619  23,67   24,946  25,893  27,441  28,552  30,926  36,105
215 -1,0407 21,6638 0,12826 15,546  16,706  17,469  17,902  18,614  19,128  19,942  21,664  23,72   24,996  25,943  27,49   28,6    30,967  36,115
216 -1,026  21,7077 0,12836 15,563  16,73   17,496  17,931  18,647  19,163  19,98   21,708  23,768  25,046  25,993  27,539  28,648  31,007  36,124
217 -1,0112 21,751  0,12845 15,579  16,753  17,523  17,96   18,679  19,197  20,018  21,751  23,815  25,094  26,042  27,587  28,693  31,045  36,13
218 -0,9962 21,7937 0,12855 15,595  16,775  17,549  17,989  18,71   19,231  20,055  21,794  23,862  25,143  26,091  27,634  28,738  31,083  36,136
219 -0,9812 21,8358 0,12864 15,61   16,796  17,575  18,017  18,742  19,264  20,091  21,836  23,909  25,19   26,138  27,68   28,782  31,12   36,14
220 -0,9661 21,8773 0,12874 15,624  16,817  17,6    18,044  18,772  19,297  20,127  21,877  23,954  25,237  26,185  27,726  28,826  31,156  36,145
221 -0,9509 21,9182 0,12883 15,638  16,838  17,624  18,07   18,802  19,329  20,163  21,918  23,999  25,282  26,23   27,77   28,868  31,19   36,148
222 -0,9356 21,9585 0,12893 15,651  16,857  17,648  18,096  18,831  19,361  20,197  21,958  24,043  25,328  26,276  27,814  28,91   31,224  36,151
223 -0,9202 21,9982 0,12902 15,663  16,877  17,671  18,122  18,86   19,392  20,232  21,998  24,087  25,372  26,32   27,857  28,95   31,256  36,151
224 -0,9048 22,0374 0,12911 15,675  16,895  17,694  18,147  18,889  19,422  20,265  22,037  24,13   25,416  26,364  27,898  28,99   31,288  36,151
225 -0,8892 22,076  0,1292  15,687  16,914  17,716  18,171  18,916  19,452  20,299  22,076  24,172  25,459  26,406  27,939  29,028  31,318  36,15
226 -0,8735 22,114  0,1293  15,697  16,931  17,738  18,195  18,943  19,482  20,331  22,114  24,214  25,501  26,449  27,98   29,067  31,349  36,149
227 -0,8578 22,1514 0,12939 15,707  16,948  17,759  18,218  18,97   19,511  20,363  22,151  24,255  25,543  26,49   28,019  29,103  31,378  36,147
228 -0,8419 22,1883 0,12948 15,717  16,964  17,779  18,241  18,996  19,539  20,395  22,188  24,295  25,584  26,531  28,058  29,14   31,405  36,143';


$percentile_arr = explode("\n",str_replace('  ',' ',str_replace('   ',' ',str_replace('    ',' ',str_replace('     ',' ',str_replace(',','.',$percentile_arr))))));
echo "<script>var percentile_arr = [";
foreach( $percentile_arr as $arr ){
    $help = explode(" ",$arr);
    echo "[".esc_attr($help[7]).",";
    echo esc_attr($help[13]).",";
    echo esc_attr($help[15])."],\n";
}
echo "];";

$percentile_arr2 = explode("\n",str_replace('  ',' ',str_replace('   ',' ',str_replace('    ',' ',str_replace('     ',' ',str_replace(',','.',$percentile_arr2))))));
echo "var percentile_arr2 = [";
foreach( $percentile_arr2 as $arr ){
    $help = explode(" ",$arr);
    echo "[".esc_attr($help[7]).",";
    echo esc_attr($help[13]).",";
    echo esc_attr($help[15])."],\n";
}
echo "];";


echo "var percentile_arr22 = [";
foreach( $percentile_arr2 as $arr ){
    $help = explode(" ",$arr);
    echo "[";
    foreach( $help as $arr2 ){
        echo esc_attr($arr2).",";
    }
    echo "],";
}
echo "];";

echo "var percentile_arr11 = [";
foreach( $percentile_arr as $arr ){
    $help = explode(" ",$arr);
    echo "[";
    foreach( $help as $arr2 ){
        echo esc_attr($arr2).",";
    }
    echo "],";
}
echo "];";

echo "</script>";
    ?>
<style>
          #calc_wrapper{
          	--family-calc-vis:<?php echo get_option('Font_family_calc_visual');?>;
            --title-color:<?php echo get_option('Font_color1_calc_visual');?>;
            --values-color:<?php echo get_option('Font_color3_calc_visual');?>;
            --text-color:<?php echo get_option('Font_color2_calc_visual');?>;
          }


          .toggle-switch {
  display: inline-block;
  position: relative;
  width: 30px;
  height: 17px;
  margin-left:15px;
  margin-top: 4px;
}

.toggle-switch input {
  display: none;
}

.toggle-switch-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  border-radius: 17px;
  transition: 0.4s;
}

.toggle-switch-slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  border-radius: 50%;
  transition: 0.4s;
}

input:checked + .toggle-switch-slider {
  background-color: #4f94d4;
}

input:checked + .toggle-switch-slider:before {
  transform: translateX(13px);
}

<?php if($units == 'metric'){
    ?>
.imperial_inputs{
    display:none;
}
    <?php
}else{
    ?>
.metric_inputs{
    display:none;
}
    <?php
}
?>


		</style>
        <div class="calc_wrapper" id="calc_wrapper">
            <div class="calc_header">
                <div class="calc_header_left">
                    <div class="calc_header_title">
                        <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Title"));?>
                    </div>
                    <div class="calc_header_desc">
                        <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."TitleDesc"));?>
                    </div>
                </div>
                <div class="calc_header_right">
                    <img src="<?php echo plugins_url('images/bmiberegner.png',__FILE__);?>">
                </div>
            </div>
            <div class="custom_flex_calc_wrapper">
                <div class="calc_data">




                    <?php if($units_cap == "both"){
                        ?>
                        <style>
                            .button-group {
                                display: flex;
								width:100%
                            }

                            input[type="radio"][name="<?php echo esc_attr($id_calc);?>units_checkbox"] {
                                display: none;
                            }

                            .radio-label {
                                padding: 5px 10px;
                                margin: 0;
                                color: black;
                                background-color: #cccccc;
                                cursor: pointer;
                                transition: all 0.3s ease;
                            }

                            input[type="radio"]:checked + .radio-label {
                                color: white;
                                background-color: #4f94d4;
                            }
                            label[for="metric"]{
                                border-radius:5px 0 0  5px ;
                            }
                            label[for="imperial"]{
                                border-radius:0 5px 5px  0;
                            }
                        </style>
                        <div class="button-group" style="margin-bottom:16px;align-items: center;">
                            <span class="switcher_color" style="width:100%">
                            <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Units"));?>
                            </span>

                            <input type="radio" id="metric" name="<?php echo esc_attr($id_calc);?>units_checkbox" value="metric" checked>
                            <label for="metric" class="radio-label">Metric</label>

                            <input type="radio" id="imperial" name="<?php echo esc_attr($id_calc);?>units_checkbox" value="imperial">
                            <label for="imperial" class="radio-label">Imperial</label>
                        </div>
                        <?php

                    }else{
                        ?>
                        <style>
                            .button-group {
                                display: flex;
								width:100%
                            }

                            input[type="radio"][name="<?php echo esc_attr($id_calc);?>units_checkbox"] {
                                display: none;
                            }

                            .radio-label {
                                padding: 5px 10px;
                                margin: 0;
                                color: black;
                                background-color: #cccccc;
                                cursor: pointer;
                                transition: all 0.3s ease;
                            }

                            input[type="radio"]:checked + .radio-label {
                                color: white;
                                background-color: #4f94d4;
                            }
                            label[for="metric"]{
                                border-radius:5px 0 0  5px ;
                            }
                            label[for="imperial"]{
                                border-radius:0 5px 5px  0;
                            }
                        </style>
                        <div class="button-group" style="margin-bottom:16px;align-items: center;display:none">
                            <span class="switcher_color" style="width:100%">
                            <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Units"));?>
                            </span>

                            <input type="radio" id="metric" name="<?php echo esc_attr($id_calc);?>units_checkbox" value="metric" checked>
                            <label for="metric" class="radio-label">Metric</label>

                            <input type="radio" id="imperial" name="<?php echo esc_attr($id_calc);?>units_checkbox" value="imperial">
                            <label for="imperial" class="radio-label">Imperial</label>
                        </div>

                        <?php
                    }?>

                    <div class="calc_data_sex" style="margin-bottom:35px">
                        <span for="calc_sex_input">
                            <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Gender"));?>
                        </span>
                        <div class="custom_flex_wrapper">
                            <input id="<?php echo esc_attr($id_calc);?>calc_sex_boy_input" value="true" class="" type="radio" name="calc_sex<?php echo esc_attr($id_calc);?>" placeholder="" checked>
                            <label for="<?php echo esc_attr($id_calc);?>calc_sex_boy_input"><?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?></label>
                            <input id="<?php echo esc_attr($id_calc);?>calc_sex_girl_input" value="false" class="" type="radio" name="calc_sex<?php echo esc_attr($id_calc);?>" placeholder="">
                            <label for="<?php echo esc_attr($id_calc);?>calc_sex_girl_input"><?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Girl"));?></label>
                        </div>

                    </div>
                    <div class="calc_data_age">
                        <span for="calc_age_input">
                            <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Age"));?>
                        </span>
                        <div class="custom_flex_wrapper">
                            <input id="<?php echo esc_attr($id_calc);?>calc_age_years_input" style="width:45%" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Age"));?>">
                            <input id="<?php echo esc_attr($id_calc);?>calc_age_month_input" style="width:45%" class="calc_input_custom" type="text" placeholder="">
                            <div class="calc_placeholder year">
                                <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Year"));?>
                            </div>
                            <div class="calc_placeholder">
                                <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Month"));?>
                            </div>
                        </div>

                    </div>
                    <div for="<?php echo esc_attr($id_calc);?>calc_age_years_input" class="alert-mess">
                        <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."AgeReg"));?>
                    </div>





















                        <div class="metric_inputs">
                            <div class="calc_data_height">
                                <span for="calc_height_input">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Height"));?>
                                </span>
                                <input id="<?php echo esc_attr($id_calc);?>calc_height_input" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."YourHeight"));?>">
                                <div class="calc_placeholder">
                                    <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Cm"));?>
                                </div>
                            </div>
                            <div for="<?php echo esc_attr($id_calc);?>calc_height_input" class="alert-mess">
                                <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."HeightReg"));?>
                            </div>
                            <div class="calc_data_weight">
                                <span for="calc_weight_input">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Weight"));?>
                                </span>
                                <input id="<?php echo esc_attr($id_calc);?>calc_weight_input"  class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."YourWeight"));?>">
                                <div class="calc_placeholder">
                                    <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Kg"));?>
                                </div>
                            </div>
                            <div for="<?php echo esc_attr($id_calc);?>calc_weight_input" class="alert-mess">
                                <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."WeightReg"));?>
                            </div>

                        </div>


                        <div class="imperial_inputs">
                            <div class="calc_data_height">
                                <span for="calc_height_input">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Height"));?>
                                </span>
                                <div class="custom_flex_wrapper">
                                    <input id="<?php echo esc_attr($id_calc);?>calc_height_input_ft" style="width:45%" class="calc_input_custom" type="text" placeholder="">
                                    <input id="<?php echo esc_attr($id_calc);?>calc_height_input_in" style="width:45%" class="calc_input_custom" type="text" placeholder="">
                                    <div class="calc_placeholder year">
                                        <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Ft"));?>
                                    </div>
                                    <div class="calc_placeholder">
                                        <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."In"));?>
                                    </div>
                                </div>
                            </div>
                            <div for="<?php echo esc_attr($id_calc);?>calc_height_input_ft" class="alert-mess">
                                <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."HeightRegFt"));?>
                            </div>
                            <div class="calc_data_weight">
                                <span for="calc_weight_input">
                                    <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Weight"));?>
                                </span>
                                <div class="custom_flex_wrapper">
                                    <input id="<?php echo esc_attr($id_calc);?>calc_weight_input_lb" style="width:45%" class="calc_input_custom" type="text" placeholder="">
                                    <input id="<?php echo esc_attr($id_calc);?>calc_weight_input_st" style="width:45%" class="calc_input_custom" type="text" placeholder="">
                                    <div class="calc_placeholder year">
                                        <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Lb"));?>
                                    </div>
                                    <div class="calc_placeholder">
                                        <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."St"));?>
                                    </div>
                                </div>
                            </div>
                            <div for="<?php echo esc_attr($id_calc);?>calc_weight_input_lb" class="alert-mess">
                                <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."WeightRegLb"));?>
                            </div>
                        </div>





















                    <div class="calc_input_button" id="<?php echo esc_attr($id_calc);?>calc_input_button">
                        <?php echo esc_attr(get_option("lang_bmi_calc".$lang."Calculate"));?> <img  style="width:9px;height:12px" src="<?php echo plugins_url('images/Arrow.png',__FILE__);?>" >
                    </div>







                </div>
                <div class="calc_info">
                    <div class="calc_info_placeholder <?php echo esc_attr($id_calc);?>">
                        <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Placeholder"));?>
                    </div>
                    <div class="calc_info_data <?php echo esc_attr($id_calc);?>" style="display:none">
                        <div class="calc_info_data_title">
                            <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."BMI"));?>
                        </div>
                        <div style="margin-bottom: 40px" class="calc_info_data_value" id="<?php echo esc_attr($id_calc);?>calc_bmi">
                        </div>
                        <div class="calc_info_data_title" id="child_full_data1">
                            <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Category1"));?>
                        </div>



                        <div class="img_calc_kid_wrapper <?php echo esc_attr($id_calc);?>" style="margin-top: 80px;margin-bottom: 20px;">
                            <div style="display: none" class="kid_bmi_identifier <?php echo esc_attr($id_calc);?>"></div>
                            <div class="calc_info_line_result_wrapper_per">
                                <div class="calc_info_line_result">

                                </div>
                            </div>
                            <div class="calc_info_line_underweight" style="text-align: left;width:5%;white-space: nowrap;">
                                1
                            </div>
                            <div class="calc_info_line_healthy" style="width:80%">
                            </div>
                            <div class="calc_info_line_overweight" style="width:10%">
                            </div>
                            <div  class="calc_info_line_obese" style="width:5%;text-align: right;    white-space: nowrap;">
                                99
                            </div>

                        </div>
                      	<div class="calc_info_data_title" id="child_full_data2">
                            <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Category2"));?>
                        </div>



                        <div class="calc_info_data_title" id="child_full_data3">
                            <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Category3"));?>
                        </div>



                        <div class="calc_info_data_title" id="child_full_data3_imperial" style="display:none">
                            <?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Category3Lb"));?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        (function( $ ) {


            var units = '<?php echo esc_attr($units);?>';

            $('input[name="<?php echo esc_attr($id_calc);?>units_checkbox"]').on('change',function(){
                if ($(this).val() == 'imperial')
                {
                    $('.imperial_inputs').css('display','block');
                    $('.metric_inputs').css('display','none');
                    $('#child_full_data3_imperial').css('display','block');
                    $('#child_full_data3').css('display','none');
                    units = 'imperial';
                }else{
                    $('.imperial_inputs').css('display','none');
                    $('.metric_inputs').css('display','block');
                    $('#child_full_data3_imperial').css('display','none');
                    $('#child_full_data3').css('display','block');
                    units = 'metric';
                }
            })

            function check_imperial_kid(can){
                var feets = $('#<?php echo esc_attr($id_calc);?>calc_height_input_ft').val();
                var inches = $('#<?php echo esc_attr($id_calc);?>calc_height_input_in').val();
                if(isNaN(parseFloat(feets))){
                    feets = 0;
                }
                if(isNaN(parseFloat(inches))){
                    inches = 0;
                }
                var height_imp = ((parseFloat(feets) + parseFloat(inches) / 12) * 30.48).toFixed(0);

                if(height_imp < 40 || height_imp > 225 ){
                    $('.alert-mess[for="<?php echo esc_attr($id_calc);?>calc_height_input_ft"]').css('opacity','1');
                    $('#<?php echo esc_attr($id_calc);?>calc_height_input_ft').addClass('alert');
                    $('#<?php echo esc_attr($id_calc);?>calc_height_input_in').addClass('alert');
                    can = false;
                }else{
                    $('.alert-mess[for="<?php echo esc_attr($id_calc);?>calc_height_input_ft"]').css('opacity','0');
                    $('#<?php echo esc_attr($id_calc);?>calc_height_input_ft').removeClass('alert');
                    $('#<?php echo esc_attr($id_calc);?>calc_height_input_in').removeClass('alert');
                }

                <?php echo esc_attr($id_calc);?>height = height_imp;


                var pounds = $('#<?php echo esc_attr($id_calc);?>calc_weight_input_lb').val();
                var stones = $('#<?php echo esc_attr($id_calc);?>calc_weight_input_st').val();
                if(isNaN(parseFloat(pounds))){
                    pounds = 0;
                }
                if(isNaN(parseFloat(stones))){
                    stones = 0;
                    console.log('alo')
                }
                var weight_imp = ((parseFloat(pounds) + parseFloat(stones) / 14) / 2.20462 ).toFixed(0);

                if(weight_imp < 1 || weight_imp > 500){
                    $('.alert-mess[for="<?php echo esc_attr($id_calc);?>calc_weight_input_lb"]').css('opacity','1');
                    $('#<?php echo esc_attr($id_calc);?>calc_weight_input_lb').addClass('alert');
                    $('#<?php echo esc_attr($id_calc);?>calc_weight_input_st').addClass('alert');
                    can = false;
                }else{
                    $('.alert-mess[for="<?php echo esc_attr($id_calc);?>calc_weight_input_lb"]').css('opacity','0');
                    $('#<?php echo esc_attr($id_calc);?>calc_weight_input_lb').removeClass('alert');
                    $('#<?php echo esc_attr($id_calc);?>calc_weight_input_st').removeClass('alert');
                }
                console.log(parseFloat(stones))
                <?php echo esc_attr($id_calc);?>weight = weight_imp;
                return can;
            }

            var default_html1 = $('#child_full_data1').html();
          	var default_html2 = $('#child_full_data2').html();
          	var default_html3 = $('#child_full_data3').html();
            var default_html3_imperial = $('#child_full_data3_imperial').html();
            var units = '<?php echo esc_attr($units);?>';
            function moveRect<?php echo esc_attr($id_calc);?>(e){
                switch(e.key){

                    case "Enter":  // если нажата клавиша влево
                        var can = true;
                        if(units == 'metric'){
                            $('#<?php echo esc_attr($id_calc);?>calc_height_input').each(function(){




                                    if(parseInt($(this).val()) < 40 || parseInt($(this).val()) > 225 || !Number.isInteger(parseInt($(this).val())) || $(this).val()[0]=='0'){
                                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                        $(this).addClass('alert');
                                        can = false;
                                    }else{
                                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                        $(this).removeClass('alert');
                                        <?php echo esc_attr($id_calc);?>height = $(this).val();
                                    }




                            })
                            $('#<?php echo esc_attr($id_calc);?>calc_age_years_input').on('input',function(){

                                if(/^[\d]*$/.test($(this).val())){
                                    <?php echo esc_attr($id_calc);?>year = $(this).val();
                                }else{
                                    $(this).val(<?php echo esc_attr($id_calc);?>year);
                                }
                                if($(this).val()==null || parseInt($(this).val()) < 0 || parseInt($(this).val()) > 18 || !Number.isInteger(parseInt($(this).val())) ){
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                    $(this).addClass('alert');
                                    can = false;
                                }else{
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                    $(this).removeClass('alert');
                                }
                            })
                            $('#<?php echo esc_attr($id_calc);?>calc_age_month_input').on('input',function(){

                                if(/^[\d]*$/.test($(this).val())){
                                    <?php echo esc_attr($id_calc);?>month = $(this).val();
                                }else{
                                    $(this).val(<?php echo esc_attr($id_calc);?>month);
                                }
                                if(parseInt($(this).val()) < 0 || parseInt($(this).val()) > 12 || !Number.isInteger(parseInt($(this).val())) ){
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                    $(this).addClass('alert');
                                    can = false;
                                }else{
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                    $(this).removeClass('alert');
                                }
                            })
                            $('#<?php echo esc_attr($id_calc);?>calc_weight_input').each(function(){


                                    if(parseFloat($(this).val()) < 10 || parseFloat($(this).val()) > 500 || fweight(parseFloat($(this).val())) > 1 || parseFloat($(this).val())!=$(this).val() || $(this).val()[0]=='0'){
                                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                        $(this).addClass('alert');
                                        can = false;
                                    }else{
                                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                        $(this).removeClass('alert');
                                        <?php echo esc_attr($id_calc);?>weight = $(this).val();
                                    }

                            })
                            //console.log(can);
                            if(can){
                                <?php if($redirect==1){
                                    ?>
                                    document.location.href = "<?php echo esc_url($redirect_link); ?>?redirect=1&height="+<?php echo esc_attr($id_calc);?>height+"&weight="+<?php echo esc_attr($id_calc);?>weight+"&month="+$('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()+"&age="+$('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()+"&gender="+$('input[name="calc_sex<?php echo esc_attr($id_calc);?>"]:checked').val()+"&units="+units+"&ft="+$('#<?php echo esc_attr($id_calc);?>calc_height_input_ft').val()+"&in="+$('#<?php echo esc_attr($id_calc);?>calc_height_input_in').val()+"&lb="+$('#<?php echo esc_attr($id_calc);?>calc_weight_input_lb').val()+"&st="+$('#<?php echo esc_attr($id_calc);?>calc_weight_input_st').val()+"#calc_wrapper";
                                    <?php

                                }else{
                                    ?>
                                if(<?php echo esc_attr($id_calc);?>month == '' || <?php echo esc_attr($id_calc);?>month == undefined || <?php echo esc_attr($id_calc);?>month == NaN){
                                    <?php echo esc_attr($id_calc);?>month = 0;
                                    $('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val(0);
                                }
                                $('#<?php echo esc_attr($id_calc);?>calc_input_button').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Recalculate"));?> <img src="<?php echo plugins_url('images/Vector Smart Object.png',__FILE__);?>" >');
                                $('#<?php echo esc_attr($id_calc);?>calc_input_button').addClass('re');
                                var bmi = (parseFloat(<?php echo esc_attr($id_calc);?>weight)/(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                                $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                $('#<?php echo esc_attr($id_calc);?>calc_bmi').html(bmi);

                                $('.img_calc_kid_wrapper.<?php echo esc_attr($id_calc);?> img').css('display','none');



                                $("#percentiles_graf_kid").css('display','block')
                                if($('input[name=calc_sex<?php echo esc_attr($id_calc);?>]:checked').val()=='true'){
                                    var cat_bmi = '';
                                    if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][0]){
                                        cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>';
                                    }else{
                                        if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][1]){
                                            cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>'
                                        }else{
                                            if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][2]){
                                                cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>'
                                            }else{
                                                cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>'
                                            }
                                        }
                                    }


                                    var percentile = 0;
                                    var per_min = 99999;
                                    var per_arr = [0,0,0,0,0,1,3,5,10,15,25,50,75,85,90,95,97,99];

                                        var min_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                                        var max_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);

                                    for(var i = 5;i<18;i++){
                                        if(Math.abs(percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi)<per_min){
                                            percentile = per_arr[i];
                                            console.log('per - '+percentile);
                                            per_min = Math.abs(percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi);
                                        }
                                    }
                                    //console.log('per - '+percentile);
                                    var help_html = default_html1;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data1').html(help_html)
                                    help_html = default_html2;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data2').html(help_html)
                                    help_html = default_html3;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data3').html(help_html)

                                    $('.calc_info_line_result_wrapper_per').css('left','calc('+percentile+'% - 10px )')
                                }else{

                                    var cat_bmi = '';
                                    if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][0]){
                                        cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>'
                                    }else{
                                        if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][1]){
                                            cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>'
                                        }else{
                                            if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][2]){
                                                cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>'
                                            }else{
                                                cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>'
                                            }
                                        }
                                    }
                                    var percentile = 0;
                                    var per_min = 99999;
                                    var per_arr = [0,0,0,0,0,1,3,5,10,15,25,50,75,85,90,95,97,99];


                                    if(units == 'metric'){
                                        var min_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                                        var max_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                                    }else{
                                        var min_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                                        var max_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                                    }

                                    for(var i = 5;i<18;i++){
                                        if(Math.abs(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi)<per_min){
                                            percentile = per_arr[i];
                                            per_min = Math.abs(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi);
                                            console.log('per - '+percentile);
                                        }
                                        console.log(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]);
                                        console.log(bmi);

                                    }
                                    console.log('per - '+percentile);
                                    $('#<?php echo esc_attr($id_calc);?>calc_conclusion_per').html(percentile+'th')
                                    $('.calc_info_line_result_wrapper_per').css('left','calc('+percentile+'% - 10px )')


                                    var help_html = default_html1;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data1').html(help_html)
                                    help_html = default_html2;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data2').html(help_html)
                                    help_html = default_html3;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data3').html(help_html)


                                }


                                <?php } ?>

                            }
                        }else{

                            $('#<?php echo esc_attr($id_calc);?>calc_age_years_input').on('input',function(){

                                if(/^[\d]*$/.test($(this).val())){
                                    <?php echo esc_attr($id_calc);?>year = $(this).val();
                                }else{
                                    $(this).val(<?php echo esc_attr($id_calc);?>year);
                                }
                                if($(this).val()==null || parseInt($(this).val()) < 0 || parseInt($(this).val()) > 18 || !Number.isInteger(parseInt($(this).val())) ){
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                    $(this).addClass('alert');
                                    can = false;
                                }else{
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                    $(this).removeClass('alert');
                                }
                            })
                            $('#<?php echo esc_attr($id_calc);?>calc_age_month_input').on('input',function(){

                                if(/^[\d]*$/.test($(this).val())){
                                    <?php echo esc_attr($id_calc);?>month = $(this).val();
                                }else{
                                    $(this).val(<?php echo esc_attr($id_calc);?>month);
                                }
                                if(parseInt($(this).val()) < 0 || parseInt($(this).val()) > 12 || !Number.isInteger(parseInt($(this).val())) ){
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                    $(this).addClass('alert');
                                    can = false;
                                }else{
                                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                    $(this).removeClass('alert');
                                }
                            })
                            if(can){
                                can = check_imperial_kid(true);
                            }
                            //console.log(can);
                            if(can){
                                <?php if($redirect==1){
                                    ?>
                                    document.location.href = "<?php echo esc_url($redirect_link); ?>?redirect=1&height="+<?php echo esc_attr($id_calc);?>height+"&weight="+<?php echo esc_attr($id_calc);?>weight+"&month="+$('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()+"&age="+$('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()+"&gender="+$('input[name="calc_sex<?php echo esc_attr($id_calc);?>"]:checked').val()+"&units="+units+"&ft="+$('#<?php echo esc_attr($id_calc);?>calc_height_input_ft').val()+"&in="+$('#<?php echo esc_attr($id_calc);?>calc_height_input_in').val()+"&lb="+$('#<?php echo esc_attr($id_calc);?>calc_weight_input_lb').val()+"&st="+$('#<?php echo esc_attr($id_calc);?>calc_weight_input_st').val()+"#calc_wrapper";
                                    <?php

                                }else{
                                    ?>
                                if(<?php echo esc_attr($id_calc);?>month == '' || <?php echo esc_attr($id_calc);?>month == undefined || <?php echo esc_attr($id_calc);?>month == NaN){
                                    <?php echo esc_attr($id_calc);?>month = 0;
                                    $('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val(0);
                                }
                                $('#<?php echo esc_attr($id_calc);?>calc_input_button').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Recalculate"));?> <img src="<?php echo plugins_url('images/Vector Smart Object.png',__FILE__);?>" >');
                                $('#<?php echo esc_attr($id_calc);?>calc_input_button').addClass('re');
                                var bmi = (parseFloat(<?php echo esc_attr($id_calc);?>weight)/(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                                $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                                $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                                $('#<?php echo esc_attr($id_calc);?>calc_bmi').html(bmi);

                                $('.img_calc_kid_wrapper.<?php echo esc_attr($id_calc);?> img').css('display','none');



                                $("#percentiles_graf_kid").css('display','block')
                                if($('input[name=calc_sex<?php echo esc_attr($id_calc);?>]:checked').val()=='true'){
                                    var cat_bmi = '';
                                    if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][0]){
                                        cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>';
                                    }else{
                                        if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][1]){
                                            cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>'
                                        }else{
                                            if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][2]){
                                                cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>'
                                            }else{
                                                cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>'
                                            }
                                        }
                                    }


                                    var percentile = 0;
                                    var per_min = 99999;
                                    var per_arr = [0,0,0,0,0,1,3,5,10,15,25,50,75,85,90,95,97,99];

                                        var min_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                                        var max_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);

                                    for(var i = 5;i<18;i++){
                                        if(Math.abs(percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi)<per_min){
                                            percentile = per_arr[i];
                                            console.log('per - '+percentile);
                                            per_min = Math.abs(percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi);
                                        }
                                    }
                                    //console.log('per - '+percentile);
                                    var help_html = default_html1;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data1').html(help_html)
                                    help_html = default_html2;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data2').html(help_html)
                                    help_html = default_html3_imperial;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data3_imperial').html(help_html)

                                    $('.calc_info_line_result_wrapper_per').css('left','calc('+percentile+'% - 10px )')
                                }else{

                                    var cat_bmi = '';
                                    if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][0]){
                                        cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>'
                                    }else{
                                        if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][1]){
                                            cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>'
                                        }else{
                                            if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][2]){
                                                cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>'
                                            }else{
                                                cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>'
                                            }
                                        }
                                    }
                                    var percentile = 0;
                                    var per_min = 99999;
                                    var per_arr = [0,0,0,0,0,1,3,5,10,15,25,50,75,85,90,95,97,99];


                                    if(units == 'metric'){
                                        var min_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                                        var max_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                                    }else{
                                        var min_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                                        var max_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                                    }

                                    for(var i = 5;i<18;i++){
                                        if(Math.abs(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi)<per_min){
                                            percentile = per_arr[i];
                                            per_min = Math.abs(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi);
                                            console.log('per - '+percentile);
                                        }
                                        console.log(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]);
                                        console.log(bmi);

                                    }
                                    console.log('per - '+percentile);
                                    $('#<?php echo esc_attr($id_calc);?>calc_conclusion_per').html(percentile+'th')
                                    $('.calc_info_line_result_wrapper_per').css('left','calc('+percentile+'% - 10px )')


                                    var help_html = default_html1;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data1').html(help_html)
                                    help_html = default_html2;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data2').html(help_html)
                                    help_html = default_html3_imperial;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#default_html3_imperial').html(help_html)


                                }


                                <?php } ?>

                            }
                        }
                        break;
                }
            }

            addEventListener("keydown", moveRect<?php echo esc_attr($id_calc);?>);
            const fweight = x => ( (x.toString().includes('.')) ? (x.toString().split('.').pop().length) : (0) );
            var <?php echo esc_attr($id_calc);?>height = '';
            var <?php echo esc_attr($id_calc);?>weight = '';
            var <?php echo esc_attr($id_calc);?>year = '';
            var <?php echo esc_attr($id_calc);?>month = '';
            var <?php echo esc_attr($id_calc);?>checkingRegExp = new RegExp(/^(\d)$/g);








            var <?php echo esc_attr($id_calc);?>prev1 = 0;
            var <?php echo esc_attr($id_calc);?>prev2 = 0;
            var <?php echo esc_attr($id_calc);?>prev3 = 0;
            var <?php echo esc_attr($id_calc);?>prev4 = 0;

            $('#<?php echo esc_attr($id_calc);?>calc_height_input_ft').on('input',function(){
                if(/^[\d.]*$/.test($(this).val())){
                    <?php echo esc_attr($id_calc);?>prev1 = $(this).val();
                }else{
                    $(this).val(<?php echo esc_attr($id_calc);?>prev1);
                }
                var can = check_imperial_kid(true);
            })
            $('#<?php echo esc_attr($id_calc);?>calc_height_input_in').on('input',function(){
                if(/^[\d.]*$/.test($(this).val())){
                    <?php echo esc_attr($id_calc);?>prev2 = $(this).val();
                }else{
                    $(this).val(<?php echo esc_attr($id_calc);?>prev2);
                }
                var can = check_imperial_kid(true);
            })
            $('#<?php echo esc_attr($id_calc);?>calc_weight_input_lb').on('input',function(){
                if(/^[\d.]*$/.test($(this).val())){
                    <?php echo esc_attr($id_calc);?>prev3 = $(this).val();
                }else{
                    $(this).val(<?php echo esc_attr($id_calc);?>prev3);
                }
                var can = check_imperial_kid(true);
            })
            $('#<?php echo esc_attr($id_calc);?>calc_weight_input_st').on('input',function(){
                if(/^[\d.]*$/.test($(this).val())){
                    <?php echo esc_attr($id_calc);?>prev4 = $(this).val();
                }else{
                    $(this).val(<?php echo esc_attr($id_calc);?>prev4);
                }
                var can = check_imperial_kid(true);
            })







            $('#<?php echo esc_attr($id_calc);?>calc_height_input').on('input',function(){

                if(/^[\d.]*$/.test($(this).val())  && $(this).val().split(".").length < 3){

                    <?php echo esc_attr($id_calc);?>height = $(this).val();



                }else{
                    $(this).val(<?php echo esc_attr($id_calc);?>height  );
                }


                    if(parseInt($(this).val()) < 40 || parseInt($(this).val()) > 225 || !Number.isInteger(parseInt($(this).val())) || $(this).val()[0]=='0'){
                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                        $(this).addClass('alert');
                    }else{
                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                        $(this).removeClass('alert');
                    }





            })


            $('#<?php echo esc_attr($id_calc);?>calc_age_years_input').on('input',function(){

                if(/^[\d]*$/.test($(this).val())){
                    <?php echo esc_attr($id_calc);?>year = $(this).val();
                }else{
                    $(this).val(<?php echo esc_attr($id_calc);?>year);
                }
                if(parseInt($(this).val()) < 0 || parseInt($(this).val()) > 18 || !Number.isInteger(parseInt($(this).val()))){
                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                    $(this).addClass('alert');
                }else{
                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                    $(this).removeClass('alert');
                }
            })
            $('#<?php echo esc_attr($id_calc);?>calc_age_month_input').on('input',function(){

                if(/^[\d]*$/.test($(this).val())){
                    <?php echo esc_attr($id_calc);?>month = $(this).val();
                }else{
                    $(this).val(<?php echo esc_attr($id_calc);?>month);
                }
                if(parseInt($(this).val()) < 0 || parseInt($(this).val()) > 12 || !Number.isInteger(parseInt($(this).val())) ){
                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                    $(this).addClass('alert');
                }else{
                    $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                    $(this).removeClass('alert');
                }
            })


            $('#<?php echo esc_attr($id_calc);?>calc_weight_input').on('input',function(){
                if(/^[\d.]*$/.test($(this).val()) && $(this).val().split(".").length < 3 ){
                    <?php echo esc_attr($id_calc);?>weight = $(this).val();

                        <?php echo esc_attr($id_calc);?>weight = <?php echo esc_attr($id_calc);?>weight / 2.20462;

                }else{
                    $(this).val(<?php echo esc_attr($id_calc);?>weight  );
                }


                    if(parseFloat($(this).val()) < 1 || parseFloat($(this).val()) > 250 || fweight(parseFloat($(this).val())) > 1 || parseFloat($(this).val())!=$(this).val() || $(this).val()[0]=='0'){
                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                        $(this).addClass('alert');
                        can = false;
                    }else{
                        $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                        $(this).removeClass('alert');

                    }




            })
            $('#<?php echo esc_attr($id_calc);?>calc_input_button').on('click',function(){
                var can = true;




                if(units == 'metric'){
                    $('#<?php echo esc_attr($id_calc);?>calc_height_input').each(function(){


                            if(parseInt($(this).val()) < 40 || parseInt($(this).val()) > 225 || !Number.isInteger(parseInt($(this).val())) || $(this).val()[0]=='0'){
                                $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                $(this).addClass('alert');
                                can = false;
                            }else{
                                $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                $(this).removeClass('alert');
                                <?php echo esc_attr($id_calc);?>height = $(this).val()
                            }

                    })
                    $('#<?php echo esc_attr($id_calc);?>calc_age_years_input').on('input',function(){

                        if(/^[\d]*$/.test($(this).val())){
                            <?php echo esc_attr($id_calc);?>year = $(this).val();
                        }else{
                            $(this).val(<?php echo esc_attr($id_calc);?>year);
                        }
                        if($(this).val()==null || parseInt($(this).val()) < 0 || parseInt($(this).val()) > 18 || !Number.isInteger(parseInt($(this).val())) ){
                            $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                            $(this).addClass('alert');
                            can = false;
                        }else{
                            $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                            $(this).removeClass('alert');
                        }
                    })
                    $('#<?php echo esc_attr($id_calc);?>calc_age_month_input').on('input',function(){

                        if(/^[\d]*$/.test($(this).val())){
                            <?php echo esc_attr($id_calc);?>month = $(this).val();
                        }else{
                            $(this).val(<?php echo esc_attr($id_calc);?>month);
                        }
                        if(parseInt($(this).val()) < 0 || parseInt($(this).val()) > 12 || !Number.isInteger(parseInt($(this).val())) ){
                            $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                            $(this).addClass('alert');
                            can = false;
                        }else{
                            $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                            $(this).removeClass('alert');
                        }
                    })
                    $('#<?php echo esc_attr($id_calc);?>calc_weight_input').each(function(){


                            if(parseFloat($(this).val()) < 1 || parseFloat($(this).val()) > 250 || fweight(parseFloat($(this).val())) > 1 || parseFloat($(this).val())!=$(this).val() || $(this).val()[0]=='0'){
                                $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                                $(this).addClass('alert');
                                can = false;
                            }else{
                                $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                                $(this).removeClass('alert');
                                <?php echo esc_attr($id_calc);?>weight = $(this).val();
                            }

                    })
                    //console.log(can);
                    if(can){
                        <?php if($redirect==1){
                            ?>
                            document.location.href = "<?php echo esc_url($redirect_link); ?>?redirect=1&height="+<?php echo esc_attr($id_calc);?>height+"&weight="+<?php echo esc_attr($id_calc);?>weight+"&month="+$('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()+"&age="+$('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()+"&gender="+$('input[name="calc_sex<?php echo esc_attr($id_calc);?>"]:checked').val()+"&units="+units+"&ft="+$('#<?php echo esc_attr($id_calc);?>calc_height_input_ft').val()+"&in="+$('#<?php echo esc_attr($id_calc);?>calc_height_input_in').val()+"&lb="+$('#<?php echo esc_attr($id_calc);?>calc_weight_input_lb').val()+"&st="+$('#<?php echo esc_attr($id_calc);?>calc_weight_input_st').val()+"#calc_wrapper";
                            <?php

                        }else{
                            ?>
                        if(<?php echo esc_attr($id_calc);?>month == '' || <?php echo esc_attr($id_calc);?>month == undefined || <?php echo esc_attr($id_calc);?>month == NaN){
                            <?php echo esc_attr($id_calc);?>month = 0;
                            $('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val(0);
                        }
                        $('#<?php echo esc_attr($id_calc);?>calc_input_button').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Recalculate"));?> <img src="<?php echo plugins_url('images/Vector Smart Object.png',__FILE__);?>" >');
                        $('#<?php echo esc_attr($id_calc);?>calc_input_button').addClass('re');
                        var bmi = (parseFloat(<?php echo esc_attr($id_calc);?>weight)/(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                        $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                        $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                        $('#<?php echo esc_attr($id_calc);?>calc_bmi').html(bmi);

                        $('.img_calc_kid_wrapper.<?php echo esc_attr($id_calc);?> img').css('display','none');



                        $("#percentiles_graf_kid").css('display','block')
                        if($('input[name=calc_sex<?php echo esc_attr($id_calc);?>]:checked').val()=='true'){
                            var cat_bmi = '';
                            if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][0]){
                                cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>';
                            }else{
                                if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][1]){
                                    cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>'
                                }else{
                                    if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][2]){
                                        cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>'
                                    }else{
                                        cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>'
                                    }
                                }
                            }


                            var percentile = 0;
                            var per_min = 99999;
                            var per_arr = [0,0,0,0,0,1,3,5,10,15,25,50,75,85,90,95,97,99];
                            if(units == 'metric'){
                                var min_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                                var max_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                            }else{
                                var min_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                                var max_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                            }
                            for(var i = 5;i<18;i++){
                                if(Math.abs(percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi)<per_min){
                                    percentile = per_arr[i];
                                    console.log('per - '+percentile);
                                    per_min = Math.abs(percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi);
                                }
                            }
                            //console.log('per - '+percentile);
                            var help_html = default_html1;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data1').html(help_html)
                                    help_html = default_html2;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data2').html(help_html)
                                    help_html = default_html3;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data3').html(help_html)

                            $('.calc_info_line_result_wrapper_per').css('left','calc('+percentile+'% - 10px )')
                        }else{

                            var cat_bmi = '';
                            if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][0]){
                                cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>'
                            }else{
                                if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][1]){
                                    cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>'
                                }else{
                                    if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][2]){
                                        cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>'
                                    }else{
                                        cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>'
                                    }
                                }
                            }
                            var percentile = 0;
                            var per_min = 99999;
                            var per_arr = [0,0,0,0,0,1,3,5,10,15,25,50,75,85,90,95,97,99];
                            if(units == 'metric'){
                                var min_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                                var max_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                            }else{
                                var min_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                                var max_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                            }
                            for(var i = 5;i<18;i++){
                                if(Math.abs(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi)<per_min){
                                    percentile = per_arr[i];
                                    per_min = Math.abs(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi);
                                    console.log('per - '+percentile);
                                }
                                console.log(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]);
                                console.log(bmi);

                            }
                            console.log('per - '+percentile);
                            $('#<?php echo esc_attr($id_calc);?>calc_conclusion_per').html(percentile+'th')
                            $('.calc_info_line_result_wrapper_per').css('left','calc('+percentile+'% - 10px )')


                            var help_html = default_html1;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data1').html(help_html)
                                    help_html = default_html2;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data2').html(help_html)
                                    help_html = default_html3;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data3').html(help_html)


                        }

                        <?php } ?>





                        }
                    }else{



                    if(can){
                        can = check_imperial_kid(true);
                    }
                    $('#<?php echo esc_attr($id_calc);?>calc_age_years_input').on('input',function(){

                        if(/^[\d]*$/.test($(this).val())){
                            <?php echo esc_attr($id_calc);?>year = $(this).val();
                        }else{
                            $(this).val(<?php echo esc_attr($id_calc);?>year);
                        }
                        if($(this).val()==null || parseInt($(this).val()) < 0 || parseInt($(this).val()) > 18 || !Number.isInteger(parseInt($(this).val())) ){
                            $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                            $(this).addClass('alert');
                            can = false;
                        }else{
                            $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                            $(this).removeClass('alert');
                        }
                    })
                    $('#<?php echo esc_attr($id_calc);?>calc_age_month_input').on('input',function(){

                        if(/^[\d]*$/.test($(this).val())){
                            <?php echo esc_attr($id_calc);?>month = $(this).val();
                        }else{
                            $(this).val(<?php echo esc_attr($id_calc);?>month);
                        }
                        if(parseInt($(this).val()) < 0 || parseInt($(this).val()) > 12 || !Number.isInteger(parseInt($(this).val())) ){
                            $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','1');
                            $(this).addClass('alert');
                            can = false;
                        }else{
                            $('.alert-mess[for="'+$(this).attr('id')+'"]').css('opacity','0');
                            $(this).removeClass('alert');
                        }
                    })

                    //console.log(can);
                    if(can){
                        <?php if($redirect==1){
                            ?>
                            document.location.href = "<?php echo esc_url($redirect_link); ?>?redirect=1&height="+<?php echo esc_attr($id_calc);?>height+"&weight="+<?php echo esc_attr($id_calc);?>weight+"&month="+$('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()+"&age="+$('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()+"&gender="+$('input[name="calc_sex<?php echo esc_attr($id_calc);?>"]:checked').val()+"&units="+units+"&ft="+$('#<?php echo esc_attr($id_calc);?>calc_height_input_ft').val()+"&in="+$('#<?php echo esc_attr($id_calc);?>calc_height_input_in').val()+"&lb="+$('#<?php echo esc_attr($id_calc);?>calc_weight_input_lb').val()+"&st="+$('#<?php echo esc_attr($id_calc);?>calc_weight_input_st').val()+"#calc_wrapper";
                            <?php

                        }else{
                            ?>
                        if(<?php echo esc_attr($id_calc);?>month == '' || <?php echo esc_attr($id_calc);?>month == undefined || <?php echo esc_attr($id_calc);?>month == NaN){
                            <?php echo esc_attr($id_calc);?>month = 0;
                            $('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val(0);
                        }
                        $('#<?php echo esc_attr($id_calc);?>calc_input_button').html('<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Recalculate"));?> <img src="<?php echo plugins_url('images/Vector Smart Object.png',__FILE__);?>" >');
                        $('#<?php echo esc_attr($id_calc);?>calc_input_button').addClass('re');
                        var bmi = (parseFloat(<?php echo esc_attr($id_calc);?>weight)/(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)).toFixed(0);
                        $('.calc_info_placeholder.<?php echo esc_attr($id_calc);?>').css('display','none');
                        $('.calc_info_data.<?php echo esc_attr($id_calc);?>').css('display','block');
                        $('#<?php echo esc_attr($id_calc);?>calc_bmi').html(bmi);

                        $('.img_calc_kid_wrapper.<?php echo esc_attr($id_calc);?> img').css('display','none');



                        $("#percentiles_graf_kid").css('display','block')
                        if($('input[name=calc_sex<?php echo esc_attr($id_calc);?>]:checked').val()=='true'){
                            var cat_bmi = '';
                            if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][0]){
                                cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>';
                            }else{
                                if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][1]){
                                    cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>'
                                }else{
                                    if(bmi < percentile_arr[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][2]){
                                        cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>'
                                    }else{
                                        cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>'
                                    }
                                }
                            }


                            var percentile = 0;
                            var per_min = 99999;
                            var per_arr = [0,0,0,0,0,1,3,5,10,15,25,50,75,85,90,95,97,99];

                                var min_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                                var max_bmi = (percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);

                            for(var i = 5;i<18;i++){
                                if(Math.abs(percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi)<per_min){
                                    percentile = per_arr[i];
                                    console.log('per - '+percentile);
                                    per_min = Math.abs(percentile_arr11[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi);
                                }
                            }
                            //console.log('per - '+percentile);
                            var help_html = default_html1;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data1').html(help_html)
                                    help_html = default_html2;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data2').html(help_html)
                                    help_html = default_html3_imperial;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data3_imperial').html(help_html)

                            $('.calc_info_line_result_wrapper_per').css('left','calc('+percentile+'% - 10px )')
                        }else{

                            var cat_bmi = '';
                            if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][0]){
                                cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>'
                            }else{
                                if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][1]){
                                    cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>'
                                }else{
                                    if(bmi < percentile_arr2[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][2]){
                                        cat_bmi = '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>'
                                    }else{
                                        cat_bmi =  '<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>'
                                    }
                                }
                            }
                            var percentile = 0;
                            var per_min = 99999;
                            var per_arr = [0,0,0,0,0,1,3,5,10,15,25,50,75,85,90,95,97,99];

                                var min_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][7]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);
                                var max_bmi = (percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][13]*(parseInt(<?php echo esc_attr($id_calc);?>height)/100*parseInt(<?php echo esc_attr($id_calc);?>height)/100)*2.20462).toFixed(0);

                            for(var i = 5;i<18;i++){
                                if(Math.abs(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi)<per_min){
                                    percentile = per_arr[i];
                                    per_min = Math.abs(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]-bmi);
                                    console.log('per - '+percentile);
                                }
                                console.log(percentile_arr22[(parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val())*12+parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))][i]);
                                console.log(bmi);

                            }
                            console.log('per - '+percentile);
                            $('#<?php echo esc_attr($id_calc);?>calc_conclusion_per').html(percentile+'th')
                            $('.calc_info_line_result_wrapper_per').css('left','calc('+percentile+'% - 10px )')


                            var help_html = default_html1;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data1').html(help_html)
                                    help_html = default_html2;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data2').html(help_html)
                                    help_html = default_html3_imperial;
                                    help_html = help_html.replace('XPERCENTILE',"<span class='calc_info_data_value'>"+percentile+"</span>")
                                    help_html = help_html.replace('XYEAR',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val()))
                                    help_html = help_html.replace('XMONTH',parseInt($('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val()))
                                    help_html = help_html.replace('XGENDER','<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>')
                                    help_html = help_html.replace('XCATEGORY',"<span class='calc_info_data_value'>"+cat_bmi+"</span>")
                                    help_html = help_html.replace('XMINMAX',"<span class='calc_info_data_value'>"+min_bmi+" & "+max_bmi+"</span>")
                                    $('#child_full_data3_imperial').html(help_html)


                        }

                        <?php } ?>





                        }
                    }

            })
<?php if($_GET['redirect']==1){
 ?>
var can = true;






var <?php echo esc_attr($id_calc);?>year = '<?php echo esc_attr($_GET['age']);?>';
var <?php echo esc_attr($id_calc);?>month = '<?php echo esc_attr($_GET['month']);?>';
$('#<?php echo esc_attr($id_calc);?>calc_age_years_input').val('<?php echo esc_attr($_GET['age']);?>');
$('#<?php echo esc_attr($id_calc);?>calc_age_month_input').val('<?php echo esc_attr($_GET['month']);?>');



if('<?php echo esc_attr($_GET['units']);?>'=='metric'){



    $('#<?php echo esc_attr($id_calc);?>calc_height_input').val('<?php echo esc_attr($_GET['height']);?>');
    $('#<?php echo esc_attr($id_calc);?>calc_weight_input').val('<?php echo esc_attr($_GET['weight']);?>');

    var <?php echo esc_attr($id_calc);?>height = '<?php echo esc_attr($_GET['height']);?>';
    var <?php echo esc_attr($id_calc);?>weight = '<?php echo esc_attr($_GET['weight']);?>';






}else{
    $('input[name="<?php echo esc_attr($id_calc);?>units_checkbox"][value="imperial"]').prop('checked', true).change();
    units = 'imperial';
    $('#<?php echo esc_attr($id_calc);?>calc_height_input_ft').val('<?php echo esc_attr($_GET['ft']);?>');
    $('#<?php echo esc_attr($id_calc);?>calc_height_input_in').val('<?php echo esc_attr($_GET['in']);?>');
    $('#<?php echo esc_attr($id_calc);?>calc_weight_input_lb').val('<?php echo esc_attr($_GET['lb']);?>');
    $('#<?php echo esc_attr($id_calc);?>calc_weight_input_st').val('<?php echo esc_attr($_GET['st']);?>');
    <?php echo esc_attr($id_calc);?>height = <?php echo esc_attr($_GET['height']);?>;
    <?php echo esc_attr($id_calc);?>weight = <?php echo esc_attr($_GET['weight']);?>;
}







$('#<?php echo esc_attr($id_calc);?>calc_input_button').click();

<?php } ?>
        })( jQuery );
})






    </script>
    <?php
    $buf = ob_get_contents() ;
    ob_end_clean();
    return $buf;
}
add_shortcode('BMIAKC_kid_calc', 'BMIAKC_kid_calc');
add_action( 'wp_ajax_BMIAKC_delete_lang_bmi_calc', 'BMIAKC_delete_lang_bmi_calc' );

function BMIAKC_delete_lang_bmi_calc(){
    check_ajax_referer( 'BMIAKC_delete_lang_bmi_calc', 'security' );
	if(!current_user_can('manage_options')){
		wp_send_json_error();
	}
    $delete_lang = sanitize_text_field($_POST['lang']);
    $lang_arr = explode(',',get_option('lang_bmi_calc'));
    unset($lang_arr[array_search($delete_lang, $lang_arr)]);
    $arr_lang = implode(',',$lang_arr);
    update_option('lang_bmi_calc',$arr_lang );
    delete_option('lang_bmi_calc'.$delete_lang.'Title');
    delete_option('lang_bmi_calc'.$delete_lang.'Units');
    delete_option('lang_bmi_calc'.$delete_lang.'TitleDesc');
  	delete_option('kidlang_bmi_calc'.$delete_lang.'TitleDesc');
    delete_option('lang_bmi_calc'.$delete_lang.'Height');
    delete_option('lang_bmi_calc'.$delete_lang.'YourHeight');
    delete_option('lang_bmi_calc'.$delete_lang.'Cm');
    delete_option('lang_bmi_calc'.$delete_lang.'Ft');
    delete_option('lang_bmi_calc'.$delete_lang.'In');
    delete_option('lang_bmi_calc'.$delete_lang.'Weight');

    delete_option('lang_bmi_calc'.$delete_lang.'YourWeight');
    delete_option('lang_bmi_calc'.$delete_lang.'Kg');
    delete_option('lang_bmi_calc'.$delete_lang.'Lb');
    delete_option('lang_bmi_calc'.$delete_lang.'St');
    delete_option('lang_bmi_calc'.$delete_lang.'HeightReg');
    delete_option('lang_bmi_calc'.$delete_lang.'WeightReg');

    delete_option('lang_bmi_calc'.$delete_lang.'HeightRegFt');
    delete_option('lang_bmi_calc'.$delete_lang.'WeightRegLb');


    delete_option('lang_bmi_calc'.$delete_lang.'Calculate');
    delete_option('lang_bmi_calc'.$delete_lang.'Recalculate');

    delete_option('lang_bmi_calc'.$delete_lang.'Placeholder');
    delete_option('lang_bmi_calc'.$delete_lang.'BMI');
    delete_option('lang_bmi_calc'.$delete_lang.'Category');
    delete_option('lang_bmi_calc'.$delete_lang.'Healthy');
    delete_option('lang_bmi_calc'.$delete_lang.'Underweight');

    delete_option('lang_bmi_calc'.$delete_lang.'Overweight');
    delete_option('lang_bmi_calc'.$delete_lang.'Obese');
    delete_option('lang_bmi_calc'.$delete_lang.'Normal1');
    delete_option('lang_bmi_calc'.$delete_lang.'Normal2');
    delete_option('lang_bmi_calc'.$delete_lang.'Normal2Lb');
    delete_option('lang_bmi_calc'.$delete_lang.'You');



    delete_option('kidlang_bmi_calc'.$delete_lang.'YourHeight');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Cm');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Ft');


    delete_option('kidlang_bmi_calc'.$delete_lang.'YourWeight');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Kg');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Lb');


    delete_option('kidlang_bmi_calc'.$delete_lang.'Age');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Year');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Month');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Gender');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Boy');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Girl');
    delete_option('kidlang_bmi_calc'.$delete_lang.'AgeReg');


    delete_option('kidlang_bmi_calc'.$delete_lang.'HeightReg');
    delete_option('kidlang_bmi_calc'.$delete_lang.'WeightReg');
    delete_option('kidlang_bmi_calc'.$delete_lang.'HeightRegFt');
    delete_option('kidlang_bmi_calc'.$delete_lang.'WeightRegLb');


    delete_option('kidlang_bmi_calc'.$delete_lang.'Placeholder');
    delete_option('kidlang_bmi_calc'.$delete_lang.'BMI');
    delete_option('kidlang_bmi_calc'.$delete_lang.'Category1');
  	delete_option('kidlang_bmi_calc'.$delete_lang.'Category2');
  	delete_option('kidlang_bmi_calc'.$delete_lang.'Category3');
      delete_option('kidlang_bmi_calc'.$delete_lang.'Category3Lb');
    die;

}
add_action( 'wp_ajax_BMIAKC_edit_visual_bmi_calc', 'BMIAKC_edit_visual_bmi_calc' );
function BMIAKC_edit_visual_bmi_calc(){
	check_ajax_referer( 'BMIAKC_edit_visual_bmi_calc', 'security' );
	if(!current_user_can('manage_options')){
		wp_send_json_error();
	}
  $fontf = !empty($_POST['fontf']) ? $_POST['fontf'] : '';
  $fontc1 = !empty($_POST['fontc1']) ? $_POST['fontc1'] : '';
  $fontc2 = !empty($_POST['fontc2']) ? $_POST['fontc2'] : '';
  $fontc3 = !empty($_POST['fontc3']) ? $_POST['fontc3'] : '';
  update_option('Font_family_calc_visual',sanitize_text_field($fontf));
  update_option('Font_color1_calc_visual',sanitize_text_field($fontc1));
  update_option('Font_color2_calc_visual',sanitize_text_field($fontc2));
  update_option('Font_color3_calc_visual',sanitize_text_field($fontc3));
  wp_send_json_success();
}

function get_backup_link($lang){
    $help_l = substr(get_bloginfo('language'), 0, 2);
    $help_bl = get_option("lang_bmi_calc".$lang."BackupLink");
    if (!$help_bl){
        $help_bls = ['es' => '/es/calculadora-de-imc/', 'fr'=>'/fr/calculateur-d’imc/', 'de'=>'/de/bmi-rechner/', 'pt'=>'/pt/calculadora-de-imc/', 'it'=>'/it/calcolatore-imc/', 'hi'=>'/hi/bmi-कैलकुलेटर/', 'id'=>'/id/kalkulator-bmi/', 'ar'=>'/ar/حاسبة-مؤشر-كتلة-الجسم/', 'ru'=>'/ru/калькулятор-имт/', 'ja'=>'/ja/bmi計算機/', 'zh'=>'/zh/bmi-计算器/', 'pl'=>'/pl/kalkulator-bmi/', 'fa'=>'/fa/محاسبه‌گر-شاخص-توده‌ی-بدنی-bmi/', 'nl'=>'/nl/bmi-calculator/', 'ko'=>'/ko/bmi-계산기/', 'th'=>'/th/เครื่องคำนวณ-bmi/', 'tr'=>'/tr/vki̇-hesaplayıcı/', 'vi'=>'/vi/máy-tính-bmi/'];
        $help_bl = 'https://www.calculator.io' . (isset($help_bls[$help_l]) ? $help_bls[$help_l] : '/bmi-calculator/');
        update_option("lang_bmi_calc".$lang."BackupLink", $help_bl);
    }
    return $help_bl;
}

function get_link_option($lang){
    if (strpos($_SERVER['HTTP_HOST'], 'beregner') !== false) return;
    $help_opt = get_option("lang_bmi_calc".$lang."LinkOption");
    if (!$help_opt){
        $help_opt = rand(1, 3);
        update_option("lang_bmi_calc".$lang."LinkOption", $help_opt);
    }
    return $help_opt;
}

add_action( 'wp_ajax_BMIAKC_edit_lang_bmi_calc', 'BMIAKC_edit_lang_bmi_calc' );
function BMIAKC_edit_lang_bmi_calc(){
	check_ajax_referer( 'BMIAKC_edit_lang_bmi_calc', 'security' );
	if(!current_user_can('manage_options')){
		wp_send_json_error();
	}
    $lang = sanitize_text_field($_POST['lang']);
	ob_start();
    ?>
<input id="calc_new_lang_name" class="calc_input_custom" type="text" value="<?php echo esc_attr($lang);?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishTitle"));?>" id="calc_new_lang_Title" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Title"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishUnits"));?>" id="calc_new_lang_Units" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Units"));?>">


    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishTitleDesc"));?>" id="calc_new_lang_TitleDesc" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."TitleDesc"));?>">
	<input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishTitleDesc"));?>" id="kidcalc_new_lang_TitleDesc" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."TitleDesc"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishHeight"));?>" id="calc_new_lang_Height" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Height"));?>">

    <input  placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishYourHeight"));?>" id="calc_new_lang_YourHeight" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."YourHeight"));?>">
    <input  placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishCm"));?>" id="calc_new_lang_Cm" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Cm"));?>">
    <input  placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishFt"));?>" id="calc_new_lang_Ft" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Ft"));?>">
    <input  placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishIn"));?>" id="calc_new_lang_In" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."In"));?>">


    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishWeight"));?>" id="calc_new_lang_Weight" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Weight"));?>">
    <input  placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishYourWeight"));?>" id="calc_new_lang_YourWeight" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."YourWeight"));?>">

    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishKg"));?>" id="calc_new_lang_Kg" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Kg"));?>">

    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishLb"));?>" id="calc_new_lang_Lb" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Lb"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishSt"));?>" id="calc_new_lang_St" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."St"));?>">


    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishHeightReg"));?>" id="calc_new_lang_HeightReg" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."HeightReg"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishWeightReg"));?>" id="calc_new_lang_WeightReg" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."WeightReg"));?>">

    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishHeightRegFt"));?>" id="calc_new_lang_HeightRegFt" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."HeightRegFt"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishWeightRegLb"));?>" id="calc_new_lang_WeightRegLb" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."WeightRegLb"));?>">

    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishCalculate"));?>" id="calc_new_lang_Calculate" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Calculate"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishRecalculate"));?>" id="calc_new_lang_Recalculate" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Recalculate"));?>">

    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishPlaceholder"));?>" id="calc_new_lang_Placeholder" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Placeholder"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishBMI"));?>" id="calc_new_lang_BMI" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."BMI"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishCategory"));?>" id="calc_new_lang_Category" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Category"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishHealthy"));?>" id="calc_new_lang_Healthy" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Healthy"));?>">

    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishUnderweight"));?>" id="calc_new_lang_Underweight" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Underweight"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishOverweight"));?>" id="calc_new_lang_Overweight" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Overweight"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishObese"));?>" id="calc_new_lang_Obese" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Obese"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishNormal1"));?>" id="calc_new_lang_Normal1" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Normal1"));?>">

    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishNormal2"));?>" id="calc_new_lang_Normal2" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Normal2"));?>">
    <input placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishNormal2Lb"));?>" id="calc_new_lang_Normal2Lb" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."Normal2Lb"));?>">

    <input  placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishYou"));?>" id="calc_new_lang_You" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("lang_bmi_calc".$lang."You"));?>">




    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishYourHeight"));?>" id="kidcalc_new_lang_YourHeight" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."YourHeight"));?>">

    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCm"));?>" id="kidcalc_new_lang_Cm" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Cm"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishFt"));?>" id="kidcalc_new_lang_Ft" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Ft"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishIn"));?>" id="kidcalc_new_lang_In" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."In"));?>">




    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishYourWeight"));?>" id="kidcalc_new_lang_YourWeight" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."YourWeight"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishKg"));?>" id="kidcalc_new_lang_Kg" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Kg"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishLb"));?>" id="kidcalc_new_lang_Lb" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Lb"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishSt"));?>" id="kidcalc_new_lang_St" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."St"));?>">



    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishAge"));?>" id="kidcalc_new_lang_Age" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Age"));?>">

    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishYear"));?>" id="kidcalc_new_lang_Year" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Year"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishMonth"));?>" id="kidcalc_new_lang_Month" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Month"));?>">

    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishGender"));?>" id="kidcalc_new_lang_Gender" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Gender"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishBoy"));?>" id="kidcalc_new_lang_Boy" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Boy"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishGirl"));?>" id="kidcalc_new_lang_Girl" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Girl"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishAgeReg"));?>" id="kidcalc_new_lang_AgeReg" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."AgeReg"));?>">

    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishHeightReg"));?>" id="kidcalc_new_lang_HeightReg" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."HeightReg"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishWeightReg"));?>" id="kidcalc_new_lang_WeightReg" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."WeightReg"));?>">

    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishHeightRegFt"));?>" id="kidcalc_new_lang_HeightRegFt" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."HeightRegFt"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishWeightRegLb"));?>" id="kidcalc_new_lang_WeightRegLb" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."WeightRegLb"));?>">





    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishPlaceholder"));?>" id="kidcalc_new_lang_Placeholder" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Placeholder"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishBMI"));?>" id="kidcalc_new_lang_BMI" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."BMI"));?>">
    <input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCategory1"));?>" id="kidcalc_new_lang_Category1" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Category1"));?>">
	<input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCategory2"));?>" id="kidcalc_new_lang_Category2" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Category2"));?>">
<input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCategory3"));?>" id="kidcalc_new_lang_Category3" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Category3"));?>">
<input placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCategory3Lb"));?>" id="kidcalc_new_lang_Category3Lb" class="calc_input_custom" type="text" value="<?php echo esc_attr(get_option("kidlang_bmi_calc".$lang."Category3Lb"));?>">

<div class="BMIC_info_admin">
        When filling in this fields insert:<br>XPERCENTILE - where the percentile should be<br>XYEAR / XMONTH where the child's age should be<br>XGENDER - where the child's gender should be<br>XCATEGORY - where the BMI category should be<br>XMINMAX where the minimum and maximum weight of a healthy child should be ( in format MIN & MAX ).
    </div>

    <?php
	$html = ob_get_clean();
	wp_send_json_success($html);
}

add_action( 'wp_ajax_BMIAKC_save_new_bmi_lang', 'BMIAKC_save_new_bmi_lang' );
function BMIAKC_save_new_bmi_lang(){
	check_ajax_referer('BMIAKC_save_new_bmi_lang', 'security' );
	if(!current_user_can('manage_options')){
		wp_send_json_error();
	}
    $data_calc = explode('!!!!!',stripcslashes(sanitize_text_field($_POST['data_calc'])));
    $lang = '';
    $arr_data_check = get_option('lang_bmi_calc');
    foreach($data_calc as $elem){
        $help = explode('???????',$elem);
        $help[1] = addslashes($help[1]);
        if($help[0]=='name'){
            if($help[1]==''){
                return 0;
            }
            if(in_array($help[1],explode(',',$arr_data_check))){
                $lang = $help[1];
            }else{
                update_option('lang_bmi_calc',get_option('lang_bmi_calc').",".$help[1]);
                $lang = $help[1];
            }

        }else{
            if(in_array($lang,explode(',',$arr_data_check))){
                if(stristr($help[0],'kid')!==false){
                    $newop = str_replace('kid','',$help[0]);
                    update_option('kidlang_bmi_calc'.$lang.$newop,esc_html(stripcslashes($help[1])));
                }else{
                    update_option('lang_bmi_calc'.$lang.$help[0],esc_html(stripcslashes($help[1])));
                }

            }else{
                if(stristr($help[0],'kid')!==false){
                    $newop = str_replace('kid','',$help[0]);
                    add_option('kidlang_bmi_calc'.$lang.$newop,esc_html(stripcslashes($help[1])));
                }else{
                    add_option('lang_bmi_calc'.$lang.$help[0],esc_html(stripcslashes($help[1])));
                }
            }
        }
    }

    wp_send_json_success();

}

add_action('admin_menu', 'BMIAKC_bmi_add_pagesUser');

// action function for above hook
function BMIAKC_bmi_add_pagesUser() {
    // Add a new submenu under Options:
    add_menu_page('BMI Calculator', 'BMI Calculator', 'manage_options', 'bmioption', 'BMIAKC_bmi_options_pageUser');
}
function BMIAKC_bmi_options_pageUser() {
//echo do_shortcode('[BMIAKC_adult_calc lang="English" id_calc="e1664246026"]');
//echo do_shortcode('[BMIAKC_kid_calc lang="English" id_calc="e1664246027"]');
add_option('lang_bmi_calc','English');
add_option('lang_bmi_calcEnglishTitle','BMI Calculator');


add_option('lang_bmi_calcEnglishTitleDesc','Use this calculator to check your body mass index (BMI).');
add_option('kidlang_bmi_calcEnglishTitleDesc',"Use this calculator to check your kid's body mass index (BMI).");


add_option('lang_bmi_calcEnglishUnits','Unit type');
update_option('lang_bmi_calcEnglishUnits','Unit type');

add_option('lang_bmi_calcEnglishHeight','Height');
add_option('lang_bmi_calcEnglishYourHeight','Your height');
add_option('lang_bmi_calcEnglishCm','cm.');
add_option('lang_bmi_calcEnglishFt','ft.');
add_option('lang_bmi_calcEnglishWeight','Weight');

add_option('lang_bmi_calcEnglishYourWeight','Your weight');
add_option('lang_bmi_calcEnglishKg','kg.');
add_option('lang_bmi_calcEnglishLb','lb.');


add_option('lang_bmi_calcEnglishHeightReg','Please enter value between 125 and 225.');
add_option('lang_bmi_calcEnglishWeightReg','Please enter value between 10.0 and 500.0 ( one decimal ).');

add_option('lang_bmi_calcEnglishHeightRegFt','Please enter value between 4.2 and 7.3');
add_option('lang_bmi_calcEnglishWeightRegLb','Please enter value between 22.0 and 1000.0 ( one decimal ).');


add_option('lang_bmi_calcEnglishCalculate','Calculate BMI ');
add_option('lang_bmi_calcEnglishRecalculate','Recalculate BMI ');

add_option('lang_bmi_calcEnglishPlaceholder','Use this calculator to check your body mass index (BMI), which can be a helpful tool in determining your weight category. Or, use it to calculate your child’s BMI.');
add_option('lang_bmi_calcEnglishBMI','Your Body Mass Index (BMI) is');
add_option('lang_bmi_calcEnglishCategory','Based on your input, your BMI is in the category');
add_option('lang_bmi_calcEnglishHealthy','Healthy');
add_option('lang_bmi_calcEnglishUnderweight','Underweight');

add_option('lang_bmi_calcEnglishOverweight','Overweight');
add_option('lang_bmi_calcEnglishObese','Obese');
add_option('lang_bmi_calcEnglishNormal1','For your height, a healthy weight would be between');
add_option('lang_bmi_calcEnglishNormal2','kilograms');
add_option('lang_bmi_calcEnglishNormal2Lb','lb.');
add_option('lang_bmi_calcEnglishYou','You');



add_option('kidlang_bmi_calcEnglishYourHeight',"Child's height");
add_option('kidlang_bmi_calcEnglishCm','cm.');
add_option('kidlang_bmi_calcEnglishFt','ft.');
add_option('kidlang_bmi_calcEnglishIn','in.');
add_option('lang_bmi_calcEnglishIn','in.');

add_option('kidlang_bmi_calcEnglishYourWeight',"Child's weight");
add_option('kidlang_bmi_calcEnglishKg','kg.');
add_option('kidlang_bmi_calcEnglishLb','lb.');
add_option('kidlang_bmi_calcEnglishSt','st.');
add_option('lang_bmi_calcEnglishSt','st.');


add_option('kidlang_bmi_calcEnglishAge','Age');
add_option('kidlang_bmi_calcEnglishYear','yr.');
add_option('kidlang_bmi_calcEnglishMonth','mth.');
add_option('kidlang_bmi_calcEnglishGender','Select gender');
add_option('kidlang_bmi_calcEnglishBoy','Boy');
add_option('kidlang_bmi_calcEnglishGirl','Girl');
add_option('kidlang_bmi_calcEnglishAgeReg','Please enter value between 0 and 19 years.');


add_option('kidlang_bmi_calcEnglishHeightRegFt','Please enter value between 1.4 and 7.3');
add_option('kidlang_bmi_calcEnglishWeightReg','Please enter value between 1.0 and 250.0 ( one decimal ).');

add_option('kidlang_bmi_calcEnglishHeightReg','Please enter value between 40 and 225.');
add_option('kidlang_bmi_calcEnglishWeightRegLb','Please enter value between 2.3 and 500.0 ( one decimal ).');




add_option('kidlang_bmi_calcEnglishPlaceholder','Use this calculator to check your body mass index (BMI), which can be a helpful tool in determining your weight category. Or, use it to calculate your child’s BMI.');
add_option('kidlang_bmi_calcEnglishBMI',"Based on your inputs your child's BMI is:");
add_option('kidlang_bmi_calcEnglishCategory1',"Your child's BMI for age is placed in the greater than XPERCENTILE percentile for a XYEAR year and XMONTH month XGENDER.");
add_option('kidlang_bmi_calcEnglishCategory2',"This falls in the XCATEGORY BMI category.");
add_option('kidlang_bmi_calcEnglishCategory3',"A healthy weight for your childs age and height is between XMINMAX kg");
add_option('kidlang_bmi_calcEnglishCategory3Lb',"A healthy weight for your childs age and height is between XMINMAX lb");

  add_option('Font_family_calc_visual',"dm sans,sans-serif");
  add_option('Font_color1_calc_visual',"#fff");
  add_option('Font_color2_calc_visual',"#000");
  add_option('Font_color3_calc_visual',"#394f5c");
//add_option('kidlang_bmi_calcEnglishPercentile','Percentile');


?>
<h1>BMI Calculator</h1>
<div class="calc_container">
    <h1>Shortcode Generator</h1>
    <div class="calc_choose_lang_title">
        Choose language
    </div>
    <?php
    $a = 1;
    foreach(explode(',',get_option('lang_bmi_calc')) as $lang){
        if($a==1){
            $a=2;
            echo "<div class='custom-flex'><input type='radio' name='lang_calc' id='lang_radio_".esc_attr($lang)."' value='".esc_attr($lang)."' checked><label class='radio-label' for='lang_radio_".esc_attr($lang)."'>".esc_attr($lang)."</label><div edit='".esc_attr($lang)."' class='edit_lang_custom' style='color:blue;margin-left:10px;cursor:pointer'>Edit</div>
            
            </div>";
        }else{
            echo "<div class='custom-flex'><input type='radio' name='lang_calc' id='lang_radio_".esc_attr($lang)."' value='".esc_attr($lang)."'><label class='radio-label' for='lang_radio_".esc_attr($lang)."'>".esc_attr($lang)."</label><div delete='".esc_attr($lang)."' class='delete_lang_custom'>Delete</div><div edit='".esc_attr($lang)."' class='edit_lang_custom' style='color:blue;margin-left:10px;cursor:pointer'>Edit</div></div>";
        }

    }
    ?>
    <div class="calc_choose_lang_title">
        Choose Calculator
    </div>
    <div class='custom-flex'>
        <input type='radio' name='what_radio_kind' id='what_radio_kind1' value='1' checked>
        <label class='radio-label' for='what_radio_kind1'>Adult BMI Calculator (20 years+)</label>
    </div>
    <div class='custom-flex'>
        <input type='radio' name='what_radio_kind' id='what_radio_kind2' value='2'>
        <label class='radio-label' for='what_radio_kind2'>Children BMI Calculator (19 years or below)</label>
    </div>





    <div class="calc_choose_lang_title">
        Metric System/Imperial System
    </div>
    <div class='custom-flex'>
        <input type='radio' name='what_units_kind' id='what_units_kind1' value='1' checked>
        <label class='radio-label' for='what_units_kind1'>Metric Units</label>
    </div>
    <div class='custom-flex'>
        <input type='radio' name='what_units_kind' id='what_units_kind2' value='2'>
        <label class='radio-label' for='what_units_kind2'>Imperial Units</label>
    </div>
    <div class='custom-flex'>
        <input type='radio' name='what_units_kind' id='what_units_kind3' value='3'>
        <label class='radio-label' for='what_units_kind3'>Both</label>
    </div>





    <div class="calc_choose_lang_title" style="display:none">
        Add redirect on click <input type='checkbox' id='redirect_link'>
    </div>
        <input type='text' class="hidden"  id='hidden_link_input' placeholder="The widget must be on the page">
    <div class="calc_input_button" id="generate_shortcode_calc" style="max-width:200px">
        Generate shortcode
    </div>
    <div class="calc_choose_lang_title" id="shortcode_calc_value">

    </div>
</div>
<style>
    .hidden{
        display:none;
    }
    #hidden_link_input{
        padding:10px;
        width:100%;
        max-width:350px;
        margin-bottom: 10px;
    }
    .customize input[type="text"]{
      padding: 10px;
      width: 100%;
      max-width: 350px;
      margin-bottom: 10px;
    }
  .customize{
  	margin-top:20px!important;
  }
</style>
<script>
    (function( $ ) {
        $('#redirect_link').on('change',function(){
            $('#hidden_link_input').toggleClass('hidden');
        })
    })( jQuery );
</script>
<div class="calc_container customize">
  <div class="calc_choose_lang_title">
    Customize
  </div>
  <input type='text' class="" id='font_family' placeholder="Font family" value="<?php echo get_option('Font_family_calc_visual');?>">
  <input type='text' class="" id='font_color1' placeholder="Title color" value="<?php echo get_option('Font_color1_calc_visual');?>">
  <input type='text' class="" id='font_color2' placeholder="Text color" value="<?php echo get_option('Font_color2_calc_visual');?>">
  <input type='text' class="" id='font_color3' placeholder="Values color" value="<?php echo get_option('Font_color3_calc_visual');?>">
  <div class="calc_input_button" id="udate_visual_calc" style="max-width:200px">
    Save
  </div>
</div>
<div class="calc_container" id="new_lang_container" style="margin-top:20px">
    <div class="calc_choose_lang_title">
        Add language
    </div>


    <div class="edit_wrapper_for">
    <input id="calc_new_lang_name" class="calc_input_custom" type="text" placeholder="Language name">
    <input id="calc_new_lang_Units" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishUnits"));?>">
    <input id="calc_new_lang_Title" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishTitle"));?>">
    <input id="calc_new_lang_TitleDesc" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishTitleDesc"));?>">





    <input id="kidcalc_new_lang_TitleDesc" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishTitleDesc"));?>">
    <input id="calc_new_lang_Height" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishHeight"));?>">

    <input id="calc_new_lang_YourHeight" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishYourHeight"));?>">
    <input id="calc_new_lang_Cm" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishCm"));?>">
    <input id="calc_new_lang_Ft" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishFt"));?>">
    <input id="calc_new_lang_In" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishIn"));?>">

    <input id="calc_new_lang_Weight" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishWeight"));?>">
    <input id="calc_new_lang_YourWeight" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishYourWeight"));?>">

    <input id="calc_new_lang_Kg" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishKg"));?>">
    <input id="calc_new_lang_Lb" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishLb"));?>">
    <input id="calc_new_lang_St" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishSt"));?>">


    <input id="calc_new_lang_HeightReg" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishHeightReg"));?>">
    <input id="calc_new_lang_WeightReg" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishWeightReg"));?>">

    <input id="calc_new_lang_HeightRegFt" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishHeightRegFt"));?>">
    <input id="calc_new_lang_WeightRegLb" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishWeightRegLb"));?>">


    <input id="calc_new_lang_Calculate" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishCalculate"));?>">
    <input id="calc_new_lang_Recalculate" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishRecalculate"));?>">

    <input id="calc_new_lang_Placeholder" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishPlaceholder"));?>">
    <input id="calc_new_lang_BMI" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishBMI"));?>">
    <input id="calc_new_lang_Category" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishCategory"));?>">
    <input id="calc_new_lang_Healthy" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishHealthy"));?>">

    <input id="calc_new_lang_Underweight" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishUnderweight"));?>">
    <input id="calc_new_lang_Overweight" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishOverweight"));?>">
    <input id="calc_new_lang_Obese" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishObese"));?>">
    <input id="calc_new_lang_Normal1" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishNormal1"));?>">

    <input id="calc_new_lang_Normal2" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishNormal2"));?>">
    <input id="calc_new_lang_Normal2Lb" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishNormal2Lb"));?>">


    <input id="calc_new_lang_You" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("lang_bmi_calcEnglishYou"));?>">







    <input id="kidcalc_new_lang_YourHeight" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishYourHeight"));?>">

    <input id="kidcalc_new_lang_Cm" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCm"));?>">
    <input id="kidcalc_new_lang_Ft" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishFt"));?>">
    <input id="kidcalc_new_lang_In" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishIn"));?>">


    <input id="kidcalc_new_lang_YourWeight" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishYourWeight"));?>">
    <input id="kidcalc_new_lang_Kg" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishKg"));?>">
    <input id="kidcalc_new_lang_Lb" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishLb"));?>">
    <input id="kidcalc_new_lang_St" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishSt"));?>">

    <input id="kidcalc_new_lang_Age" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishAge"));?>">
    <input id="kidcalc_new_lang_Year" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishYear"));?>">
    <input id="kidcalc_new_lang_Month" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishMonth"));?>">

    <input id="kidcalc_new_lang_Gender" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishGender"));?>">
    <input id="kidcalc_new_lang_Boy" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishBoy"));?>">
    <input id="kidcalc_new_lang_Girl" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishGirl"));?>">
    <input id="kidcalc_new_lang_AgeReg" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishAgeReg"));?>">

    <input id="kidcalc_new_lang_HeightReg" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishHeightReg"));?>">
    <input id="kidcalc_new_lang_WeightReg" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishWeightReg"));?>">

    <input id="kidcalc_new_lang_HeightRegFt" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishHeightRegFt"));?>">
    <input id="kidcalc_new_lang_WeightRegLb" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishWeightRegLb"));?>">





    <input id="kidcalc_new_lang_Placeholder" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishPlaceholder"));?>">
    <input id="kidcalc_new_lang_BMI" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishBMI"));?>">
    <input id="kidcalc_new_lang_Category1" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCategory1"));?>">
      <input id="kidcalc_new_lang_Category2" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCategory2"));?>">
      <input id="kidcalc_new_lang_Category3" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCategory3"));?>">
      <input id="kidcalc_new_lang_Category3Lb" class="calc_input_custom" type="text" placeholder="<?php echo esc_attr(get_option("kidlang_bmi_calcEnglishCategory3Lb"));?>">
    <div class="BMIC_info_admin">
        When filling in this fields insert:<br>XPERCENTILE - where the percentile should be<br>XYEAR / XMONTH where the child's age should be<br>XGENDER - where the child's gender should be<br>XCATEGORY - where the BMI category should be<br>XMINMAX where the minimum and maximum weight of a healthy child should be ( in format MIN & MAX ).
    </div>
    </div>
    <div class="calc_input_button" id="save_new_language_botton" style="max-width:200px">
        Add new language
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        (function( $ ) {
            var url = location.origin;
            var what_delete = '';
            $(document).on('change','#calc_new_lang_name',function(){
                var lang_arr = '<?php echo esc_attr(get_option('lang_bmi_calc'));?>';
                lang_arr = lang_arr.split(',');
                if(lang_arr.includes($(this).val())){
                    $('#save_new_language_botton').html('Update language');
                }else{
                    $('#save_new_language_botton').html('Add new language');
                }
            })
            $('.edit_lang_custom').on('click',function(){
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: 'action=BMIAKC_edit_lang_bmi_calc&lang='+$(this).attr('edit') + '&security=<?php echo wp_create_nonce("BMIAKC_edit_lang_bmi_calc"); ?>', // можно также передать в виде массива или объекта
                    success: function( data ) {
						if(data.success){
							$('.edit_wrapper_for').html(data.data);
							$('#save_new_language_botton').html('Update language');
							$('html, body').animate({
								scrollTop: $("#new_lang_container").offset().top
							}, 1000);
						}
                    }
                });
            })
            $('#udate_visual_calc').on('click',function(){
              var fontc1 = $('#font_color1').val();
              var fontc2 = $('#font_color2').val();
              var fontc3 = $('#font_color3').val();
              var fontf = $('#font_family').val();
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: 'action=BMIAKC_edit_visual_bmi_calc&fontf='+fontf+"&fontc1="+fontc1+"&fontc2="+fontc2+"&fontc3="+fontc3 + '&security=<?php echo wp_create_nonce('BMIAKC_edit_visual_bmi_calc'); ?>', // можно также передать в виде массива или объекта
                    success: function( data ) {
                        document.location.reload();
                    }
                });
            })
            $('.delete_lang_custom').on('click',function(){
                if(what_delete==$(this).attr('delete')){
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: 'action=BMIAKC_delete_lang_bmi_calc&lang='+what_delete + '&security=<?php echo wp_create_nonce("BMIAKC_delete_lang_bmi_calc"); ?>', // можно также передать в виде массива или объекта
                        success: function( data ) {
                            document.location.reload();
                        }
                    });
                }else{
                    what_delete = $(this).attr('delete');
                    alert('Click again if you really want to remove the language');
                }
            })
            $('#generate_shortcode_calc').on('click',function(){

                var units = $('input[name=what_units_kind]:checked').val();
                switch (units) {
                    case '1':
                        units = 'units="metric"';
                        break;
                    case '2':
                        units = 'units="imperial"';
                        break;
                    case '3':
                        units = 'units="both"';
                        break;
                }
                if($('#hidden_link_input').hasClass('hidden')){
                    if($('input[name=what_radio_kind]:checked').val()==1){
                        $('#shortcode_calc_value').html('Your shortcode - [BMIAKC_adult_calc lang="'+$('input[name=lang_calc]:checked').val()+'" id_calc="e<?php echo time();?>" '+units+' ]')
                    }else{
                        $('#shortcode_calc_value').html('Your shortcode - [BMIAKC_kid_calc lang="'+$('input[name=lang_calc]:checked').val()+'" id_calc="e<?php echo time()+1;?>" '+units+' ]')
                    }
                }else{
                    if($('input[name=what_radio_kind]:checked').val()==1){
                        $('#shortcode_calc_value').html('Your shortcode - [BMIAKC_adult_calc lang="'+$('input[name=lang_calc]:checked').val()+'" id_calc="e<?php echo time();?>" redirect=1 redirect_link="'+$('#hidden_link_input').val()+'" '+units+' ]')
                    }else{
                        $('#shortcode_calc_value').html('Your shortcode - [BMIAKC_kid_calc lang="'+$('input[name=lang_calc]:checked').val()+'" id_calc="e<?php echo time()+1;?>" redirect=1 redirect_link="'+$('#hidden_link_input').val()+'" '+units+' ]')
                    }
                }


            })
            $('#save_new_language_botton').on('click',function(){
                var generate = true;
                var data_calc = '';
                $('.calc_input_custom').each(function(){
                    if(data_calc==''){
                        data_calc += $(this).attr('id').replace('calc_new_lang_','')+'???????'+$(this).val();
                        if($(this).val()==''){
                            generate = false;
                            $(this).addClass('alert');
                        }else{
                            $(this).removeClass('alert');
                        }
                    }else{
                        data_calc += '!!!!!'+$(this).attr('id').replace('calc_new_lang_','')+'???????'+$(this).val();
                        if($(this).val()==''){
                            generate = false;
                            $(this).addClass('alert');
                        }else{
                            $(this).removeClass('alert');
                        }
                    }
                })
                var lang_arr = '<?php echo esc_attr(get_option('lang_bmi_calc'));?>';
                lang_arr = lang_arr.split(',');

                if(generate){

                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: 'action=BMIAKC_save_new_bmi_lang&data_calc='+data_calc + '&security=<?php echo wp_create_nonce("BMIAKC_save_new_bmi_lang"); ?>', // можно также передать в виде массива или объекта
                        success: function( data ) {
                            document.location.reload();
                        }
                    });
                }
            })
        })( jQuery );
})
    </script>
</div>


<?php




}
function BMIAKC_admin_style() {
  wp_enqueue_style('BMCI_admin-styles',  plugin_dir_url(__FILE__).'admin/css/bmic_calc-admin.css',array(),23452345);
}
add_action('admin_enqueue_scripts', 'BMIAKC_admin_style');

function BMIAKC_enqueue_style() {
    wp_enqueue_style( 'BMCI_public-styles',  plugin_dir_url(__FILE__).'public/css/BMIC_calc-public.css' ,array(),23452351);
}
add_action( 'wp_enqueue_scripts', 'BMIAKC_enqueue_style' );