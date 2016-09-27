var TF = {};
TF = {
	initialise : function(){
		$( "#contact-form" ).submit(function( event ) {
			event.preventDefault();
			var $form = $( this ),
			url = $form.attr( "action" );

			var posting = $.post( url, $(this).serialize() );

			posting.done(function( data ) {
				if(data.error){
					$.magnificPopup.open({
					    items: {
							src: '<div class="white-popup"><h1>Ooooops !</h1>' + data.msg + '</div>',
							type: 'inline'
						},
						closeBtnInside: true
					});
					return ;
				}

				var t4 = new TimelineLite();
				t4.to($('#contact-form'), 1, {height:0, alpha:0, ease:Power2.easeOut}, "+=0");
				t4.to($('#thanks2'), 0.1, {alpha:0.5, ease:Power2.easeOut}, "+=0.5");
				t4.to($('#thanks2'), 0.5, {alpha:1, repeat:-1, display:'block', yoyo:true, repeatDelay:0.2, ease:Power2.easeOut}, "+=1");
				TweenLite.delayedCall('10', TF.killTween2, null, null, false);
				var t5 = new TimelineLite();
				t5.to($('#thanks2'), 1, {alpha:0, ease:Power2.easeOut}, "+=7");
				t5.to($('#contact-form'), 1, {height:'auto', alpha:1, ease:Power2.easeOut}, "+=1");
			});
		});

		$( "#NewsletterAddemailForm" ).submit(function( event ) {
			event.preventDefault();

			var $form = $( this ),
			url = $form.attr( "action" );

			var posting = $.post( url, $(this).serialize() );

			posting.done(function( data ) {
				if(data.error){
					$.magnificPopup.open({
					    items: {
							src: '<div class="white-popup"><h1>Ooooops !</h1>' + data.msg + '</div>', 
							type: 'inline'
						},
						closeBtnInside: true
					});
					return ;
				}

				var t4 = new TimelineLite();
				t4.to($('#NewsletterAddemailForm'), 1, {height:0, alpha:0, ease:Power2.easeOut}, "+=0");
				t4.to($('#thanks'), 0.1, {alpha:0.5, ease:Power2.easeOut}, "+=0.5");
				t4.to($('#thanks'), 0.5, {alpha:1, repeat:-1, display:'block', yoyo:true, repeatDelay:0.2, ease:Power2.easeOut}, "+=1");
				TweenLite.delayedCall('10', TF.killTween, null, null, false);
				var t5 = new TimelineLite();
				t5.to($('#thanks'), 1, {alpha:0, ease:Power2.easeOut}, "+=7");
				t5.to($('#NewsletterAddemailForm'), 1, {height:'auto', alpha:1, ease:Power2.easeOut}, "+=1");
			});
		});
	},
	killTween : function(){
		TweenMax.killTweensOf($("#thanks"));
	},
	killTween2 : function(){
		TweenMax.killTweensOf($("#thanks2"));
	},
	openGmapsPopup : function(obj){
		var location = obj.attr('href');
		$.magnificPopup.open({
		    type: 'iframe',
			items: {
				src: location
			},
			iframe: {
				markup: '<div class="mfp-iframe-scaler">'+
						'<div class="mfp-close"></div>'+
						'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
						'</div>', // HTML markup of popup, `mfp-close` will be replaced by the close button

				patterns: {
					gmaps: {
						index: 'http://maps.google.fr',
						src: '%id%&output=embed'
					}
				},
				srcAction: 'iframe_src', // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".
			}
		});
	}
};
