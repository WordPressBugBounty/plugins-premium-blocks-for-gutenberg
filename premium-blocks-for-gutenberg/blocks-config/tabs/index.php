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
    ////////////////////////////////////////////////// tab style //////////////////////////////////
    if(isset($attr['tabsAlign'])){
        $css->set_selector( "{$unique_id}:not(.premium-tabs-icon-column) .premium-tab-link" );
		$css->add_property( 'justify-content', $css->get_responsive_css( $attr['tabsAlign'], 'Desktop' ) );
        $css->set_selector( "{$unique_id}.premium-tabs-icon-column .premium-tab-link , {$unique_id}  .premium-tab-link .premium-tab-title-container" );
		$css->add_property( 'align-items', $css->render_string( $css->get_responsive_css( $attr['tabsAlign'], 'Desktop' ) , "!important") );
        $css->add_property( 'text-align', $css->render_text_align( $attr['tabsAlign'], 'Desktop' ));

    }
    if(isset($attr['tabVerticalAlign'])  && $attr['tabsTypes'] == "vertical"){
        $css->set_selector( "{$unique_id} .premium-content-wrap" );
		$css->add_property( 'align-self',  $css->get_responsive_css( $attr['tabVerticalAlign'], 'Desktop' )  );
    }
    if(isset($attr['circleSize']) && $attr['tabStyle'] == "style2"){
        $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav.horizontal li .active-line");
        $css->add_property( 'height', $css->render_range( $attr['circleSize'], 'Desktop' ));
        $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav.vertical li .active-line");

        $css->add_property( 'width', $css->render_range( $attr['circleSize'], 'Desktop' ));
    }

    if(isset($attr['bottomColor']) && $attr['tabStyle'] == "style2"){
        $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav li .active-line");
        $css->add_property( 'background-color', $css->render_color( $attr['bottomColor'] ));
    }
    if(isset($attr['sepColor'])){
        $css->set_selector( $unique_id  . ".premium-tabs-style-style2 ul.premium-tabs-horizontal li::after,  " .  $unique_id . '.premium-tabs-style-style2 ul.premium-tabs-vertical li::after , ' . $unique_id . '.premium-tabs-style-style3 ul.premium-tabs-horizontal li::after, ' . $unique_id . '.premium-tabs-style-style3 ul.premium-tabs-vertical li::after');
        $css->add_property( 'background-color', $css->render_color($attr['sepColor'] ) );  
    }
    if(isset($attr['tabsWidth'])){
        $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-tabs-nav" );
        $css->add_property( 'width', $css->render_range( $attr['tabsWidth'], 'Desktop' ));
        $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-content-wrap" );
        $css->add_property( 'width','calc(100% - ' .  $attr['tabsWidth'][ 'Desktop'] . '% )');
    }

    if(isset($attr['tabGap'])){
        $css->set_selector( $unique_id  . ".premium-tabs-vertical " );
        $css->add_property( 'gap', $css->render_range( $attr['tabGap'], 'Desktop' ));
        $css->set_selector( $unique_id  . ".premium-tabs-horizontal .premium-tabs-nav " );
        $css->add_property( "margin-bottom", $css->render_range( $attr['tabGap'], 'Desktop' ));
    }
  
    if ( isset( $attr['tabMargin'] ) ) {
        $tab_margin = $attr['tabMargin'];
        $css->set_selector( $unique_id  . "  li.premium-tabs-nav-list-item .premium-tab-link "  );
        $css->add_property( 'margin', $css->render_spacing( $tab_margin['Desktop'],  $tab_margin['unit']['Desktop']  ) );
    }
    if ( isset( $attr['tabPadding'] ) ) {
        $tab_padding = $attr['tabPadding'];
        $css->set_selector( $unique_id  . " li.premium-tabs-nav-list-item .premium-tab-link" );
        $css->add_property( 'padding', $css->render_spacing( $tab_padding['Desktop'],  $tab_padding['unit']['Desktop']  ) );
    }
    if ( isset( $attr['tabBorder'] )  ) {
        $border        = $attr['tabBorder'];

        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li .premium-tab-link" );
        $css->render_border( $border , 'Desktop' );

    }
    if ( isset( $attr['tabActiveBorder'] ) ) {
        $border        = $attr['tabActiveBorder'];

        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li.active .premium-tab-link" );
        $css->render_border( $border , 'Desktop' );

    }
   
    if ( isset( $attr['tabShadow'] )) {
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li .premium-tab-link  "  );
        $css->add_property( 'filter', 'drop-shadow('. $attr['tabShadow']['horizontal'] . 'px '. $attr['tabShadow']['vertical'] . 'px ' . $attr['tabShadow']['blur'] . 'px '. $attr['tabShadow']['color'] . ')' );
    }
    if ( isset( $attr['tabBorderHover'] )) {
        $border        = $attr['tabBorderHover'];

        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:hover .premium-tab-link "  );
        $css->render_border( $border , 'Desktop' );
    }
    if ( isset( $attr['tabHoverShadow'] )) {
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li .premium-tab-link:hover "  );
        $css->add_property( 'filter', 'drop-shadow('. $attr['tabHoverShadow']['horizontal'] . 'px '. $attr['tabHoverShadow']['vertical'] . 'px ' . $attr['tabHoverShadow']['blur'] . 'px '. $attr['tabHoverShadow']['color'] . ')' );
    }
    if ( isset( $attr['tabActiveShadow'] ) ) {
        $css->set_selector( $unique_id  . " .premium-tabs-nav li.active .premium-tab-link " );
        $css->add_property( 'filter', 'drop-shadow('. $attr['tabActiveShadow']['horizontal'] . 'px '. $attr['tabActiveShadow']['vertical'] . 'px ' . $attr['tabActiveShadow']['blur'] . 'px '. $attr['tabActiveShadow']['color'] . ')' );
    }
   
    if ( isset( $attr['tabActiveMargin'] ) ) {
        $tab_margin = $attr['tabActiveMargin'];
        $css->set_selector( $unique_id  . " .premium-tabs-nav li.active .premium-tab-link "  );
        $css->add_property( 'margin', $css->render_spacing( $tab_margin['Desktop'],  $tab_margin['unit']['Desktop']  ) );
    }
    if ( isset( $attr['tabActivePadding'] ) ) {
        $tab_padding = $attr['tabActivePadding'];
        $css->set_selector( $unique_id  . "  .premium-tabs-nav ul li.premium-tabs-nav-list-item:hover .premium-tab-link" );
        $css->add_property( 'padding', $css->render_spacing( $tab_padding['Desktop'],  $tab_padding['unit']['Desktop']  ) );
    }
  
    if ( isset( $attr['tabHoverMargin'] ) ) {
        $tab_margin = $attr['tabHoverMargin'];
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:hover  .premium-tab-link " );
        $css->add_property( 'margin', $css->render_spacing( $tab_margin['Desktop'],  $tab_margin['unit']['Desktop']  ) );
    }
    if ( isset( $attr['tabHoverPadding'] ) ) {
        $tab_padding = $attr['tabHoverPadding'];
        $css->set_selector( $unique_id  . "  .premium-tabs-nav ul li.premium-tabs-nav-list-item:hover .premium-tab-link" );
        $css->add_property( 'padding', $css->render_spacing( $tab_padding['Desktop'],  $tab_padding['unit']['Desktop']  ) );
    }

    if(isset($attr['backColor'])){
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li .premium-tab-link " );
		$css->render_background( $attr['backColor'], 'Desktop' );
    }
    if(isset($attr['BackActiveColor'])){
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li.active  .premium-tab-link " );
		$css->render_background( $attr['BackActiveColor'], 'Desktop' );
    }
    if(isset($attr['backHover'])){
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:not(.active):hover  .premium-tab-link " );
		$css->render_background( $attr['backHover'], 'Desktop' );
    }
    if ( isset( $attr['tabActiveShadow'] ) ) {
        $css->set_selector( $unique_id  . " .premium-tabs-style-style4 .premium-tabs-nav li.active" );
        $css->add_property( 'box-shadow', $css->render_shadow( $attr['tabActiveShadow'] ) );
    }
    ////////////////////////////////////////////icon style ///////////////////////////////////////////
    if(isset($attr['titleTabs'])){
        for ($x = 0; $x < count($attr['titleTabs']) ; $x++) {
            $css->set_selector( $unique_id  . " .premium-tabs-nav #premium-tabs__tab{$x} .premium-tab-link  svg , " .  $unique_id . ".premium-tabs-nav #premium-tabs__tab{$x} .premium-tab-link .premium-icon svg > * " );
            $css->add_property( 'width', $css->render_string( $css->render_range( $attr['titleTabs'][$x]['iconSize'], 'Desktop' ), '' ) );
    
            $css->add_property( 'height', $css->render_string( $css->render_range( $attr['titleTabs'][$x]['iconSize'], 'Desktop' ), '' ) );
            $css->set_selector(   $unique_id . "  .premium-tabs-nav #premium-tabs__tab{$x} .premium-tab-link > img " );
            $css->add_property( 'width', $css->render_string( $css->render_range( $attr['titleTabs'][$x]['iconSize'], 'Desktop' ), '' ) );
        } 
    }

    if(isset($attr['iconColor'])){
        $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-tab-link .premium-icon-type , " . $unique_id . '   .premium-tabs-nav li .premium-tab-link .premium-tabs-svg-class svg , ' . $unique_id  . "   .premium-tabs-nav .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg ," . $unique_id  . "  .premium-tabs-nav .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg > *" );
        $css->add_property( 'fill', $css->render_color($attr['iconColor'] ) );
        $css->add_property( 'color', $css->render_color($attr['iconColor'] ) );

    }

    if(isset($attr['iconActiveColor'])){
        $css->set_selector( $unique_id  . "  .premium-tabs-nav li.active .premium-tab-link .premium-icon-type , " . $unique_id . '   .premium-tabs-nav li.active .premium-tab-link .premium-tabs-svg-class svg ,  ' . $unique_id  . "   .premium-tabs-nav li.active .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg ," . $unique_id  . "  .premium-tabs-nav li.active .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg > *" );
        $css->add_property( 'fill', $css->render_color($attr['iconActiveColor'] ) );
        $css->add_property( 'color', $css->render_color($attr['iconActiveColor'] ) );
    }

    if(isset($attr['iconHoverColor'])){
        $css->set_selector( $unique_id  . "  .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type , " . $unique_id . '   .premium-tabs-nav li:hover .premium-tab-link .premium-tabs-svg-class svg ,' . $unique_id  . "   .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg ," . $unique_id  . "  .premium-tabs-nav li:hover .premium-tab-link .premium-icon-type:not(.icon-type-fe) svg > *" );
        $css->add_property( 'fill', $css->render_color($attr['iconHoverColor'] ) );
        $css->add_property( 'color', $css->render_color($attr['iconHoverColor'] ) );

    }

    if ( isset( $attr['iconMargin'] ) ) {
        $icon_margin = $attr['iconMargin'];
        $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link  .premium-tabs-svg-class , " . $unique_id . '  .premium-lottie-animation , ' . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link .premium-icon ," . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link img" );
        $css->add_property( 'margin', $css->render_spacing( $icon_margin['Desktop'],  $icon_margin['unit']['Desktop']  ) );
    }
    if ( isset( $attr['iconPadding'] ) ) {
        $icon_padding = $attr['iconPadding'];
        $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link  .premium-tabs-svg-class , " . $unique_id . '  .premium-lottie-animation , ' . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link .premium-icon ," . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link img" );
        $css->add_property( 'padding', $css->render_spacing( $icon_padding['Desktop'],  $icon_padding['unit']['Desktop']  ) );
    }
    if ( isset( $attr['iconBorder'] ) ) {
        $border        = $attr['iconBorder'];
       

        $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link  .premium-tabs-svg-class , " . $unique_id . '  .premium-lottie-animation , ' . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link .premium-icon ," . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link img" );
        $css->render_border( $border , 'Desktop' );

    }
    if ( isset( $attr['iconShadow'] ) ) {
        $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-icon, " . $unique_id . '  .premium-lottie-animation' );
        $css->add_property( 'box-shadow', $css->render_shadow( $attr['iconShadow'] ) );
    }


    ///////////////////////////////////////////////// title Styling/////////////////////////////////////////////
        if(isset($attr['titleColor'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->add_property( 'color', $css->render_color($attr['titleColor'] ) );
        }
        if(isset($attr['titleHoverColor'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item:hover  .premium-tab-link .premium-tab-title");
            $css->add_property( 'color', $css->render_color($attr['titleHoverColor'] ) );
        }
        if(isset($attr['titleActiveColor'])){
            $css->set_selector( $unique_id  . " .active .premium-tab-title");
            $css->add_property( 'color', $css->render_string( $css->render_color($attr['titleActiveColor'] ), "!important") );
        }

        if(isset($attr['titleTypography'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->render_typography( $attr['titleTypography'], 'Desktop' );
        }
        if ( isset( $attr['titleMargin'] ) ) {
            $title_margin = $attr['titleMargin'];
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->add_property( 'margin', $css->render_spacing( $title_margin['Desktop'],  $title_margin['unit']['Desktop']  ) );
        }
        if ( isset( $attr['titlePadding'] ) ) {
            $title_padding = $attr['titlePadding'];
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->add_property( 'padding', $css->render_spacing( $title_padding['Desktop'],  $title_padding['unit']['Desktop']  ) );
        }
        if ( isset( $attr['titleBorder'] ) ) {
            $border        = $attr['titleBorder'];
        

            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->render_border( $border , 'Desktop' );
        }
        if ( isset( $attr['titleShadow'] ) ) {
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->add_property( 'text-shadow', $css->render_shadow( $attr['titleShadow'] ) );
        }

        ////////////////////////////////////////// Sub Title Styling/////////////////////////

        if(isset($attr['subColor'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
            $css->add_property( 'color', $css->render_color($attr['subColor'] ) );
        }
        if(isset($attr['subHoverColor'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item:hover  .premium-tab-link .premium-tab-desc");
            $css->add_property( 'color', $css->render_color($attr['subHoverColor'] ) );
        }
        if(isset($attr['subActiveColor'])){
            $css->set_selector( $unique_id  . " .active .premium-tab-desc");
            $css->add_property( 'color', $css->render_string( $css->render_color($attr['subActiveColor'] ), "!important") );
        }

        if(isset($attr['subTypography'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
            $css->render_typography( $attr['subTypography'], 'Desktop' );
        }
        if ( isset( $attr['subMargin'] ) ) {
            $sub_margin = $attr['subMargin'];
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
            $css->add_property( 'margin', $css->render_spacing( $sub_margin['Desktop'],  $sub_margin['unit']['Desktop']  ) );
        }
        if ( isset( $attr['subPadding'] ) ) {
            $sub_padding = $attr['subPadding'];
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
            $css->add_property( 'padding', $css->render_spacing( $sub_padding['Desktop'],  $sub_padding['unit']['Desktop']  ) );
        }
        if ( isset( $attr['subBorder'] ) ) {
            $border        = $attr['subBorder'];
           

            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
            $css->render_border( $border , 'Desktop' );

        }
        if ( isset( $attr['subShadow'] ) ) {
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-desc");
            $css->add_property( 'text-shadow', $css->render_shadow( $attr['subShadow'] ) );
        }

        /////////////////////////////// description Styling ////////////////////

        if(isset($attr['descBackColor'])){
            $css->set_selector( $unique_id  . "  .premium-tab-content");
            $css->add_property( 'background-color', $css->render_color($attr['descBackColor'] ) );
        }
     
        if ( isset( $attr['descMargin'] ) ) {
            $desc_margin = $attr['descMargin'];
            $css->set_selector( $unique_id  . "  .premium-tab-content");
            $css->add_property( 'margin', $css->render_spacing( $desc_margin['Desktop'],  $desc_margin['unit']['Desktop']  ) );
        }
        if ( isset( $attr['descPadding'] ) ) {
            $desc_padding = $attr['descPadding'];
            $css->set_selector( $unique_id  . "  .premium-tab-content");
            $css->add_property( 'padding', $css->render_spacing( $desc_padding['Desktop'],  $desc_padding['unit']['Desktop']  ) );
        }
        if ( isset( $attr['descBorder'] ) ) {
            $border        = $attr['descBorder'];
        

            $css->set_selector( $unique_id  . "  .premium-tab-content");
            $css->render_border( $border , 'Desktop' );

        }
     
        if ( isset( $attr['descBoxShadow'] ) ) {
            $css->set_selector( $unique_id  . "  .premium-tab-content");
            $css->add_property( 'box-shadow', $css->render_shadow( $attr['descBoxShadow'] ) );
        }

        ///////////////////////////////////////Tabs Wrap ////////////////////////////

        if(isset($attr['wrapBackColor']) && $attr['tabStyle'] == "style3"){
            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list ");
            $css->add_property( 'background-color', $css->render_color($attr['wrapBackColor'] ) );
        }
        if ( isset( $attr['wrapMargin'] )&& $attr['tabStyle'] == "style3" ) {
            $wrap_margin = $attr['wrapMargin'];
            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->add_property( 'margin', $css->render_spacing( $wrap_margin['Desktop'],  $wrap_margin['unit']['Desktop']  ) );
        }
        if ( isset( $attr['wrapPadding'] ) && $attr['tabStyle'] == "style3") {
            $wrap_padding = $attr['wrapPadding'];
            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->add_property( 'padding', $css->render_spacing( $wrap_padding['Desktop'],  $wrap_padding['unit']['Desktop']  ) );
        }
        if ( isset( $attr['wrapBorder'] )&& $attr['tabStyle'] == "style3" ) {
            $border        = $attr['wrapBorder'];
        

            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->render_border( $border , 'Desktop' );

        }
      
        if ( isset( $attr['wrapBoxShadow'] )&& $attr['tabStyle'] == "style3" ) {
            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->add_property( 'box-shadow', $css->render_shadow( $attr['wrapBoxShadow'] ) );
        }
        /////////////////////////////// container Style  ////////////////////////////////
        if(isset($attr['containerBackColor'])){
            $css->set_selector( $unique_id  );
            $css->add_property( 'background-color', $css->render_color($attr['containerBackColor'] ) );
        }
         if ( isset( $attr['containerMargin'] ) ) {
            $container_margin = $attr['containerMargin'];
            $css->set_selector( $unique_id );
            $css->add_property( 'margin',$css->render_spacing( $container_margin['Desktop'],  $container_margin['unit']['Desktop']));
        }
        if ( isset( $attr['containerPadding'] ) ) {
            $container_padding = $attr['containerPadding'];
            $css->set_selector( $unique_id );
            $css->add_property( 'padding',$css->render_spacing( $container_padding['Desktop'],  $container_padding['unit']['Desktop']));
        }
        if ( isset( $attr['containerBorder'] ) ) {
            $border        = $attr['containerBorder'];
       

            $css->set_selector( $unique_id );
            $css->render_border( $border , 'Desktop' );
        }
        if ( isset( $attr['containerBoxShadow'] ) ) {
            $css->set_selector( $unique_id );
            $css->add_property( 'box-shadow', $css->render_shadow( $attr['containerBoxShadow'] ) );
        }



        $css->start_media_query( 'tablet' );


    if(isset($attr['tabsAlign'])){
        $css->set_selector( "{$unique_id}:not(.premium-tabs-icon-column) .premium-tab-link" );
        $css->add_property( 'justify-content', $css->get_responsive_css( $attr['tabsAlign'], 'Tablet' ) );
        $css->set_selector( "{$unique_id}.premium-tabs-icon-column .premium-tab-link , {$unique_id}  .premium-tab-link .premium-tab-title-container" );
        $css->add_property( 'align-items', $css->render_string( $css->get_responsive_css( $attr['tabsAlign'], 'Tablet' ) , "!important") );
        $css->add_property( 'text-align', $css->render_text_align( $attr['tabsAlign'], 'Tablet' ));

    }
    if(isset($attr['tabVerticalAlign'])  && $attr['tabsTypes'] == "vertical"){
        $css->set_selector( "{$unique_id} .premium-content-wrap" );
		$css->add_property( 'align-self',  $css->get_responsive_css( $attr['tabVerticalAlign'], 'Tablet' )  );
    }
    if(isset($attr['circleSize']) && $attr['tabStyle'] == "style2"){
        $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav li::before");
        $css->add_property( 'width', $css->render_range( $attr['circleSize'], 'Tablet' ));
        $css->add_property( 'height', $css->render_range( $attr['circleSize'], 'Tablet' ));
    }
    if(isset($attr['tabsWidth'])){
        $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-tabs-nav" );
        $css->add_property( 'width', $css->render_range( $attr['tabsWidth'], 'Tablet' ));
        $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-content-wrap" );
        $css->add_property( 'width','calc(100% - ' .  $attr['tabsWidth'][ 'Tablet'] . '% )');
    }

    if(isset($attr['tabGap'])){
        $css->set_selector( $unique_id  . ".premium-tabs-vertical " );
        $css->add_property( 'gap', $css->render_range( $attr['tabGap'], 'Tablet' ));
        $css->set_selector( $unique_id  . ".premium-tabs-horizontal .premium-tabs-nav " );
        $css->add_property( "margin-bottom", $css->render_range( $attr['tabGap'], 'Tablet' ));
    }
  
    if ( isset( $attr['tabMargin'] ) ) {
        $tab_margin = $attr['tabMargin'];
        $css->set_selector( $unique_id  . "  li.premium-tabs-nav-list-item .premium-tab-link, " . $unique_id . '.premium-tabs-style-style4 .premium-tabs-nav .premium-tabs-nav-list.premium-tabs-horizontal li:first-child .premium-tab-link' );
        $css->add_property( 'margin', $css->render_spacing( $tab_margin['Tablet'],  $tab_margin['unit']['Tablet']  ) );
    }
    if ( isset( $attr['tabPadding'] ) ) {
        $tab_padding = $attr['tabPadding'];
        $css->set_selector( $unique_id  . " li.premium-tabs-nav-list-item .premium-tab-link" );
        $css->add_property( 'padding', $css->render_spacing( $tab_padding['Tablet'],  $tab_padding['unit']['Tablet']  ) );
    }
    if ( isset( $attr['tabBorder'] )  &&  $attr['tabStyle'] !== "style4") {
        $border        = $attr['tabBorder'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];


        $css->set_selector( $unique_id  . ":not(.premium-tabs-style-style2) .premium-tabs-nav ul li .premium-tab-link, " . $unique_id . '.premium-tabs-style-style2 .premium-tabs-nav ul  li::before, '. $unique_id . '.premium-tabs-style-style4 .premium-tabs-nav ul li .premium-tab-link::after' );
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
      
    }
    if ( isset( $attr['tabActiveBorder'] ) ) {
        $border        = $attr['tabActiveBorder'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];

        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li.active .premium-tab-link" );
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
      
    }

    if ( isset( $attr['tabActiveMargin'] ) ) {
        $tab_margin = $attr['tabActiveMargin'];
        $css->set_selector( $unique_id  . " .premium-tabs-nav li.active .premium-tab-link, " . $unique_id . '.premium-tabs-style-style4 .premium-tabs-nav .premium-tabs-nav-list.premium-tabs-horizontal li.active:first-child .premium-tab-link' );
        $css->add_property( 'margin', $css->render_spacing( $tab_margin['Tablet'],  $tab_margin['unit']['Tablet']  ) );
    }
    if ( isset( $attr['tabActivePadding'] ) ) {
        $tab_padding = $attr['tabActivePadding'];
        $css->set_selector( $unique_id  . "  .premium-tabs-nav ul li.premium-tabs-nav-list-item:hover .premium-tab-link" );
        $css->add_property( 'padding', $css->render_spacing( $tab_padding['Tablet'],  $tab_padding['unit']['Tablet']  ) );
    }
    if ( isset( $attr['tabBorderHover'] )) {
        $border        = $attr['tabBorderHover'];

        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:hover .premium-tab-link "  );
        $css->render_border( $border , 'Tablet' );
    }
    if ( isset( $attr['tabHoverMargin'] ) ) {
        $tab_margin = $attr['tabHoverMargin'];
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:hover  .premium-tab-link, " . $unique_id . '.premium-tabs-style-style4 .premium-tabs-nav .premium-tabs-nav-list.premium-tabs-horizontal li:first-child:hover .premium-tab-link' );
        $css->add_property( 'margin', $css->render_spacing( $tab_margin['Tablet'],  $tab_margin['unit']['Tablet']  ) );
    }
    if ( isset( $attr['tabHoverPadding'] ) ) {
        $tab_padding = $attr['tabHoverPadding'];
        $css->set_selector( $unique_id  . "  .premium-tabs-nav ul li.premium-tabs-nav-list-item:hover .premium-tab-link" );
        $css->add_property( 'padding', $css->render_spacing( $tab_padding['Tablet'],  $tab_padding['unit']['Tablet']  ) );
    }
    if(isset($attr['backColor'])){
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li .premium-tab-link " );
		$css->render_background( $attr['backColor'], 'Tablet' );
    }
    if(isset($attr['BackActiveColor'])){
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li.active  .premium-tab-link " );
		$css->render_background( $attr['BackActiveColor'], 'Tablet' );
    }
    if(isset($attr['backHover'])){
        $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:not(.active):hover  .premium-tab-link " );
		$css->render_background( $attr['backHover'], 'Tablet' );
    }
 
    ////////////////////////////////////////////icon style ///////////////////////////////////////////
    if(isset($attr['titleTabs'])){
        for ($x = 0; $x < count($attr['titleTabs']) ; $x++) {
            $css->set_selector( $unique_id  . " .premium-tabs-nav #premium-tabs__tab{$x} .premium-tab-link  svg , " .  $unique_id . ".premium-tabs-nav #premium-tabs__tab{$x} .premium-tab-link .premium-icon svg > * "  );
            $css->add_property( 'width', $css->render_string( $css->render_range( $attr['titleTabs'][$x]['iconSize'], 'Tablet' ), '' ) );
            $css->add_property( 'height', $css->render_string( $css->render_range( $attr['titleTabs'][$x]['iconSize'], 'Tablet' ), '' ) );
            $css->set_selector(   $unique_id . "  .premium-tabs-nav #premium-tabs__tab{$x} .premium-tab-link > img " );
            $css->add_property( 'width', $css->render_string( $css->render_range( $attr['titleTabs'][$x]['iconSize'], 'Tablet' ), '' ) );

    
        } 
    }

   
    if ( isset( $attr['iconMargin'] ) ) {
        $icon_margin = $attr['iconMargin'];
        $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-icon, " . $unique_id . '  .premium-lottie-animation' );
        $css->add_property( 'margin', $css->render_spacing( $icon_margin['Tablet'],  $icon_margin['unit']['Tablet']  ) );
    }
    if ( isset( $attr['iconPadding'] ) ) {
        $icon_padding = $attr['iconPadding'];
        $css->set_selector( $unique_id  . "  .premium-tabs-nav li  .premium-tabs-svg-class , " . $unique_id . '  .premium-lottie-animation' );
        $css->add_property( 'padding', $css->render_spacing( $icon_padding['Tablet'],  $icon_padding['unit']['Tablet']  ) );
    }
    if ( isset( $attr['iconBorder'] ) ) {
        $border        = $attr['iconBorder'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];
        $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link  .premium-tabs-svg-class , " . $unique_id . '  .premium-lottie-animation , ' . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link .premium-icon ," . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link img" );
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
      
    }



    ///////////////////////////////////////////////// title Styling/////////////////////////////////////////////
     

        if(isset($attr['titleTypography'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->render_typography( $attr['titleTypography'], 'Tablet' );
        }
        if ( isset( $attr['titleMargin'] ) ) {
            $title_margin = $attr['titleMargin'];
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->add_property( 'margin', $css->render_spacing( $title_margin['Tablet'],  $title_margin['unit']['Tablet']  ) );
        }
        if ( isset( $attr['titlePadding'] ) ) {
            $title_padding = $attr['titlePadding'];
            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->add_property( 'padding', $css->render_spacing( $title_padding['Tablet'],  $title_padding['unit']['Tablet']  ) );
        }
        if ( isset( $attr['titleBorder'] ) ) {
            $border        = $attr['titleBorder'];
            $border_width  = $border['borderWidth'];
            $border_radius = $border['borderRadius'];


            $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
            $css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
            $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
           
        }
      /////////////////////////////////// Sub Title Styling ///////////////////////////////
      if(isset($attr['subTypography'])){
        $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item  .premium-tab-link .premium-tab-desc");
        $css->render_typography( $attr['subTypography'], 'Tablet' );
    }
    if ( isset( $attr['subMargin'] ) ) {
        $sub_margin = $attr['subMargin'];
        $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item  .premium-tab-link .premium-tab-desc");
        $css->add_property( 'margin', $css->render_spacing( $sub_margin['Tablet'],  $sub_margin['unit']['Tablet']  ) );
    }
    if ( isset( $attr['subPadding'] ) ) {
        $sub_padding = $attr['subPadding'];
        $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item  .premium-tab-link .premium-tab-desc");
        $css->add_property( 'padding', $css->render_spacing( $sub_padding['Tablet'],  $sub_padding['unit']['Tablet']  ) );
    }
    if ( isset( $attr['subBorder'] ) ) {
        $border        = $attr['subBorder'];
        $border_width  = $border['borderWidth'];
        $border_radius = $border['borderRadius'];


        $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item  .premium-tab-link .premium-tab-desc");
        $css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
        $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
       
    }

        /////////////////////////////// description Styling ////////////////////
      
        if ( isset( $attr['descMargin'] ) ) {
            $desc_margin = $attr['descMargin'];
            $css->set_selector( $unique_id  . "  .premium-tab-content");
            $css->add_property( 'margin', $css->render_spacing( $desc_margin['Tablet'],  $desc_margin['unit']['Tablet']  ) );
        }
        if ( isset( $attr['descPadding'] ) ) {
            $desc_padding = $attr['descPadding'];
            $css->set_selector( $unique_id  . "  .premium-tab-content");
            $css->add_property( 'padding', $css->render_spacing( $desc_padding['Tablet'],  $desc_padding['unit']['Tablet']  ) );
        }
        if ( isset( $attr['descBorder'] ) ) {
            $border        = $attr['descBorder'];
            $border_width  = $border['borderWidth'];
            $border_radius = $border['borderRadius'];


            $css->set_selector( $unique_id  . "  .premium-tab-content");
            $css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
            $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
           
        }
        ////////////////////////////////// Tabs Wrap /////////////////////////////////////
        if ( isset( $attr['wrapMargin'] )  && $attr['tabStyle'] == "style3") {
            $wrap_margin = $attr['wrapMargin'];
            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->add_property( 'margin', $css->render_spacing( $wrap_margin['Tablet'],  $wrap_margin['unit']['Tablet']  ) );
        }
        if ( isset( $attr['wrapPadding'] )&& $attr['tabStyle'] == "style3" ) {
            $wrap_padding = $attr['wrapPadding'];
            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->add_property( 'padding', $css->render_spacing( $wrap_padding['Tablet'],  $wrap_padding['unit']['Tablet']  ) );
        }
        if ( isset( $attr['wrapBorder'] )&& $attr['tabStyle'] == "style3" ) {
            $border        = $attr['wrapBorder'];
            $border_width  = $border['borderWidth'];
            $border_radius = $border['borderRadius'];

            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->add_property( 'border-width', $css->render_spacing( $border_width['Tablet'], 'px' ) );
            $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Tablet'], 'px' ) );
           
        }

    
        /////////////////////////////// container Style  ////////////////////////////////
   
         if ( isset( $attr['containerMargin'] ) ) {
            $container_margin = $attr['containerMargin'];
            $css->set_selector( $unique_id );
            $css->add_property( 'margin', $css->render_spacing( $container_margin['Tablet'],  $container_margin['unit']['Tablet']));
        }
        if ( isset( $attr['containerPadding'] ) ) {
            $container_padding = $attr['containerPadding'];
            $css->set_selector( $unique_id );
            $css->add_property( 'padding', $css->render_spacing( $container_padding['Tablet'],  $container_padding['unit']['Tablet']));
        }
        if ( isset( $attr['containerBorder'] ) ) {
            $border        = $attr['containerBorder'];
            $border_width  = $border['borderWidth'];
            $border_radius = $border['borderRadius'];

            $css->set_selector( $unique_id );
            $css->add_property( 'border-width',$css->render_string( $css->render_spacing( $border_width['Tablet'], 'px' )," !important") );
            $css->add_property( 'border-radius',$css->render_string( $css->render_spacing( $border_radius['Tablet'], 'px' )," !important") );
            
        }
        


        $css->stop_media_query();

        $css->start_media_query( 'mobile' );

        if(isset($attr['tabVerticalAlign'])  && $attr['tabsTypes'] == "vertical"){
            $css->set_selector( "{$unique_id} .premium-content-wrap" );
            $css->add_property( 'align-self',  $css->get_responsive_css( $attr['tabVerticalAlign'], 'Mobile' )  );
        }
        if(isset($attr['tabsAlign'])){
            $css->set_selector( "{$unique_id}:not(.premium-tabs-icon-column) .premium-tab-link" );
            $css->add_property( 'justify-content', $css->get_responsive_css( $attr['tabsAlign'], 'Mobile' ) );
            $css->set_selector( "{$unique_id}.premium-tabs-icon-column .premium-tab-link , {$unique_id}  .premium-tab-link .premium-tab-title-container" );
            $css->add_property( 'align-items', $css->render_string( $css->get_responsive_css( $attr['tabsAlign'], 'Mobile' ) , "!important") );
            $css->add_property( 'text-align', $css->render_text_align( $attr['tabsAlign'], 'Mobile' ));

        }

        if(isset($attr['circleSize']) && $attr['tabStyle'] == "style2"){
            $css->set_selector( $unique_id  . ".premium-tabs-style-style2 .premium-tabs-nav li::before");
            $css->add_property( 'width', $css->render_range( $attr['circleSize'], 'Mobile' ));
            $css->add_property( 'height', $css->render_range( $attr['circleSize'], 'Mobile' ));
        }

        if(isset($attr['tabsWidth'])){
            $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-tabs-nav" );
            $css->add_property( 'width', $css->render_range( $attr['tabsWidth'], 'Mobile' ));
            $css->set_selector( $unique_id  . ".premium-tabs-vertical .premium-content-wrap" );
            $css->add_property( 'width','calc(100% - ' .  $attr['tabsWidth'][ 'Mobile'] . '% )');
        }
    
        if(isset($attr['tabGap'])){
            $css->set_selector( $unique_id  . ".premium-tabs-vertical " );
            $css->add_property( 'gap', $css->render_range( $attr['tabGap'], 'Mobile' ));
            $css->set_selector( $unique_id  . ".premium-tabs-horizontal .premium-tabs-nav " );
            $css->add_property( "margin-bottom", $css->render_range( $attr['tabGap'], 'Mobile' ));
        }
     
        if ( isset( $attr['tabMargin'] ) ) {
            $tab_margin = $attr['tabMargin'];
            $css->set_selector( $unique_id  . "  li.premium-tabs-nav-list-item .premium-tab-link, " . $unique_id . '.premium-tabs-style-style4 .premium-tabs-nav .premium-tabs-nav-list.premium-tabs-horizontal li:first-child .premium-tab-link' );
            $css->add_property( 'margin', $css->render_spacing( $tab_margin['Mobile'],  $tab_margin['unit']['Mobile']  ) );
        }
        if ( isset( $attr['tabPadding'] ) ) {
            $tab_padding = $attr['tabPadding'];
            $css->set_selector( $unique_id  . " li.premium-tabs-nav-list-item .premium-tab-link" );
            $css->add_property( 'padding', $css->render_spacing( $tab_padding['Mobile'],  $tab_padding['unit']['Mobile']  ) );
        }
        if ( isset( $attr['tabBorder'] )  &&  $attr['tabStyle'] !== "style4") {
            $border        = $attr['tabBorder'];
            $border_width  = $border['borderWidth'];
            $border_radius = $border['borderRadius'];
    
            $css->set_selector( $unique_id  . ":not(.premium-tabs-style-style2) .premium-tabs-nav ul li .premium-tab-link, " . $unique_id . '.premium-tabs-style-style2 .premium-tabs-nav ul  li::before, '. $unique_id . '.premium-tabs-style-style4 .premium-tabs-nav ul li .premium-tab-link::after' );
            $css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
            $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
          
        }
        if ( isset( $attr['tabActiveBorder'] ) ) {
            $border        = $attr['tabActiveBorder'];
            $border_width  = $border['borderWidth'];
            $border_radius = $border['borderRadius'];
    
            $css->set_selector( $unique_id  . " .premium-tabs-nav ul li.active .premium-tab-link" );
            $css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
            $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
           
        }
    
        if ( isset( $attr['tabActiveMargin'] ) ) {
            $tab_margin = $attr['tabActiveMargin'];
            $css->set_selector( $unique_id  . " .premium-tabs-nav li.active .premium-tab-link, " . $unique_id . '.premium-tabs-style-style4 .premium-tabs-nav .premium-tabs-nav-list.premium-tabs-horizontal li.active:first-child .premium-tab-link' );
            $css->add_property( 'margin', $css->render_spacing( $tab_margin['Mobile'],  $tab_margin['unit']['Mobile']  ) );
        }
        if ( isset( $attr['tabActivePadding'] ) ) {
            $tab_padding = $attr['tabActivePadding'];
            $css->set_selector( $unique_id  . "  .premium-tabs-nav ul li.premium-tabs-nav-list-item:hover .premium-tab-link" );
            $css->add_property( 'padding', $css->render_spacing( $tab_padding['Mobile'],  $tab_padding['unit']['Mobile']  ) );
        }
      
        if ( isset( $attr['tabBorderHover'] )) {
            $border        = $attr['tabBorderHover'];
    
            $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:hover .premium-tab-link "  );
            $css->render_border( $border , 'Mobile' );
        }
        if ( isset( $attr['tabHoverMargin'] ) ) {
            $tab_margin = $attr['tabHoverMargin'];
            $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:hover  .premium-tab-link, " . $unique_id . '.premium-tabs-style-style4 .premium-tabs-nav .premium-tabs-nav-list.premium-tabs-horizontal li:first-child:hover .premium-tab-link' );
            $css->add_property( 'margin', $css->render_spacing( $tab_margin['Mobile'],  $tab_margin['unit']['Mobile']  ) );
        }
        if ( isset( $attr['tabHoverPadding'] ) ) {
            $tab_padding = $attr['tabHoverPadding'];
            $css->set_selector( $unique_id  . "  .premium-tabs-nav ul li.premium-tabs-nav-list-item:hover .premium-tab-link" );
            $css->add_property( 'padding', $css->render_spacing( $tab_padding['Mobile'],  $tab_padding['unit']['Mobile']  ) );
        }

        if(isset($attr['backColor'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav ul li .premium-tab-link " );
            $css->render_background( $attr['backColor'], 'Mobile' );
        }
        if(isset($attr['BackActiveColor'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav ul li.active  .premium-tab-link " );
            $css->render_background( $attr['BackActiveColor'], 'Mobile' );
        }
        if(isset($attr['backHover'])){
            $css->set_selector( $unique_id  . " .premium-tabs-nav ul li:not(.active):hover  .premium-tab-link " );
            $css->render_background( $attr['backHover'], 'Mobile' );
        }
     
        ////////////////////////////////////////////icon style ///////////////////////////////////////////
        if(isset($attr['titleTabs'])){
            for ($x = 0; $x < count($attr['titleTabs']) ; $x++) {
                $css->set_selector( $unique_id  . " .premium-tabs-nav #premium-tabs__tab{$x} .premium-tab-link  svg , " .  $unique_id . ".premium-tabs-nav #premium-tabs__tab{$x} .premium-tab-link .premium-icon svg > * "  );
                $css->add_property( 'width', $css->render_string( $css->render_range( $attr['titleTabs'][$x]['iconSize'], 'Mobile' ), '' ) );
                $css->add_property( 'height', $css->render_string( $css->render_range( $attr['titleTabs'][$x]['iconSize'], 'Mobile' ), '' ) );

                $css->set_selector(   $unique_id . "  .premium-tabs-nav #premium-tabs__tab{$x} .premium-tab-link > img " );
                $css->add_property( 'width', $css->render_string( $css->render_range( $attr['titleTabs'][$x]['iconSize'], 'Mobile' ), '' ) );
            } 
        }
    
       
        if ( isset( $attr['iconMargin'] ) ) {
            $icon_margin = $attr['iconMargin'];
            $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-icon, " . $unique_id . '  .premium-lottie-animation' );
            $css->add_property( 'margin', $css->render_spacing( $icon_margin['Mobile'],  $icon_margin['unit']['Mobile']  ) );
        }
        if ( isset( $attr['iconPadding'] ) ) {
            $icon_padding = $attr['iconPadding'];
            $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-icon, " . $unique_id . '  .premium-lottie-animation' );
            $css->add_property( 'padding', $css->render_spacing( $icon_padding['Mobile'],  $icon_padding['unit']['Mobile']  ) );
        }
        if ( isset( $attr['iconBorder'] ) ) {
            $border        = $attr['iconBorder'];
            $border_width  = $border['borderWidth'];
            $border_radius = $border['borderRadius'];
    
            $css->set_selector( $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link  .premium-tabs-svg-class , " . $unique_id . '  .premium-lottie-animation , ' . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link .premium-icon ," . $unique_id  . "  .premium-tabs-nav .premium-tabs-nav-list li .premium-tab-link img" );
            $css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
            $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
          
        }
    
    
    
        ///////////////////////////////////////////////// title Styling/////////////////////////////////////////////
         
    
            if(isset($attr['titleTypography'])){
                $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
                $css->render_typography( $attr['titleTypography'], 'Mobile' );
            }
            if ( isset( $attr['titleMargin'] ) ) {
                $title_margin = $attr['titleMargin'];
                $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
                $css->add_property( 'margin', $css->render_spacing( $title_margin['Mobile'],  $title_margin['unit']['Mobile']  ) );
            }
            if ( isset( $attr['titlePadding'] ) ) {
                $title_padding = $attr['titlePadding'];
                $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
                $css->add_property( 'padding', $css->render_spacing( $title_padding['Mobile'],  $title_padding['unit']['Mobile']  ) );
            }
            if ( isset( $attr['titleBorder'] ) ) {
                $border        = $attr['titleBorder'];
                $border_width  = $border['borderWidth'];
                $border_radius = $border['borderRadius'];
    
                $css->set_selector( $unique_id  . " .premium-tabs-nav .premium-tab-link .premium-tab-title-container .premium-tab-title");
                $css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
                $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
               
            }

                  /////////////////////////////////// Sub Title Styling ///////////////////////////////
            if(isset($attr['subTypography'])){
                $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item  .premium-tab-link .premium-tab-desc");
                $css->render_typography( $attr['subTypography'], 'Mobile' );
            }
            if ( isset( $attr['subMargin'] ) ) {
                $sub_margin = $attr['subMargin'];
                $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item  .premium-tab-link .premium-tab-desc");
                $css->add_property( 'margin', $css->render_spacing( $sub_margin['Mobile'],  $sub_margin['unit']['Mobile']  ) );
            }
            if ( isset( $attr['subPadding'] ) ) {
                $sub_padding = $attr['subPadding'];
                $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item  .premium-tab-link .premium-tab-desc");
                $css->add_property( 'padding', $css->render_spacing( $sub_padding['Mobile'],  $sub_padding['unit']['Mobile']  ) );
            }
            if ( isset( $attr['subBorder'] ) ) {
                $border        = $attr['subBorder'];
                $border_width  = $border['borderWidth'];
                $border_radius = $border['borderRadius'];

                $css->set_selector( $unique_id  . " .premium-tabs-nav-list-item  .premium-tab-link .premium-tab-desc");
                $css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
                $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
            
            }
          
            /////////////////////////////// description Styling ////////////////////
     
            if ( isset( $attr['descMargin'] ) ) {
                $desc_margin = $attr['descMargin'];
                $css->set_selector( $unique_id  . "  .premium-tab-content");
                $css->add_property( 'margin', $css->render_spacing( $desc_margin['Mobile'],  $desc_margin['unit']['Mobile']  ) );
            }
            if ( isset( $attr['descPadding'] ) ) {
                $desc_padding = $attr['descPadding'];
                $css->set_selector( $unique_id  . "  .premium-tab-content");
                $css->add_property( 'padding', $css->render_spacing( $desc_padding['Mobile'],  $desc_padding['unit']['Mobile']  ) );

            }
            if ( isset( $attr['descBorder'] ) ) {
                $border        = $attr['descBorder'];
                $border_width  = $border['borderWidth'];
                $border_radius = $border['borderRadius'];
    
                $css->set_selector( $unique_id  . "  .premium-tab-content");
                $css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
                $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
               
            }
        
               ////////////////////////////////// Tabs Wrap /////////////////////////////////////
        if ( isset( $attr['wrapMargin'] ) && $attr['tabStyle'] == "style3" ) {
            $wrap_margin = $attr['wrapMargin'];
            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->add_property( 'margin', $css->render_spacing( $wrap_margin['Mobile'],  $wrap_margin['unit']['Mobile']  ) );
        }
        if ( isset( $attr['wrapPadding'] ) && $attr['tabStyle'] == "style3") {
            $wrap_padding = $attr['wrapPadding'];
            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->add_property( 'padding', $css->render_spacing( $wrap_padding['Mobile'],  $wrap_padding['unit']['Mobile']  ) );
        }
        if ( isset( $attr['wrapBorder'] )&& $attr['tabStyle'] == "style3" ) {
            $border        = $attr['wrapBorder'];
            $border_width  = $border['borderWidth'];
            $border_radius = $border['borderRadius'];

            $css->set_selector( $unique_id  . ".premium-tabs-style-style3 .premium-tabs-nav ul.premium-tabs-nav-list");
            $css->add_property( 'border-width', $css->render_spacing( $border_width['Mobile'], 'px' ) );
            $css->add_property( 'border-radius', $css->render_spacing( $border_radius['Mobile'], 'px' ) );
           
        }
            /////////////////////////////// container Style  ////////////////////////////////
       
             if ( isset( $attr['containerMargin'] ) ) {
                $container_margin = $attr['containerMargin'];
                $css->set_selector( $unique_id );
                $css->add_property( 'margin', $css->render_spacing( $container_margin['Mobile'],  $container_margin['unit']['Mobile']));
            }
            if ( isset( $attr['containerPadding'] ) ) {
                $container_padding = $attr['containerPadding'];
                $css->set_selector( $unique_id );
                $css->add_property( 'padding', $css->render_spacing( $container_padding['Mobile'],  $container_padding['unit']['Mobile']));
            }
            if ( isset( $attr['containerBorder'] ) ) {
                $border        = $attr['containerBorder'];
                $border_width  = $border['borderWidth'];
                $border_radius = $border['borderRadius'];
    
                $css->set_selector( $unique_id );
                $css->add_property( 'border-width',$css->render_string( $css->render_spacing( $border_width['Mobile'], 'px' )," !important") );
                $css->add_property( 'border-radius',$css->render_string( $css->render_spacing( $border_radius['Mobile'], 'px' )," !important") );
                
            }
            
    

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
				'pbg-lottie',
				PREMIUM_BLOCKS_URL . 'assets/js/minified/lottie.min.js',
				array( 'jquery' ),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		
	}

	if ( $block_helpers->it_is_not_amp() ) {

			wp_enqueue_script(
				'pbg-tabs',
				PREMIUM_BLOCKS_URL . 'assets/js/minified/tabs.min.js',
				array( 'jquery' ),
				PREMIUM_BLOCKS_VERSION,
				true
			);
		
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