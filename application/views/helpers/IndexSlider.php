<?php

class Zend_View_Helper_IndexSlider extends Zend_View_Helper_Abstract
{
	public function indexSlider() { ?>
            <!--slider starts-->
            <div id="slider"> 
                <div id="layerslider_4" class="ls-wp-container" style="width:100%;height:610px;max-width:1920px;margin:0 auto;margin-bottom: 0px;">
                    <div class="ls-slide" data-ls="slidedelay:10000; transition2d: all;">
                        <img src="img/layerslider-gallery/black-board.jpg" class="ls-bg" alt="Slide background" />
                        <img class="ls-l" style="top:120px;left:678px;white-space: nowrap;" data-ls="offsetxout:180;" src="img/layerslider-gallery/school-kid.png" alt="">
                        <img class="ls-l" style="top:156px;left:998px;white-space: nowrap;" data-ls="delayin:500;scaleyin:3;transformoriginin:0% 50% 0;parallaxlevel:2;" src="img/layerslider-gallery/b-cloud.png" alt="">
                        <img class="ls-l" style="top:67px;left:679px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:-100;delayin:1000;rotateyin:30;parallaxlevel:5;" src="img/layerslider-gallery/b-swirl.png" alt="">
                        <img class="ls-l" style="top:156px;left:40px;white-space: nowrap;" data-ls="offsetxin:-200;delayin:2000;" src="img/layerslider-gallery/b-comment.png" alt="">
                        <img class="ls-l" style="top:200px;left:70px;white-space: nowrap;" data-ls="delayin:1500;rotateyin:30;" src="img/layerslider-gallery/welcome-text.png" alt="">
                        <img class="ls-l" style="top:305px;left:96px;white-space: nowrap;" data-ls="delayin:2000;rotateyin:30;" src="img/layerslider-gallery/text-desc.png" alt="">
                        <a href="<?= $this->view->url(array(), 'signin', true);?>" class="ls-l" style="top:440px;left:105px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:200;delayin:1500;offsetxout:0;offsetyout:150;"><img src="img/layerslider-gallery/purchase-theme.png" alt=""></a>
                        <img class="ls-l" style="top:440px;left:370px;white-space: nowrap;" data-ls="delayin:1700;" src="img/layerslider-gallery/b-tick.png" alt="">
                        <img class="ls-l" style="top:463px;left:100px;white-space: nowrap;" data-ls="offsetxin:0;offsetyin:200;delayin:1000;offsetxout:0;offsetyout:150;" src="img/layerslider-gallery/chalk-effect.png" alt="">
                        <img class="ls-l" style="top:30px;left:2px;white-space: nowrap;" data-ls="delayin:2100;rotateyin:90;parallaxlevel:3;" src="img/layerslider-gallery/b-game.png" alt="">
                        <img class="ls-l" style="top:498px;left:0px;white-space: nowrap;" data-ls="offsetxin:-100;delayin:2500;parallaxlevel:4;" src="img/layerslider-gallery/b-bulb.png" alt="">
                        <img class="ls-l" style="top:524px;left:567px;white-space: nowrap;" data-ls="delayin:1300;rotateyin:180;parallaxlevel:-3;" src="img/layerslider-gallery/b-glass.png" alt="">
                    </div>
                </div>
            </div>
            <!--slider ends-->
<?php
    }
}