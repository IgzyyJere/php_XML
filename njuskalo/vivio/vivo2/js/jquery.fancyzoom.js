/**
* jQuery fancyzoom plugin.
* This is an adaptation of the fancyzoom effect as a jQuery plugin
*
* Author: Mathieu Vilaplana <mvilaplana@df-e.com>
* Date: March 2008
* rev: 1.0
*/
(function($) {
	var strImgDir = 'ressources/';
	
	$.fn.fancyzoom = function(userOptions) {
		//the var to the image box div
    	var oImgZoomBox;
	 	var oOverlay = $('<div>').css({
			height: '100%',
			width: '100%',
   			position:'fixed',
			left: 0,
			top: 0,
			cursor:"wait"
		});
  		var oImgClose = $('<img>')
  			.css({position:'absolute',top:0,left:0,cursor:'pointer',zIndex:102});
		
		function openZoomBox(elLink,o){
			if(o.showoverlay) {oOverlay.appendTo('body').click(function(){closeZoomBox(o);});}

            //calculate the start point of the animation, it start from the image of the element clicked
            pos=$('img',elLink).offset();
			o=$.extend(o,{dimOri:{width:$('img',elLink).outerWidth(),height:$('img',elLink).outerHeight(),left:pos.left,top:pos.top,'opacity':0}});

			//calculate the end point of the animaton
			oImgZoomBox.css({'opacity':0}).appendTo('body');
			var iWidth = oImgZoomBox.outerWidth()+(oImgClose.height()/2);
			var iHeight = oImgZoomBox.outerHeight();
			//the target is in the center without the extra margin du to close Image
			dimBoxTarget=$.extend({},{width:iWidth,height:iHeight,'opacity':1}, __posCenter((iWidth-15),(iHeight-15)));
            
            //place the close button at the right of the zoomed Image and add the close box action
            oImgClose.css({left:(iWidth-30+dimBoxTarget.left),top:dimBoxTarget.top});
            
            var $fctEnd = function(){
            	//end of open, show the shadow
            	if($.fn.shadow && !$.browser.msie){ $('img',oImgZoomBox).shadow(o.shadowOpts);}
				if(o.Speed>0 && !$.browser.msie) {oImgClose.fadeIn('slow');}
				else {oImgClose.show();}
            };
  			if(o.Speed > 0) {
  				oImgZoomBox.css(o.dimOri).animate(dimBoxTarget,o.Speed,$fctEnd);
  			}
  			else {
  				oImgZoomBox.css(dimBoxTarget);
  				$fctEnd();
  			}
	 	 }//end openZoomBox
 	 	 
 	 	 /**
 	 	  * First hide the closeBtn, then remove the ZoomBox and the overlay
 	 	  * Animate if Speed > 0 
 	 	  */
 	 	 function closeZoomBox(o){
	 	 	oImgClose.hide();
		 	 if(o.Speed > 0){
		 	 	oImgZoomBox.animate(o.dimOri,o.Speed*2/3,function(){
			 		$(this).empty().remove();
		 		});
				if(o.showoverlay) {oOverlay.animate({'opacity':0},o.Speed,function(){$(this).empty().remove();});}
	 	 	}else {
			 	oImgZoomBox.empty().remove();
				if(o.showoverlay) {oOverlay.empty().remove();}
	 	 	}
 	 	 }
    		
		/**
		 * The plugin chain.
		 */
   		return this.each(function() {
   			var $this = $(this);

			// build main options before element iteration		
	    	var opts = $.extend($.fn.fancyzoom.defaultsOptions, userOptions||{},{dimOri:{},
	    		oImgZoomBoxProp:{
	   				position:'absolute',
	   				left:0,
	   				top:0
				}
	    	});
	    	oOverlay.css({
				opacity: opts.overlay,
				background:opts.overlayColor
	    	});
	    	
	    	
   			
   			//make action only on link that point to an href
   			if(!/\.jpg|\.png|.gif/i.test($this.attr('href')) || $('img',$this).size()===0){
	   			return;
   			}
   			
   			$this.click(function(){
   				if(oLoading && oLoading.is(':visible') || timerLoadingImg){
   					//if user click on an other image, cancel the previous loading
					if(oImgZoomBox && $('img',oImgZoomBox).attr('src') != $(this).attr('href')){
	   					__cancelLoading();
					}
	   				else {//solve the double click pb
	   					return false;
	   				}
   				}
   				var o = $.extend({},opts,userOptions);
				//if zoom box be shure to  close it
   				if(oImgZoomBox) {oImgZoomBox.empty().remove();}
   				//remove the overlay and Reset
		 	 	if(o.showoverlay && oOverlay) {oOverlay.empty().remove().css({'opacity':o.overlay});}
				
				//reset the img close and fix png on it if plugin available
				if($.ifixpng) {$.ifixpng(o.imgDir+'blank.gif');}
				oImgClose.attr('src',o.imgDir+'closebox.png').appendTo('body');
				if($.fn.ifixpng) {oImgClose.ifixpng();}
				oImgClose.hide().unbind('click').click(function(){closeZoomBox(o);});

				//reset zoom box prop and add image zoom with a margin top of 15px = imgclose height / 2
	    		oImgZoomBox = $('<div>').css(o.oImgZoomBoxProp).empty();
   				oImgZoom=$('<img>').attr('src',$(this).attr('href')).css({zIndex:100,'margin-top':(oImgClose.height()/2)+'px'}).click(function(){closeZoomBox(o);}).appendTo(oImgZoomBox);
				
				
				//be shure that the image to display is loaded open the zoom box, if not display a loading Image.
   				var imgPreload = new Image();
   				imgPreload.src = $(this).attr('href');
   				var $fctEndLoading = function(){
	   				if(__getFileName(imgPreload.src) == __getFileName($('img',oImgZoomBox).attr('src')) ){
		   				openZoomBox($this, o);
						oLoading.hide();
	   				}
   				};
   				if(imgPreload.complete)	{
   					openZoomBox($this, o);
	   				//__displayLoading(imgPreload);
	   				//setTimeout($fctEndLoading,4000);;
   				}
	   			else {
	   				__displayLoading();
	   				imgPreload.onload = function(){
	   					//when loading is finish display the zoombox if user not click on cancel
	   					var $fcttime = function(){
	   						if(bCancelLoading) {bCancelLoading=false;}
	   						else {$fctEndLoading();}
	   					};
	   					$fcttime();
	   				 	//setTimeout($fcttime,4000);
	   				};
	   			}
        
   				return false;		
   			});
   		}
   	);//end return this
    };//end Plugin

    
    //Default Options
    $.fn.fancyzoom.defaultsOptions = {
    	overlayColor: '#000',
    	overlay: 0.6,
    	showoverlay:false,
    	Speed:400,
    	shadowOpts:{ color: "#000", offset: 4, opacity: 0.2 },
    	imgDir:strImgDir
 	 };
 	 
	function __posCenter(iWidth,iHeight){
		var iLeft = ($(window).width() - iWidth) / 2 + $(window).scrollLeft();
		var iTop = ($(window).height() - iHeight) / 2 + $(window).scrollTop();
		iLeft=(iLeft < 0)?0:iLeft;
		iTop=(iTop < 0)?0:iTop;
	  		return {left:iLeft,top:iTop};
    }
    
    //
    // LOADING MANAGEMENT
    //
    var oLoading =null ;
	var bCancelLoading = false;
	var timerLoadingImg = null;
	function __displayLoading(){
		if(!oLoading){
			oLoading = $('<div>').css({width:50,height:50,position:'absolute','background':'transparent',opacity:8/10,color:'#FFF',padding:'5px','font-size':'10px'}).css(__posCenter(50,50)).html('<img  src="" />').appendTo('body').click(function(){__cancelLoading();});
		}
		else {
			oLoading.css(__posCenter(50,50)).show().html('<img src="'+$.fn.fancyzoom.defaultsOptions.imgDir+'blank.gif" />');
		}
		timerLoadingImg=setTimeout(__changeimageLoading,400);
	}
	function __cancelLoading(){
		bCancelLoading=true;
		oLoading.hide();
		if(timerLoadingImg){
			clearTimeout(timerLoadingImg);
			timerLoadingImg=null;
		}
	}
	
	/**
	 * Animate the png loading image.
	 */
	function __changeimageLoading(){
		if(!oLoading.is(':visible')){
			timerLoadingImg=null;
			return;
		}
		
		var $im=$('img',oLoading);
		//First call im.src ="", set it to the fire png zoom spin
		if(!$im.attr('src')){
			strImgSrc = $.fn.fancyzoom.defaultsOptions.imgDir+"zoom-spin-1.png";
		}
		//rotate the im src until 12
		else {
			tab = $im.attr('src').split(/[- .]+/);
			iImg = parseInt(tab[2]);
			iImg = (iImg < 12)? (iImg+1):1;
			strImgSrc= tab[0]+"-"+tab[1]+"-"+iImg+"."+tab[3];
		}
		var pLoad = new Image();
		pLoad.src=strImgSrc;
		var $fct = function (){
			oLoading.css(__posCenter(50,50));
			$im.attr('src',strImgSrc);
			timerLoadingImg = setTimeout(__changeimageLoading,100);
		};
		//to preserve bug if img not exist change it only if load complete.
		if(pLoad.complete){$fct();}
		else{pLoad.onload=$fct;}
	}
 	
 	function __getFileName(strPath){
 		if(!strPath) {return false;}
		var tabPath = strPath.split('/');
		return ((tabPath.length<1)?strPath:tabPath[(tabPath.length-1)]);		
 	}
 	
})(jQuery);