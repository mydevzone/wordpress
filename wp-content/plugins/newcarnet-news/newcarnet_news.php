<?php
/*
Plugin Name: NewCarNet News Widget
Plugin URI: http://www.newcarnet.co.uk/wordpress-widget.html
Description: Adds a sidebar widget to display selected news articles from a preselected manufacturer, such as Ferrari. 
Author: Toby Cox
Author URI: http://blog.eagerterrier.co.uk/
Version: 1.0

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
  
*/

class widget_newcarnet extends WP_Widget
{
	// declares the widget_newcarnet class
	function widget_newcarnet(){
		$widget_ops = array('classname' => 'widget_newcarnet', 'description' => __( "Displays selected manfacturer as a widget") );
		$this->WP_Widget('newcarnet', __('NewCarNet News'), $widget_ops);
	}
	
	// widget output
	function widget($args, $instance){
		extract($args);
	
		echo $before_widget;
		
		// omit title if not specified
		if ($instance['title'] != '')
			echo $before_title . $instance['title'] . $after_title;
		
		
		
		echo '<script type="text/javascript" src="http://www.newcarnet.co.uk/widget/news_widget.html?manufacturer='.$instance['manufacturer'].'&max='.$instance['max_count'].'"></script>';
		
		echo $after_widget;
	}
	
	
	// Creates the edit form for the widget.
	function form($instance){

		//Defaults
		$instance = wp_parse_args( (array) $instance, array('manufacturer' => '', 'max_count' => 5) );
		
		?>
		<p>
			<label><?php echo __('Title:') ?>
				<input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo htmlspecialchars($instance['title']) ?>" />
			</label>
		</p>
		<p>
			<?php echo __('Car Manufacturer:') ?><br>
			<label><?php echo __('Make: ') ?>
			<select id="<?php echo $this->get_field_id( 'manufacturer' ); ?>" name="<?php echo $this->get_field_name( 'manufacturer' ); ?>">		
				
				<option value=""<?php if ( '' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>All News</option>
				<option value="Abarth"<?php if ( 'Abarth' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Abarth</option>
				<option value="AC"<?php if ( 'AC' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>AC</option>
				<option value="Acura"<?php if ( 'Acura' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Acura</option>
				<option value="Alfa Romeo"<?php if ( 'Alfa Romeo' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Alfa Romeo</option>
				<option value="Alpina"<?php if ( 'Alpina' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Alpina</option>
				<option value="Alpine"<?php if ( 'Alpine' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Alpine</option>
				<option value="Alvis"<?php if ( 'Alvis' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Alvis</option>
				<option value="Antonov"<?php if ( 'Antonov' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Antonov</option>
				<option value="Ascari"<?php if ( 'Ascari' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Ascari</option>
				<option value="Aston Martin"<?php if ( 'Aston Martin' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Aston Martin</option>
				<option value="Auburn"<?php if ( 'Auburn' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Auburn</option>
				<option value="Audi"<?php if ( 'Audi' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Audi</option>
				<option value="Bentley"<?php if ( 'Bentley' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Bentley</option>
				<option value="Bertone"<?php if ( 'Bertone' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Bertone</option>
				<option value="BMW"<?php if ( 'BMW' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>BMW</option>
				<option value="Brilliance"<?php if ( 'Brilliance' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Brilliance</option>
				<option value="Bristol"<?php if ( 'Bristol' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Bristol</option>
				<option value="Bugatti"<?php if ( 'Bugatti' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Bugatti</option>
				<option value="Cadillac"<?php if ( 'Cadillac' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Cadillac</option>
				<option value="Caparo"<?php if ( 'Caparo' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Caparo</option>
				<option value="Caterham"<?php if ( 'Caterham' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Caterham</option>
				<option value="Chevrolet"<?php if ( 'Chevrolet' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Chevrolet</option>
				<option value="Chrysler"<?php if ( 'Chrysler' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Chrysler</option>
				<option value="Citroen"<?php if ( 'Citroen' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Citroen</option>
				<option value="Clive Sutton"<?php if ( 'Clive Sutton' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Clive Sutton</option>
				<option value="Connaught"<?php if ( 'Connaught' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Connaught</option>
				<option value="Corvette"<?php if ( 'Corvette' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Corvette</option>
				<option value="Dacia"<?php if ( 'Dacia' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Dacia</option>
				<option value="Daewoo"<?php if ( 'Daewoo' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Daewoo</option>
				<option value="Daihatsu"<?php if ( 'Daihatsu' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Daihatsu</option>
				<option value="DaimlerChrysler"<?php if ( 'DaimlerChrysler' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>DaimlerChrysler</option>
				<option value="DeLorean"<?php if ( 'DeLorean' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>DeLorean</option>
				<option value="DiMora"<?php if ( 'DiMora' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>DiMora</option>
				<option value="Dodge"<?php if ( 'Dodge' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Dodge</option>
				<option value="FBS"<?php if ( 'FBS' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>FBS</option>
				<option value="Ferrari"<?php if ( 'Ferrari' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Ferrari</option>
				<option value="Fiat"<?php if ( 'Fiat' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Fiat</option>
				<option value="Fisker"<?php if ( 'Fisker' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Fisker</option>
				<option value="Ford"<?php if ( 'Ford' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Ford</option>
				<option value="GM"<?php if ( 'GM' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>GM</option>
				<option value="GM Daewoo"<?php if ( 'GM Daewoo' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>GM Daewoo</option>
				<option value="GoinGreen"<?php if ( 'GoinGreen' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>GoinGreen</option>
				<option value="Gumpert"<?php if ( 'Gumpert' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Gumpert</option>
				<option value="Healey"<?php if ( 'Healey' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Healey</option>
				<option value="Hella"<?php if ( 'Hella' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Hella</option>
				<option value="Holden"<?php if ( 'Holden' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Holden</option>
				<option value="Honda"<?php if ( 'Honda' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Honda</option>
				<option value="Hummer"<?php if ( 'Hummer' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Hummer</option>
				<option value="Hyundai"<?php if ( 'Hyundai' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Hyundai</option>
				<option value="IFR"<?php if ( 'IFR' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>IFR</option>
				<option value="Infiniti"<?php if ( 'Infiniti' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Infiniti</option>
				<option value="Invicta"<?php if ( 'Invicta' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Invicta</option>
				<option value="Isuzu"<?php if ( 'Isuzu' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Isuzu</option>
				<option value="Jaguar"<?php if ( 'Jaguar' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Jaguar</option>
				<option value="Jeep"<?php if ( 'Jeep' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Jeep</option>
				<option value="Kia"<?php if ( 'Kia' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Kia</option>
				<option value="Koenigsegg"<?php if ( 'Koenigsegg' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Koenigsegg</option>
				<option value="KTM"<?php if ( 'KTM' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>KTM</option>
				<option value="Lada"<?php if ( 'Lada' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Lada</option>
				<option value="Lamborghini"<?php if ( 'Lamborghini' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Lamborghini</option>
				<option value="Lancia"<?php if ( 'Lancia' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Lancia</option>
				<option value="Land Rover"<?php if ( 'Land Rover' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Land Rover</option>
				<option value="Lexus"<?php if ( 'Lexus' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Lexus</option>
				<option value="Lotus"<?php if ( 'Lotus' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Lotus</option>
				<option value="Luxgen"<?php if ( 'Luxgen' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Luxgen</option>
				<option value="Marcos"<?php if ( 'Marcos' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Marcos</option>
				<option value="Maserati"<?php if ( 'Maserati' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Maserati</option>
				<option value="Maybach"<?php if ( 'Maybach' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Maybach</option>
				<option value="Mazda"<?php if ( 'Mazda' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Mazda</option>
				<option value="McLaren"<?php if ( 'McLaren' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>McLaren</option>
				<option value="MDI"<?php if ( 'MDI' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>MDI</option>
				<option value="Mercedes-Benz"<?php if ( 'Mercedes-Benz' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Mercedes-Benz</option>
				<option value="MG"<?php if ( 'MG' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>MG</option>
				<option value="MG Rover"<?php if ( 'MG Rover' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>MG Rover</option>
				<option value="Microsoft"<?php if ( 'Microsoft' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Microsoft</option>
				<option value="MINI"<?php if ( 'MINI' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>MINI</option>
				<option value="Mitsubishi"<?php if ( 'Mitsubishi' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Mitsubishi</option>
				<option value="Morgan"<?php if ( 'Morgan' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Morgan</option>
				<option value="Mosler"<?php if ( 'Mosler' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Mosler</option>
				<option value="NICE"<?php if ( 'NICE' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>NICE</option>
				<option value="Nissan"<?php if ( 'Nissan' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Nissan</option>
				<option value="Noble"<?php if ( 'Noble' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Noble</option>
				<option value="Pagani"<?php if ( 'Pagani' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Pagani</option>
				<option value="Perodua"<?php if ( 'Perodua' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Perodua</option>
				<option value="Peugeot"<?php if ( 'Peugeot' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Peugeot</option>
				<option value="Pininfarina"<?php if ( 'Pininfarina' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Pininfarina</option>
				<option value="Pontiac"<?php if ( 'Pontiac' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Pontiac</option>
				<option value="Porsche"<?php if ( 'Porsche' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Porsche</option>
				<option value="Proton"<?php if ( 'Proton' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Proton</option>
				<option value="Qvale"<?php if ( 'Qvale' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Qvale</option>
				<option value="Renault"<?php if ( 'Renault' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Renault</option>
				<option value="Reva Electric"<?php if ( 'Reva Electric' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Reva Electric</option>
				<option value="Rolls-Royce"<?php if ( 'Rolls-Royce' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Rolls-Royce</option>
				<option value="Rover"<?php if ( 'Rover' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Rover</option>
				<option value="Saab"<?php if ( 'Saab' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Saab</option>
				<option value="SEAT"<?php if ( 'SEAT' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>SEAT</option>
				<option value="Shelby"<?php if ( 'Shelby' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Shelby</option>
				<option value="Skoda"<?php if ( 'Skoda' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Skoda</option>
				<option value="smart"<?php if ( 'smart' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>smart</option>
				<option value="Spyker"<?php if ( 'Spyker' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Spyker</option>
				<option value="SsangYong"<?php if ( 'SsangYong' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>SsangYong</option>
				<option value="Subaru"<?php if ( 'Subaru' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Subaru</option>
				<option value="Suzuki"<?php if ( 'Suzuki' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Suzuki</option>
				<option value="Tata"<?php if ( 'Tata' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Tata</option>
				<option value="Tesla"<?php if ( 'Tesla' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Tesla</option>
				<option value="Think"<?php if ( 'Think' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Think</option>
				<option value="Toyota"<?php if ( 'Toyota' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Toyota</option>
				<option value="Trabant"<?php if ( 'Trabant' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Trabant</option>
				<option value="Trident"<?php if ( 'Trident' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Trident</option>
				<option value="TVR"<?php if ( 'TVR' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>TVR</option>
				<option value="Tygan"<?php if ( 'Tygan' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Tygan</option>
				<option value="Vauxhall"<?php if ( 'Vauxhall' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Vauxhall</option>
				<option value="Venture Vehicles"<?php if ( 'Venture Vehicles' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Venture Vehicles</option>
				<option value="Volkswagen"<?php if ( 'Volkswagen' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Volkswagen</option>
				<option value="Volvo"<?php if ( 'Volvo' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Volvo</option>
				<option value="Westfield"<?php if ( 'Westfield' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Westfield</option>
				<option value="Zolfe"<?php if ( 'Zolfe' == $instance['manufacturer'] ) echo ' selected="selected"'; ?>>Zolfe</option>

			</select>
		</p>
		<p>
			<label><?php echo __('Maximum number of posts: ') ?>
			<select id="<?php echo $this->get_field_id( 'max_count' ); ?>" name="<?php echo $this->get_field_name( 'max_count' ); ?>">
				<option value="5"<?php if ( 5 == $instance['max_count'] ) echo ' selected="selected"'; ?>>5</option>
				<option value="4"<?php if ( 4 == $instance['max_count'] ) echo ' selected="selected"'; ?>>4</option>
				<option value="3"<?php if ( 3 == $instance['max_count'] ) echo ' selected="selected"'; ?>>3</option>
			</select>
		</p>	
		
	<?php
	}
	
	
	// Saves the widgets settings.
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['manufacturer'] = ($new_instance['manufacturer'] != '') ? $new_instance['manufacturer'] : '';
		$instance['max_count'] = ($new_instance['max_count'] != '') ? (int) $new_instance['max_count'] : 5;
		
		return $instance;
	}
} // end class
	
// Register widget. Calls 'widgets_init' action after the widget has been registered.
function widget_newcarnet_init() {
	register_widget('widget_newcarnet');
}	
add_action('widgets_init', 'widget_newcarnet_init');

// shortcode for use outside widgets
function newcarnet_func( $atts ) {
	
	// defaults
	extract( shortcode_atts( array(
		'manufacturer' => '',
		'title' => '',
		'max_count' => 5,
		'width' => 300,
	), $atts ) );

	// holder
	$holder = '';
	
	

	$holder .= '<p class="newcarnet">';
			
	$holder .= '<script type="text/javascript" src="http://www.newcarnet.co.uk/widget/news_widget.html?manufacturer='.$manufacturer.'&max='.$max_count.'&width='.$width.'"></script>';
	
	$holder .= '</p>';

	return $holder;
}

add_shortcode( 'newcarnet', 'newcarnet_func' );





function newcarnet_admin() {

  if (function_exists('add_options_page')) {

    add_options_page('NewCarNet News' /* page title */, 
                     'NewCarNet News' /* menu title */, 
                     8 /* min. user level */, 
                     basename(__FILE__) /* php file */ , 
                     'newcarnet_options' /* function for subpanel */);
  }

}

function newcarnet_options() {
	
	?><div class="wrap">
			<h2>NewCarNet News</h2> 
				
			<div class="whitebg">
				<h3>NewCarNet News will pull in the latest news from the car manufacturer of your choice.</h3>
				<p>To use the widget, go to Appearance>Widgets and drag <i>NewCarNet News</i> into your sidebar. Currently it is set to display at 300px wide, although we will design more templates in the near future.</p>
				
				<h3>RoadMap</h3>
				<p>
					<ul>
						<li>More templates - choice of width</li>
						<li>Change look and feel of widget</li>
						<li>Add shortcode so you can add news article widget in your posts.</li>
						<li>Adding Videos.</li>
					<ul>
				</p>
				
				<h3>FAQs</h3>
				<p>
					<ul>
						<li><b>How often do your update content?</b> - We publish at least 3 news stories a day.</li>
						<li><b>How far back does your content go?</b> - Well over 10 years of content.</li>
						<li><b>Why are you giving your content away for free?</b> - After years of supplying the likes of MSN, Virgin, Tiscali et al with content, we realise that there are a lot of sites out there who would appreciate our content to hang off their site. Enjoy.</li>
						<li><b>Will this affect my Search Engine Ranking?</b> - No. The content is for your site's users only.</li>
						<li><b>Will this affect NewCarNet's Search Engine Ranking?</b> - No. Not until search engines start indexing JavaScript content.</li>
						<li><b>I don't like the links going off my site. Can I change this?</b> - No. Currently we offer the service to help make smaller sites look current and fresh. If you want our full content on your site, you will need to get in touch with our syndication department.</li>
					</ul>
				</p>
				
				<h3>Syndication</h3>
				<p>
					We offer a variety of syndication services and models for all our clients. Whether you want a handful for your Honda homepage, or a few for your Ferrari fanpage, please don't hesitate to get in touch with our syndication department:
				</p>
				<p>
					Call Massimo Pini on 020 7267 7002 or email <a href="mailto:editor@newcarnet.co.uk">editor@newcarnet.co.uk</a> to learn more.
				</p>
			</div>
	  </div>
	<?

}


// Adding Admin CSS
function newcarnet_admin_css() {
	echo "
	<style type='text/css'>
	.form-table				{ margin-bottom: 0 !important; }
	.form-table th			{ font-size: 11px; min-width: 200px; }
	.form-table .largetext	{ font-size: 12px; }
	.form-table td			{ max-width: 500px; }
	.form-table tr:last-child	{ border-bottom: 1px solid #DEDEDE; }
	.form-table tr:last-child td { padding-bottom: 20px; }
	.form-table select		{ width: 275px; }
	.whitebg { background-color:#ffffff;padding:42px 24px;}
	</style>
	";
}

function newcarnet_add_css(){
	wp_enqueue_style('newcarnet','http://www.newcarnet.co.uk/widget/styles/news.css');
}

add_filter('admin_head', 'newcarnet_admin_css');



// add NewCarNet Options page to the Option menu
add_filter('admin_menu', 'newcarnet_admin');

// add NewCarNet CSS file
add_filter('get_header', 'newcarnet_add_css');






?>