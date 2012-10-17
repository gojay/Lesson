    <div class="lesson-banner-wrapper">
    
        <div id="jCarouselLiteDemo" class="cEnd">
          <div id="demo" class="cEnd tabs-container">  
            <div class="carousel default">
                <div class="rl-leftbtn">
		    <a href="#">
		    <img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/arrow-left.png" width="25" height="41" class="prev" border="0" />
		    </a>
		</div>
                <div class="rl-rightbtn">
		    <a href="#">
		    <img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/arrow-right.png" width="25" height="41" class="next" border="0" />
		    </a>
		</div>
                <div style="float:left;" class="jCarouselLite">
                    <ul style="margin: 0pt; padding: 0pt; position: relative; list-style-type: none; z-index: 1; width: 2890px; left: -2210px;">
                        <li style="overflow: hidden; float: left;">
                            <div class="lbanner-wrapper">
                                <div class="lbw-ad"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/ad01.jpg" width="243" height="65" /></div>
                                <div class="lbw-ad"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/ad02.jpg" width="243" height="65" /></div>
                                <div class="lbw-ad"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/ad03.jpg" width="243" height="65" /></div>
                                <div class="lbw-ad-last"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/ad04.jpg" width="243" height="65" /></div>
                                
                                <div class="lbw-ad"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/ad05.jpg" width="243" height="65" /></div>
                                <div class="lbw-ad"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/ad06.jpg" width="243" height="65" /></div>
                                <div class="lbw-ad"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/ad07.jpg" width="243" height="65" /></div>
                                <div class="lbw-ad-last"><img src="<?php echo AFR_LS_PLUGIN_URL ?>/js/jcarousel/ad08.jpg" width="243" height="65" /></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(".default .jCarouselLite").jCarouselLite({
                    auto: 4000,
                    speed: 500,
                    scroll: 1,
                    btnNext: ".default .next",
                    btnPrev: ".default .prev"
                });   
            </script>     
          </div>
        </div>
    
    </div>