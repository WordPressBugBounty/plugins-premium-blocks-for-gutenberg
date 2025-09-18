<?php

/**
 * Get Tabs Block CSS
 *
 * Return Frontend CSS for Tabs.
 *
 * @access public
 *
 * @param string $attr option attribute.
 * @param string $unique_id option For block ID.
 */
function get_premium_tabs_css_style( $attr, $unique_id ) {
	$css = new Premium_Blocks_css();

  $tabs_type = $css->pbg_get_value($attr, 'tabsTypes');
  $tabs_style = $css->pbg_get_value($attr, 'tabStyle');
  $title_tabs = $css->pbg_get_value($attr, 'titleTabs');
  $icon_position = $css->pbg_get_value($attr, 'iconPosition');

  $css->set_selector( $unique_id . ' .premium-tabs-nav .premium-tabs-nav-list' );
  $css->pbg_render_value($attr, 'menuAlign', 'justify-content', 'Desktop');

  $css->set_selector( "{$unique_id}:not(.premium-tabs-icon-column) .premium-tab-link" );
  $css->pbg_render_value($attr, 'tabsAlign', 'justify-content', 'Desktop');

  $css->set_selector( "{$unique_id}.premium-tabs-icon-column .premium-tab-link" );
  $css->pbg_render_value($attr, 'tabsAlign', 'align-items', 'Desktop');

  $css->set_selector( "{$unique_id}  .premium-tab-link .premium-tab-title-container" );
  $css->pbg_render_value($attr, 'tabsAlign', 'align-items', 'Desktop');
  if($icon_position === 'row-reverse'){
    $align_value = $css->pbg_get_value($attr, 'tabsAlign', 'Desktop');
    if($align_value === 'flex-start'){
      $css->add_property( 'align-items', 'flex-end');
    }elseif($align_value === 'flex-end'){
      $css->add_property( 'align-items', 'flex-start');
    }elseif($align_value === 'center'){
      $css->add_property( 'align-items', 'center');
    }
  }

  if($tabs_type === 'vertical'){
    $css->set_selector( "{$unique_id} .premium-content-wrap" );
    $css->pbg_render_value($attr, 'tabVerticalAlign', 'align-self', 'Desktop');
  }
  
  if($tabs_style === 'style2'){
    $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav li .active-line");
    $css->pbg_render_color($attr,  'bottomColor', 'background-color');

    $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav.horizontal li .active-line");
    $css->pbg_render_range($attr, 'circleSize', 'height', 'Desktop');
    $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav.vertical li .active-line");
    $css->pbg_render_range($attr, 'circleSize', 'width', 'Desktop');
  }

  $css->set_selector( $unique_id . '.premium-tabs-style-style3 ul.premium-tabs-horizontal li::after, ' . $unique_id . '.premium-tabs-style-style3 ul.premium-tabs-vertical li::after');
  $css->pbg_render_color($attr, 'sepColor', 'background-color');

  $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-tabs-nav" );
  $css->pbg_render_range($attr, 'tabsWidth', 'width', 'Desktop');
  
  $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-content-wrap" );
  $css->pbg_render_range($attr, 'tabsWidth', 'width', 'Desktop', 'calc(100% - ', ')');

  $css->set_selector( $unique_id  . ".premium-tabs-vertical " );
  $css->pbg_render_range($attr, 'tabGap', 'gap', 'Desktop');

  $css->set_selector( $unique_id  . ".premium-tabs-horizontal .premium-tabs-nav " );
  $css->pbg_render_range($attr, 'tabGap', 'margin-bottom', 'Desktop');

  $css->set_selector( $unique_id  . " .premium-tabs-nav ul li .premium-tab-link");
  $css->pbg_render_shadow($attr, 'tabShadow', 'filter', 'drop-shadow(', ')');
  $css->pbg_render_border($attr, 'tabBorder', 'Desktop');
  $css->pbg_render_background($attr, 'backColor', 'Desktop');
  $css->pbg_render_spacing($attr, 'tabPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'tabMargin', 'margin', 'Desktop');

  $css->set_selector( $unique_id  . " .premium-tabs-nav ul li.active .premium-tab-link");
  $css->pbg_render_shadow($attr, 'tabActiveShadow', 'filter', 'drop-shadow(', ')');
  $css->pbg_render_border($attr, 'tabActiveBorder', 'Desktop');
  $css->pbg_render_background($attr, 'BackActiveColor', 'Desktop');
  $css->pbg_render_spacing($attr, 'tabActivePadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'tabActiveMargin', 'margin', 'Desktop');

  $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:not(.active):hover .premium-tab-link");
  $css->pbg_render_shadow($attr, 'tabHoverShadow', 'filter', 'drop-shadow(', ')');
  $css->pbg_render_border($attr, 'tabBorderHover', 'Desktop');
  $css->pbg_render_background($attr, 'backHover', 'Desktop');
  $css->pbg_render_spacing($attr, 'tabHoverPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'tabHoverMargin', 'margin', 'Desktop');

  // Icon Styles
  if(is_array($title_tabs)){
    foreach ( $title_tabs as $index => $tab){
      $css->set_selector("{$unique_id} .premium-tabs-nav #premium-tabs__tab{$index} .premium-tab-link svg");
      $css->pbg_render_range($tab, 'iconSize', 'width', 'Desktop', null, '!important');
      $css->pbg_render_range($tab, 'iconSize', 'height', 'Desktop', null, '!important');

      $css->set_selector("{$unique_id} .premium-tabs-nav #premium-tabs__tab{$index} .premium-tab-link img");
      $css->pbg_render_range($tab, 'iconSize', 'width', 'Desktop', null, '!important');
    }
  }

  $css->set_selector(
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link img, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-lottie-animation svg"
  );
  $css->pbg_render_shadow($attr, 'iconShadow', 'filter', 'drop-shadow(', ')');
  $css->pbg_render_border($attr, 'iconBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Desktop");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Desktop');

  $css->set_selector( 
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg *, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconColor', 'color');
  $css->pbg_render_color($attr, 'iconColor', 'fill');

  $css->set_selector(
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-lottie-animation svg"
  );
  $css->pbg_render_color($attr, 'iconBackground', 'background-color');
  
  // Icon Hovering Styles
  $css->set_selector( 
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg *, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconHoverColor', 'color');
  $css->pbg_render_color($attr, 'iconHoverColor', 'fill');

  $css->set_selector(
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-lottie-animation svg"
  );
  $css->pbg_render_color($attr, 'iconHoverBackground', 'background-color');
  $css->pbg_render_border($attr, 'iconHoverBorder', 'Desktop');

  $css->set_selector("{$unique_id} .premium-tabs-nav li:hover .premium-tab-link img");
  $css->pbg_render_border($attr, 'iconHoverBorder', 'Desktop');

  // Icon Active Styles
  $css->set_selector( 
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg *, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg *"
  );
  $css->pbg_render_color($attr, 'iconActiveColor', 'color');
  $css->pbg_render_color($attr, 'iconActiveColor', 'fill');

  $css->set_selector(
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-lottie-animation svg"
  );
  $css->pbg_render_color($attr, 'iconActiveBackground', 'background-color');
  $css->pbg_render_border($attr, 'iconActiveBorder', 'Desktop');

  $css->set_selector("{$unique_id} .premium-tabs-nav li.active .premium-tab-link img");
  $css->pbg_render_border($attr, 'iconActiveBorder', 'Desktop');

  ///////////////////////////////////////////////// title Styling/////////////////////////////////////////////
  $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
  $css->pbg_render_shadow($attr, 'titleShadow', 'text-shadow');
  $css->pbg_render_color($attr, 'titleColor', 'color');
  $css->pbg_render_typography($attr, 'titleTypography', 'Desktop');
  $css->pbg_render_spacing($attr, 'titlePadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'titleMargin', 'margin', 'Desktop');
  $css->pbg_render_border($attr, 'titleBorder', 'Desktop');

  $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item:hover  .premium-tab-link .premium-tab-title-container .premium-tab-title");
  $css->pbg_render_color($attr, 'titleHoverColor', 'color');

  $css->set_selector( $unique_id  . " .active .premium-tab-title");
  $css->pbg_render_color($attr, 'titleActiveColor', 'color', null, '!important');

  ////////////////////////////////////////// Sub Title Styling/////////////////////////
  $css->set_selector( $unique_id . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
  $css->pbg_render_shadow($attr, 'subShadow', 'text-shadow');
  $css->pbg_render_color($attr, 'subColor', 'color');
  $css->pbg_render_typography($attr, 'subTypography', 'Desktop');
  $css->pbg_render_spacing($attr, 'subPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'subMargin', 'margin', 'Desktop');
  $css->pbg_render_border($attr, 'subBorder', 'Desktop');

  $css->set_selector( $unique_id . " .premium-tabs-nav-list-item:hover .premium-tab-link .premium-tab-title-container .premium-tab-desc");
  $css->pbg_render_color($attr, 'subHoverColor', 'color');

  $css->set_selector( $unique_id . " .active .premium-tab-desc");
  $css->pbg_render_color($attr, 'subActiveColor', 'color', null, '!important');

  /////////////////////////////// description Styling ////////////////////
  $css->set_selector( $unique_id . " .premium-tab-content");
  $css->pbg_render_color($attr, 'descBackColor', 'background-color');
  $css->pbg_render_shadow($attr, 'descBoxShadow', 'box-shadow');
  $css->pbg_render_border($attr, 'descBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'descPadding', 'padding', 'Desktop');
  $css->pbg_render_spacing($attr, 'descMargin', 'margin', 'Desktop');

  ///////////////////////////////////////Tabs Wrap ////////////////////////////
  if($tabs_style === 'style3'){
    $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
    $css->pbg_render_color($attr, 'wrapBackColor', 'background-color');
    $css->pbg_render_shadow($attr, 'wrapBoxShadow', 'box-shadow');
    $css->pbg_render_border($attr, 'wrapBorder', 'Desktop');
    $css->pbg_render_spacing($attr, 'wrapPadding', 'padding', 'Desktop');
    $css->pbg_render_spacing($attr, 'wrapMargin', 'margin', 'Desktop');
  }

  /////////////////////////////// container Style  ////////////////////////////////
  $css->set_selector( $unique_id );
  $css->pbg_render_color($attr, 'containerBackColor', 'background-color');
  $css->pbg_render_shadow($attr, 'containerBoxShadow', 'box-shadow');
  $css->pbg_render_border($attr, 'containerBorder', 'Desktop');
  $css->pbg_render_spacing($attr, 'containerPadding', 'padding', 'Desktop');

  $css->set_selector( "body .entry-content {$unique_id}.premium-tabs" );
  $css->pbg_render_spacing($attr, 'containerMargin', 'margin', 'Desktop');

  $css->start_media_query( 'tablet' );

  $css->set_selector( $unique_id . ' .premium-tabs-nav .premium-tabs-nav-list' );
  $css->pbg_render_value($attr, 'menuAlign', 'justify-content', 'Tablet');

  $css->set_selector( "{$unique_id}:not(.premium-tabs-icon-column) .premium-tab-link" );
  $css->pbg_render_value($attr, 'tabsAlign', 'justify-content', 'Tablet');

  $css->set_selector( "{$unique_id}.premium-tabs-icon-column .premium-tab-link" );
  $css->pbg_render_value($attr, 'tabsAlign', 'align-items', 'Tablet');

  $css->set_selector( "{$unique_id}  .premium-tab-link .premium-tab-title-container" );
  $css->pbg_render_value($attr, 'tabsAlign', 'align-items', 'Tablet');
  if($icon_position === 'row-reverse'){
    $align_value = $css->pbg_get_value($attr, 'tabsAlign', 'Tablet');
    if($align_value === 'flex-start'){
      $css->add_property( 'align-items', 'flex-end');
    }elseif($align_value === 'flex-end'){
      $css->add_property( 'align-items', 'flex-start');
    }elseif($align_value === 'center'){
      $css->add_property( 'align-items', 'center');
    }
  }

  if($tabs_type === 'vertical'){
    $css->set_selector( "{$unique_id} .premium-content-wrap" );
    $css->pbg_render_value($attr, 'tabVerticalAlign', 'align-self', 'Tablet');
  }

  if($tabs_style === 'style2'){
    $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav.horizontal li .active-line");
    $css->pbg_render_range($attr, 'circleSize', 'height', 'Tablet');
    $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav.vertical li .active-line");
    $css->pbg_render_range($attr, 'circleSize', 'width', 'Tablet');
  }
  
  $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-tabs-nav" );
  $css->pbg_render_range($attr, 'tabsWidth', 'width', 'Tablet');
  
  $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-content-wrap" );
  $css->pbg_render_range($attr, 'tabsWidth', 'width', 'Tablet', 'calc(100% - ', ')');

  $css->set_selector( $unique_id  . ".premium-tabs-vertical " );
  $css->pbg_render_range($attr, 'tabGap', 'gap', 'Tablet');

  $css->set_selector( $unique_id  . ".premium-tabs-horizontal .premium-tabs-nav " );
  $css->pbg_render_range($attr, 'tabGap', 'margin-bottom', 'Tablet');

  $css->set_selector( $unique_id  . " .premium-tabs-nav ul li .premium-tab-link");
  $css->pbg_render_border($attr, 'tabBorder', 'Tablet');
  $css->pbg_render_background($attr, 'backColor', 'Tablet');
  $css->pbg_render_spacing($attr, 'tabPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'tabMargin', 'margin', 'Tablet');

  $css->set_selector( $unique_id  . " .premium-tabs-nav ul li.active .premium-tab-link");
  $css->pbg_render_border($attr, 'tabActiveBorder', 'Tablet');
  $css->pbg_render_background($attr, 'BackActiveColor', 'Tablet');
  $css->pbg_render_spacing($attr, 'tabActivePadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'tabActiveMargin', 'margin', 'Tablet');

  $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:not(.active):hover .premium-tab-link");
  $css->pbg_render_border($attr, 'tabBorderHover', 'Tablet');
  $css->pbg_render_background($attr, 'backHover', 'Tablet');
  $css->pbg_render_spacing($attr, 'tabHoverPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'tabHoverMargin', 'margin', 'Tablet'); 
  
  // Icon Styles
  if(is_array($title_tabs)){
    foreach ( $title_tabs as $index => $tab){
      $css->set_selector("{$unique_id} .premium-tabs-nav #premium-tabs__tab{$index} .premium-tab-link svg");
      $css->pbg_render_range($tab, 'iconSize', 'width', 'Tablet', null, '!important');
      $css->pbg_render_range($tab, 'iconSize', 'height', 'Tablet', null, '!important');

      $css->set_selector("{$unique_id} .premium-tabs-nav #premium-tabs__tab{$index} .premium-tab-link img");
      $css->pbg_render_range($tab, 'iconSize', 'width', 'Tablet', null, '!important');
    }
  }

  $css->set_selector(
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link img, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Tablet");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Tablet');
  
  // Icon Hovering Styles
  $css->set_selector(
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-lottie-animation svg, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link img"
  );
  $css->pbg_render_border($attr, 'iconHoverBorder', 'Tablet');

  // Icon Active Styles
  $css->set_selector(
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-lottie-animation svg, " . 
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link img"
  );
  $css->pbg_render_border($attr, 'iconActiveBorder', 'Tablet');

  ///////////////////////////////////////////////// title Styling/////////////////////////////////////////////
  $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
  $css->pbg_render_typography($attr, 'titleTypography', 'Tablet');
  $css->pbg_render_spacing($attr, 'titlePadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'titleMargin', 'margin', 'Tablet');
  $css->pbg_render_border($attr, 'titleBorder', 'Tablet');   

  /////////////////////////////////// Sub Title Styling ///////////////////////////////
  $css->set_selector( $unique_id . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
  $css->pbg_render_typography($attr, 'subTypography', 'Tablet');
  $css->pbg_render_spacing($attr, 'subPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'subMargin', 'margin', 'Tablet');
  $css->pbg_render_border($attr, 'subBorder', 'Tablet');

  /////////////////////////////// description Styling ////////////////////
  $css->set_selector( $unique_id . " .premium-tab-content");
  $css->pbg_render_border($attr, 'descBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'descPadding', 'padding', 'Tablet');
  $css->pbg_render_spacing($attr, 'descMargin', 'margin', 'Tablet');

  ////////////////////////////////// Tabs Wrap /////////////////////////////////////
  if($tabs_style === 'style3'){
    $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
    $css->pbg_render_border($attr, 'wrapBorder', 'Tablet');
    $css->pbg_render_spacing($attr, 'wrapPadding', 'padding', 'Tablet');
    $css->pbg_render_spacing($attr, 'wrapMargin', 'margin', 'Tablet');
  }    
  /////////////////////////////// container Style  ////////////////////////////////
  $css->set_selector( $unique_id );
  $css->pbg_render_border($attr, 'containerBorder', 'Tablet');
  $css->pbg_render_spacing($attr, 'containerPadding', 'padding', 'Tablet');

  $css->set_selector( "body .entry-content {$unique_id}.premium-tabs" );
  $css->pbg_render_spacing($attr, 'containerMargin', 'margin', 'Tablet');

  $css->stop_media_query();
  $css->start_media_query( 'mobile' );

  $css->set_selector( $unique_id . ' .premium-tabs-nav .premium-tabs-nav-list' );
  $css->pbg_render_value($attr, 'menuAlign', 'justify-content', 'Mobile');

  $css->set_selector( "{$unique_id}:not(.premium-tabs-icon-column) .premium-tab-link" );
  $css->pbg_render_value($attr, 'tabsAlign', 'justify-content', 'Mobile');

  $css->set_selector( "{$unique_id}.premium-tabs-icon-column .premium-tab-link" );
  $css->pbg_render_value($attr, 'tabsAlign', 'align-items', 'Mobile');

  $css->set_selector( "{$unique_id}  .premium-tab-link .premium-tab-title-container" );
  $css->pbg_render_value($attr, 'tabsAlign', 'align-items', 'Mobile');
  if($icon_position === 'row-reverse'){
    $align_value = $css->pbg_get_value($attr, 'tabsAlign', 'Mobile');
    if($align_value === 'flex-start'){
      $css->add_property( 'align-items', 'flex-end');
    }elseif($align_value === 'flex-end'){
      $css->add_property( 'align-items', 'flex-start');
    }elseif($align_value === 'center'){
      $css->add_property( 'align-items', 'center');
    }
  }

  if($tabs_type === 'vertical'){
    $css->set_selector( "{$unique_id} .premium-content-wrap" );
    $css->pbg_render_value($attr, 'tabVerticalAlign', 'align-self', 'Mobile');
  }

  if($tabs_style === 'style2'){
    $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav.horizontal li .active-line");
    $css->pbg_render_range($attr, 'circleSize', 'height', 'Mobile');
    $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav.vertical li .active-line");
    $css->pbg_render_range($attr, 'circleSize', 'width', 'Mobile');
  }

  $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-tabs-nav" );
  $css->pbg_render_range($attr, 'tabsWidth', 'width', 'Mobile');
  
  $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-content-wrap" );
  $css->pbg_render_range($attr, 'tabsWidth', 'width', 'Mobile', 'calc(100% - ', ')');

  $css->set_selector( $unique_id  . ".premium-tabs-vertical " );
  $css->pbg_render_range($attr, 'tabGap', 'gap', 'Mobile');

  $css->set_selector( $unique_id  . ".premium-tabs-horizontal .premium-tabs-nav " );
  $css->pbg_render_range($attr, 'tabGap', 'margin-bottom', 'Mobile');

  $css->set_selector( $unique_id  . " .premium-tabs-nav ul li .premium-tab-link");
  $css->pbg_render_border($attr, 'tabBorder', 'Mobile');
  $css->pbg_render_background($attr, 'backColor', 'Mobile');
  $css->pbg_render_spacing($attr, 'tabPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'tabMargin', 'margin', 'Mobile');

  $css->set_selector( $unique_id  . " .premium-tabs-nav ul li.active .premium-tab-link");
  $css->pbg_render_border($attr, 'tabActiveBorder', 'Mobile');
  $css->pbg_render_background($attr, 'BackActiveColor', 'Mobile');
  $css->pbg_render_spacing($attr, 'tabActivePadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'tabActiveMargin', 'margin', 'Mobile');

  $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:not(.active):hover .premium-tab-link");
  $css->pbg_render_border($attr, 'tabBorderHover', 'Mobile');
  $css->pbg_render_background($attr, 'backHover', 'Mobile');
  $css->pbg_render_spacing($attr, 'tabHoverPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'tabHoverMargin', 'margin', 'Mobile'); 
  
  // Icon Styles
  if(is_array($title_tabs)){
    foreach ( $title_tabs as $index => $tab){
      $css->set_selector("{$unique_id} .premium-tabs-nav #premium-tabs__tab{$index} .premium-tab-link svg");
      $css->pbg_render_range($tab, 'iconSize', 'width', 'Mobile', null, '!important');
      $css->pbg_render_range($tab, 'iconSize', 'height', 'Mobile', null, '!important');

      $css->set_selector("{$unique_id} .premium-tabs-nav #premium-tabs__tab{$index} .premium-tab-link img");
      $css->pbg_render_range($tab, 'iconSize', 'width', 'Mobile', null, '!important');
    }
  }

  $css->set_selector(
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link img, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav .premium-tab-link .premium-lottie-animation svg"
  );
  $css->pbg_render_border($attr, 'iconBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'iconPadding', 'padding', "Mobile");
  $css->pbg_render_spacing($attr, 'iconMargin', 'margin', 'Mobile');
  
  // Icon Hovering Styles
  $css->set_selector(
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link .premium-lottie-animation svg, " .
    "{$unique_id} .premium-tabs-nav li:hover .premium-tab-link img"
  );
  $css->pbg_render_border($attr, 'iconHoverBorder', 'Mobile');

  // Icon Active Styles
  $css->set_selector(
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-icon-type, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg, " .
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link .premium-lottie-animation svg, " . 
    "{$unique_id} .premium-tabs-nav li.active .premium-tab-link img"
  );
  $css->pbg_render_border($attr, 'iconActiveBorder', 'Mobile');
      
  ///////////////////////////////////////////////// title Styling/////////////////////////////////////////////
  $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
  $css->pbg_render_typography($attr, 'titleTypography', 'Mobile');
  $css->pbg_render_spacing($attr, 'titlePadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'titleMargin', 'margin', 'Mobile');
  $css->pbg_render_border($attr, 'titleBorder', 'Mobile');          
    
  /////////////////////////////////// Sub Title Styling ///////////////////////////////
  $css->set_selector( $unique_id . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
  $css->pbg_render_typography($attr, 'subTypography', 'Mobile');
  $css->pbg_render_spacing($attr, 'subPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'subMargin', 'margin', 'Mobile');
  $css->pbg_render_border($attr, 'subBorder', 'Mobile');

  /////////////////////////////// description Styling ////////////////////
  $css->set_selector( $unique_id . " .premium-tab-content");
  $css->pbg_render_border($attr, 'descBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'descPadding', 'padding', 'Mobile');
  $css->pbg_render_spacing($attr, 'descMargin', 'margin', 'Mobile');
        
  ////////////////////////////////// Tabs Wrap /////////////////////////////////////
  if($tabs_style === 'style3'){
    $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
    $css->pbg_render_border($attr, 'wrapBorder', 'Mobile');
    $css->pbg_render_spacing($attr, 'wrapPadding', 'padding', 'Mobile');
    $css->pbg_render_spacing($attr, 'wrapMargin', 'margin', 'Mobile');
  }    

  /////////////////////////////// container Style  ////////////////////////////////
  $css->set_selector( $unique_id ); 
  $css->pbg_render_border($attr, 'containerBorder', 'Mobile');
  $css->pbg_render_spacing($attr, 'containerPadding', 'padding', 'Mobile');

  $css->set_selector( "body .entry-content {$unique_id}.premium-tabs" );
  $css->pbg_render_spacing($attr, 'containerMargin', 'margin', 'Mobile');
      
  $css->stop_media_query();
	return $css->css_output();
}

/**
 * Renders the `premium/tabs` block on server.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content    The saved content.
 * @param WP_Block $block      The parsed block.
 *
 * @return string Returns the post content with the legacy widget added.
 */

function render_block_pbg_tabs( $attributes, $content, $block ) {
	$block_helpers = pbg_blocks_helper();
	if ( $block_helpers->it_is_not_amp() ) {
			wp_enqueue_script(
				'pbg-tabs',
				PREMIUM_BLOCKS_URL . 'assets/js/minified/tabs.min.js',
				array(),
				PREMIUM_BLOCKS_VERSION,
				true
			);		
	}

  $media_query            = array();
  $media_query['mobile']  = apply_filters('Premium_BLocks_mobile_media_query', '(max-width: 767px)');
  $media_query['tablet']  = apply_filters('Premium_BLocks_tablet_media_query', '(max-width: 1024px)');
  $media_query['desktop'] = apply_filters('Premium_BLocks_desktop_media_query', '(min-width: 1025px)');

  $data = array(
    'breakPoints' => $media_query,
  );

  wp_scripts()->add_data('pbg-tabs', 'before', array());

  wp_add_inline_script(
      'pbg-tabs',
      'var PBG_TABS = ' . wp_json_encode($data) . ';',
      'before'
  );

  /* 
    Handling new feature of WordPress 6.7.2 --> sizes='auto' for old versions that doesn't contain wp-image-{$id} class.
    This workaround can be omitted after a few subsequent releases around 25/3/2025
  */
  if(isset($attributes['titleTabs']) && is_array($attributes['titleTabs'])){

    $image_tag =  new WP_HTML_Tag_Processor($content);

    foreach ($attributes['titleTabs'] as $index => $tab){
      // Check if this tab uses a lottie icon
      if (isset($tab['icon']['iconTypeSelect']) && $tab['icon']['iconTypeSelect'] === 'lottie') {
        wp_enqueue_script(
          'pbg-lottie',
          PREMIUM_BLOCKS_URL . 'assets/js/lib/lottie.min.js',
          array( 'jquery' ),
          PREMIUM_BLOCKS_VERSION,
          true
		  	);
      }

      // Skip if this tab doesn't use an image icon
      if (!isset($tab['icon']['iconTypeSelect']) || $tab['icon']['iconTypeSelect'] !== 'img') {
        continue;
      }
      
      // Skip if no image ID is provided
      if (empty($tab['icon']['imageID'])) {
        continue;
      }

      $image_id = $tab['icon']['imageID'];

      if (!$image_tag->next_tag(['tag_name' => 'img'])) {
        return $content;
      }  

      $image_classnames = $image_tag->get_attribute('class') ?? '';

      if (!str_contains($image_classnames, "wp-image-{$image_id}")) {
        // Clean up 
        $image_tag->remove_attribute('srcset');
        $image_tag->remove_attribute('sizes');
        $image_tag->remove_class('wp-image-undefined');
        
        // Add the wp-image class for automatically generate new srcset and sizes attributes
        $image_tag->add_class("wp-image-{$image_id}");
      }
    }

    return $image_tag->get_updated_html();
  }

  return $content;
}


/**
 * Register the Tabs block.
 *
 * @uses render_block_pbg_tabs()
 * @throws WP_Error An WP_Error exception parsing the block definition.
 */
function register_block_pbg_tabs() {
    if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	register_block_type(
		PREMIUM_BLOCKS_PATH . '/blocks-config/tabs',
		array(
			'render_callback' => 'render_block_pbg_tabs',
			
		)
	);
}

register_block_pbg_tabs();