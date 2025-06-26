<?php

//Mortgage Calculator Widget
class luxus_mortgage_calculator extends WP_Widget {

	function __construct() {
		parent::__construct(
			'luxus_mortgage_calculator', // Base ID
			__('Mortgage Calcularor', 'luxus-core'), // Name
			array('description' => __('Displays Mortgage Calculator On Sidebar.', 'luxus-core'))
		);
	}

	function widget($args, $instance) { //output
		extract( $args );
		// these are the widget options
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		// Check if title is set
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		$this->luxus_mortgage_calculator_widget();
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}	
    
    // widget form creation
	function form($instance) {

	// Check values
	if( $instance) {
		$title = $instance['title'];
	} else {
		$title = '';
	}
	?>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title', 'luxus-core'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>		 
	<?php
	}
	
	function luxus_mortgage_calculator_widget() {

		$label_pprice = esc_html__('Purchase Price', 'luxus-core');
		$label_dprice = esc_html__('Down Payment', 'luxus-core');
		$label_percent = esc_html__('Percent (%)', 'luxus-core');
		$label_rate = esc_html__('Rate (%)', 'luxus-core');
		$label_term = esc_html__('Term', 'luxus-core');
		$label_years = esc_html__('Year(s)', 'luxus-core');
		$label_months = esc_html__('Month(s)', 'luxus-core');
		$label_button = esc_html__('Calculate', 'luxus-core');

		$currencysym = luxus_currency_symbol();
		$currency = esc_html__('Amount', 'luxus-core');
		$term = esc_html__('30', 'luxus-core');
		$principal = esc_html__('250,000', 'luxus-core');
		$dpamount = esc_html__('20%', 'luxus-core');
		$rate = esc_html__('6.5', 'luxus-core');
		$resulttext = esc_html__('Your monthly payment:', 'luxus-core');

		wp_register_script( 'jquery-homenote', '', array("jquery"), '', true );
		wp_enqueue_script( 'jquery-homenote'  );

		wp_add_inline_script( 'jquery-homenote', "
	        (function($){
				$.fn.homenote = function(options){

					var settings = $.extend({
						currencysym : '". $currencysym ."',
						currency : '". $currency ."',
						termtype : 'years', // years or months
						term : '". $term ."',
						principal : '". $principal ."',
						dptype : 'percentage', // percentage or downlump
						dpamount : '". $dpamount ."',
						rate : '". $rate ."',
						resulttext : '". $resulttext ."'
					}, options );
					options = $.extend(settings, options);

					// Change the term type between years and months
					$(document).on('change', 'input[name=\"termtype\"]', function(){
						settings.termtype = $(this).val();
						$('#term').val( convertTermLength() );
					});

					// Change the down type between lump sum and percentage
					$(document).on('change', 'input[name=\"dptype\"]', function(){
						settings.dptype = $(this).val();
						$('#dpamount').val( convertDownPayment() );
					});

					// Perform the calculation
					$(document).on('click', '#calchomenote', function(e){
						e.preventDefault();
						$('#results').hide()
							.html(settings.resulttext + ' <strong>' + settings.currencysym + calculate() + '</strong>')
							.show();
					});

					/**
					* Converts down between percentate and lump sum 
					*/
					function convertDownPayment()
					{
						var total = $('#purchasePrice').val().replace(/[^0-9\.]/g, '');
						var amount = $('#dpamount').val().replace(/[^0-9\.]/g, '');

						if ( settings.dptype === 'percentage' ){
							return (amount / total) * 100 + '%';
						} else {
							var perc = amount / 100;
							return total * perc;
						}
					}

					/**
					* Converts term between years and months
					*/
					function convertTermLength()
					{
						var term = $('#term').val();
						return ( $('input:radio[name=\"termtype\"]:checked').val() === 'months' ) ? term * 12 : term / 12;
					}

					/**
					* Returns total left on loan
					*/
					function amountLeft()
					{
						// Determine amount left on loan
						var type = $('input:radio[name=\"dptype\"]:checked').val();
						var total = $('#purchasePrice').val().replace(/[^0-9\.]/g, '');
						var down = $('#dpamount').val().replace(/[^0-9\.]/g, '');
						
						if ( type === 'percentage' ){
							var percentage =  down / 100;
							return total - (total * percentage);
						} else {
							return total - down;
						}
					}

					/**
					* Returns number of payments left
					*/
					function paymentsLeft()
					{
						var term = $('#term').val();
						return ( $('input:radio[name=\"termtype\"]:checked').val() === 'months' ) ? term : term * 12;
					}

					function calculate()
					{
						// Standard Mortgage Formula:
						// M = P[i(1+i)n] / [(1+i)n - 1]
						// x = (1+i)n

						var P = amountLeft();
						var i = ($('#rate').val().replace(/[^0-9\.]/g, '') / 100) / 12;
						var n = paymentsLeft();
						var x = Math.pow((1 + i ), n);
						var M = ( P * ((i * x) / (x - 1)) ).toFixed(2);
						return M;
					}

					function returnOutput()
					{
						// form to output
						var out = \"<form id='homenote' role='form'>\";

						// Purchase Price
						out += \"<label for='purchasePrice'>". $label_pprice ." (\" + settings.currencysym + \")</label>\";
						out += \"<input type='text' class='form-control' id='purchasePrice' value='\" + settings.principal + \"'>\";

						// Down Payment
						out += \"<label for='downPayment'>". $label_dprice ."</label><input type='text' class='form-control' id='dpamount' value='\" + settings.dpamount + \"'>\";

						// Down Payment Type - Percentage
						out += \"<label class='radio-inline mr-2'><input type='radio' name='dptype' id='downpercentage' value='percentage'\";
						if ( settings.dptype === 'percentage' ){ out += ' checked'; }
						out += \"><span class='label-text'>". $label_percent ."</span></label>\";

						// Down Payment Type - Lump Sum
						out += \"<label class='radio-inline'><input type='radio' name='dptype' id='downlump' value='downlump'\";
						if ( settings.dptype === 'downlump' ){ out += \" checked\"; }
						// out += \">\" + settings.currency + \" (\" + settings.currencysym + \")</label></div>\";
						out += \"><span class='label-text'>\" + settings.currency + \" (\" + settings.currencysym + \")</span></label>\";

						// Rate
						out += \"<label for='rate' class='rate-label'>". $label_rate ."</label><input type='text' class='form-control' id='rate' value='\" + settings.rate + \"'>\";

						// Term
						out += \"<label for='rate'>". $label_term ."</label><input type='text' class='form-control' id='term' value='\" + settings.term + \"'>\";

						// Term in Years
						out += \"<label class='radio-term mr-2'><input type='radio' name='termtype' id='years' value='years' \";
						if ( settings.termtype === 'years' ){ out += 'checked'; }
						out += \"><span class='label-text'>". $label_years ."</span></label>\";
						
						// Term in Months
						out += \"<label class='radio-term'><input type='radio' name='termtype' id='months' value='months'\";
						if ( settings.termtype === 'months' ){ out += 'checked'; }
						out += \"><span class='label-text'>". $label_months ."</span></label>\";

						// Resultss
						out += \"<div class='alert alert-success' style='display:none;' id='results'></div>\";
						
						// Submit Button
						out += \"<button type='submit' id='calchomenote' class='sl-btn-fill'>". $label_button ."</button></form>\";

						return out;
					}

					$(this).html(returnOutput());
				};
				
				$(document).ready(function(){
				    $('#calculator').homenote({});
				});

			})(jQuery);
	    ");

		echo '<div id="calculator"></div>';

	}
	
} //end class luxus_mortgage_calculator

// Registering Mortgage Calculator Widget
add_action( 'widgets_init', 'luxus_register_mortgage_calculator_widget' );
function luxus_register_mortgage_calculator_widget() {

	register_widget('luxus_mortgage_calculator');

}