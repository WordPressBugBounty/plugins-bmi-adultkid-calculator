<?php
if ( ! defined (  'WP_UNINSTALL_PLUGIN'  )  )  {  // константа визначена тільки в момент видалення плагіна 

    
    $lang_arr = explode(',',get_option('lang_bmi_calc'));
    
    foreach($lang_arr as $delete_lang){
	    delete_option('lang_bmi_calc' );
	    delete_option('lang_bmi_calc'.$delete_lang.'Title');
	    delete_option('lang_bmi_calc'.$delete_lang.'TitleDesc');
	    delete_option('lang_bmi_calc'.$delete_lang.'Height');
	    delete_option('lang_bmi_calc'.$delete_lang.'YourHeight');
	    delete_option('lang_bmi_calc'.$delete_lang.'Cm');
	    delete_option('lang_bmi_calc'.$delete_lang.'Weight');
	    delete_option('lang_bmi_calc'.$delete_lang.'YourWeight');
	    delete_option('lang_bmi_calc'.$delete_lang.'Kg');
	    delete_option('lang_bmi_calc'.$delete_lang.'HeightReg');
	    delete_option('lang_bmi_calc'.$delete_lang.'WeightReg');
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
	    delete_option('lang_bmi_calc'.$delete_lang.'You');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'YourHeight');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Cm');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'YourWeight');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Kg');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Age');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Year');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Month');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Gender');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Boy');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Girl');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'AgeReg');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'HeightReg');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'WeightReg');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Placeholder');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'BMI');
	    delete_option('kidlang_bmi_calc'.$delete_lang.'Category');
	}
	exit ;
}
?>