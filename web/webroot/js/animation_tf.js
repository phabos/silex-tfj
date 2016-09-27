var Animation = function() {
	this.player;
	this.url;
	this.current_index;
	this.root;
	this.initialize = function(root) {
		//console.log($(window).height());
		this.root = root;
		if (SVG.supported) {
			var obj = this;
			$('#fullpage').fullpage({
				afterLoad: function(anchorLink, index){
					obj.current_index = index - 1;
					if(!$('#section' + obj.current_index).hasClass('loaded')){
						obj.loadAjaxContent();
						obj.animateContent();
						$('#section' + obj.current_index).addClass('loaded');
					}
				},
				onLeave: function(index, nextIndex, direction){
					obj.animateContactButton(index, nextIndex);
				}
			});
			this.initUrls();
			this.loadHeavyImages();
		}else{
			alert('Your browser is shit, please change it !');
		}
	},
	this.animateContactButton = function(index, nextIndex){
		var index = index - 1;
		var active_div = $("#section"+index).children()[0];
		//console.log("#section"+index);
		if($('.contact-btn').hasClass('open')){
			TweenLite.to($('#form_mail'), 2, {left:'-250px', ease:Power2.easeOut});
			TweenLite.to(active_div, 2, {css:{paddingLeft:0, transformPerspective:500, rotationY:0, opacity:1}});
			$('.contact-btn').removeClass('open');
		}
	},
	this.animateContent = function(){
		if(this.current_index == 1){
			var t3 = new TimelineLite();
			t3.to($('.bio-content'), 4, {height:'100%', ease:Power2.easeOut}, "+=1");
		}
		if(this.current_index == 2){
			var draw = SVG('concert-content').size('100%', '100%');
			var circle = draw.circle(0).attr({ 
				fill: '#f6f5f0', 
				stroke: '#f6f5f0',
				'stroke-width': 1,
				cx: '90%',
				cy: '80%'
			}).animate(2000, '>', 0).radius(500);
		}
	},
	this.updateHtmlContent = function (data){
		$('.page-content' + this.current_index).find('.mCSB_container').html(data);
		if(this.current_index == 3){
			$('.photo-gallery').each(function( index ) {
				$(this).magnificPopup({
					delegate: 'a',
					type: 'image',
					gallery: {enabled: true}
				});
				$(this).find('img') .mouseenter(function() {
					TweenMax.to($(this), .75, { borderRadius:"50%", ease:Elastic.easeOut});
				})
				.mouseleave(function() {
					TweenMax.to($(this), .75, { borderRadius:"0%", ease:Elastic.easeOut});
				});
			});
		}
	},
	this.loadAjaxContent = function(){
		var obj = this;
		//console.log(obj.current_index);
		$.ajax({
			url: this.url[obj.current_index],
		}).done(function( data ) {
			obj.updateHtmlContent(data);
		}).fail(function( ) {
			alert('Sorry something went wrong !');
		});
	},
	this.initUrls = function(){
		this.url = [];
		this.url[1] = this.root + 'biographie';
		this.url[2] = this.root + 'concerts';
		this.url[3] = this.root + 'photos';
	},
	this.playOrStop = function(){
		this.player.playOrStop();
	},
	this.loadHeavyImages = function() {
	    var obj = this;
		imagesLoaded( document.querySelector('#loading_images'), function( instance ) {
			$(".loading-panel").remove();
			obj.playAnimation();
		});
	},
	this.playAnimation = function(){
		var obj = this;
		this.animateInit();
				
		$("#bigger").hover(function() {
		    obj.animateMegaphone($("#SvgjsPath1014"));
			obj.animateMegaphone($("#SvgjsPath1015"));
			obj.animateMegaphone($("#SvgjsPath1016"));
			obj.animateMegaphone($("#SvgjsPath1017"));
			obj.animateMegaphone($("#SvgjsPath1018"));
			obj.animateMegaphone($("#SvgjsPath1019"));
		});
		
		$("#single").hover(function() {
		    obj.animateMegaphone($("#SvgjsPath1021"));
			obj.animateMegaphone($("#SvgjsPath1022"));
		});

		var tl = new TimelineLite();
		tl.to($('#ears'), 0.5, {x:'-330', rotation:'-360', ease:Power2.easeOut}, "+=7");
		tl.to($('#ears'), 1, {alpha:0.1, repeat:-1, yoyo:true, repeatDelay:0.2, ease:Power2.easeOut}, "+=1");
		TweenLite.delayedCall('8', this.typeFirstElement, null, null, false);
		TweenLite.delayedCall('12', this.typeSecondElement, null, null, false);
		TweenLite.delayedCall('16', this.typeThirdElement, null, null, false);
		//tl.to($('#body'), 3, {backgroundPosition:'0px 80px', ease:Power2.easeOut}, "-=3");
		//tl.to($('#title'), 1.5, {y:'-110', ease:Power2.easeOut}, "+=8");
		TweenLite.delayedCall('20', this.killTween, null, null, false);
		var t2 = new TimelineLite();
		t2.to($('.content'), 3, {autoAlpha:'0', ease:Power2.easeOut, onComplete:this.destroyElt}, "+=20");
		t2.to($('.lead'), 3, {autoAlpha:'1', ease:Power2.easeOut}, "+=1");
		//TweenLite.delayedCall('22', animateBackgroundElt1, null, null, false);
		TweenLite.delayedCall('22', this.animateBackgroundElt2, [obj], null, false);
		t2.to($('.inner-content'), 3, {height:'250', ease:Power2.easeOut, onComplete:this.destroyBck}, "-=2");
		t2.to($('#bars'), 3, {width:'60px', height:'60px', autoAlpha:'1', ease:Power2.easeOut}, "-=2");
		t2.to($('#youtube'), 3, {width:'60px', height:'60px', autoAlpha:'1', ease:Power2.easeOut}, "-=2");
		t2.to($('#facebook'), 3, {width:'60px', height:'60px', autoAlpha:'1', ease:Power2.easeOut}, "-=2");
		
		$("#bars").click(function(){
			if($(this).hasClass('open')){
				$(this).children().css('animation-play-state', 'running');
				$(this).children().css('-webkit-animation-play-state', 'running');
				$(this).removeClass('open');
			}else{
				$(this).children().css('animation-play-state', 'paused');
				$(this).children().css('-webkit-animation-play-state', 'paused');
				$(this).addClass('open');
			}
		}); 
		
		$(".contact-btn").click(function(){
		    var active_div = $("#fullpage").find( "div.active" ).children()[0];
			if($(this).hasClass('open')){
				TweenLite.to($('#form_mail'), 2, {left:'-250px', ease:Power2.easeOut});
				TweenLite.to(active_div, 2, {css:{paddingLeft:0, transformPerspective:500, rotationY:0, opacity:1}});
				$(this).removeClass('open');
			}else{
				TweenLite.to($('#form_mail'), 2, {left:'0px', ease:Power2.easeOut});
				TweenLite.to(active_div, 2, {css:{paddingLeft:250, transformPerspective:500, rotationY:-10, opacity:0.3}});
				$(this).addClass('open');
			}
		}); 
	},
	this.animateMegaphone = function(elt){
		elt.attr("class", "").attr("class", "tada animated").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
			$(this).attr("class", "");
		});
	},
	this.destroyBck = function(){
		//$(".wrapper").animate({backgroundColor: 'transparent'}, 200);
		//$('.wrapper').css('background', 'transparent');
		$("#arrow_vid").toggleClass('hidden');
		$("#arrow_vid").addClass('visible');
		$(".content_article").show(2000);
		$(".concert-alert").show(2000);
	},
	this.typeFirstElement = function(){
		$(".sentence1").typed({
			strings: ["Si l'homme a deux oreilles et une bouche,"],
			typeSpeed: 20
		});
	},
	this.typeSecondElement = function(){
		$(".sentence2").typed({
			strings: ["c'est pour écouter deux fois plus qu'il ne parle."],
			typeSpeed: 20
		});
	}
	this.typeThirdElement = function(){
		$(".sentence3").toggleClass('hidden');
		$(".sentence3").toggleClass('visible');
	}
	this.killTween = function(){
		TweenMax.killTweensOf($("#ears"));
	}
	this.destroyElt = function(){
		$(".content").remove();
	}
	this.animateInit = function(){
		var draw = SVG('ears').size('242', '242');
		var circle = draw.circle(0).attr({ 
			fill: 'none', 
			stroke: '#792221',
			'stroke-width': 1,
			cx: 121,
			cy: 121
		}).animate(2000, '>', 0).radius(120);
					
		var O = draw.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(-80, -90)
		.m(141.2398,168.7929)
		.c({x:9.17992,y:-96.211454}, {x:141.46359,y:-73.261445}, {x:126.06301,y:12.91603})
		.c({x:-1.40775,y:11.07281}, {x:-28.92469,y:72.58631}, {x:-34.81277,y:90.08919})
		.c({x:-7.22894,y:18.3349}, {x:-16.34958,y:25.01579}, {x:-29.30328,y:31.17368})
		.c({x:-10.8243,y:5.14563}, {x:-28.9914,y:8.11906}, {x:-40.6387,y:-1.39927})
		.c({x:-7.26327,y:-5.16996}, {x:-8.49159,y:-17.04233}, {x:-14.49983,y:-38.29267})
		.Z()
		.drawAnimated({duration: 3000, easing: '<>', delay: 2500});
					
		var O2 = draw.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(-80, -90)
		.m(186.62691,264.51373)
		.c({x:5.5,y:-2.64213},{x:13.6,y:-6.04175},{x:18,y:-7.5547})
		.c({x:9.3647,y:-3.22009},{x:14.6316,y:-7.86325},{x:16.6583,y:-14.68542})
		.c({x:0.7671,y:-2.58231},{x:1.259,y:-9.10482},{x:1.2053,y:-15.9838})
		.c({x:-0.91061,y:-33.64196},{x:-17.78683,y:-44.925},{x:-35.98553,y:-47.35878})
		.c({x:-10.40452,y:-0.71906},{x:-14.52758,y:-0.0541},{x:-21.35213,y:1.08236})
		.c({x:-1.77031,y:-7.71717},{x:-1.66479,y:-10.63018},{x:-1.19513,y:-14.25085})
		.c({x:1.99949,y:-14.96312},{x:10.58919,y:-26.7871},{x:24.16469,y:-33.26316})
		.c({x:6.8835,y:-3.28372},{x:8.249,y:-3.58025},{x:16.5044,y:-3.58407})
		.c({x:11.0685,y:-0.005},{x:17.2758,y:1.97286},{x:25.4322,y:8.10414})
		.c({x:3.2473,y:2.44105},{x:7.4642,y:6.79029},{x:9.3707,y:9.66498})
		.c({x:3.5976,y:5.42434},{x:7.6971,y:16.94563},{x:7.6971,y:21.63204})
		.c({x:0,y:5.22002},{x:5.279,y:7.12128},{x:7.0246,y:2.52996})
		.c({x:0.6841,y:-1.79924},{x:0.5296,y:-4.70923},{x:-0.5174,y:-9.75})
		.c({x:-5.0169,y:-24.15341},{x:-24.081,y:-39.78694},{x:-48.6408,y:-39.8879})
		.c({x:-13.8131,y:-0.0568},{x:-22.9301,y:3.58887},{x:-33.3493,y:13.33552})
		.c({x:-5.016,y:4.69219},{x:-7.53199,y:8.1107},{x:-10.75189,y:14.60874})
		.c({x:-3.9062,y:7.88303},{x:-4.2313,y:9.17286},{x:-4.5952,y:18.23367})
		.c({x:-0.6007,y:14.95555},{x:3.4578,y:26.49523},{x:12.68519,y:36.06852})
		.c({x:5.1793,y:5.37338},{x:6.1869,y:5.77119},{x:8.5734,y:3.38472})
		.c({x:2.2541,y:-2.25412},{x:2.0635,y:-2.80775},{x:-2.885,y:-8.3795})
		.c({x:-8.1791,y:-9.2092},{x:-8.1587,y:-10.78368},{x:0.1575,y:-12.12575})
		.c({x:5.6769,y:-0.91614},{x:10.6248,y:-0.43342},{x:18.7989,y:1.83401})
		.c({x:8.5365,y:2.36798},{x:15.5709,y:9.56742},{x:18.5623,y:18.99788})
		.c({x:4.096,y:12.91265},{x:3.5396,y:33.07486},{x:-1.0487,y:37.99983})
		.c({x:-1.0476,y:1.12445},{x:-5.4167,y:3.2143},{x:-9.7092,y:4.6441})
		.c({x:-4.2924,y:1.42976},{x:-12.3044,y:4.84988},{x:-17.8044,y:7.60021})
		.c({x:-5.5,y:2.75033},{x:-10.525,y:5.0006},{x:-11.1667,y:5.0006})
		.c({x:-1.9054,y:0},{x:-2.1273,y:-2.2211},{x:-0.6995,y:-7})
		.c({x:2.8009,y:-9.37424},{x:0.7707,y:-21.21449},{x:-4.6286,y:-26.99441})
		.c({x:-3.09669,y:-3.31507},{x:-4.65819,y:-3.50284},{x:-6.38349,y:-0.76765})
		.c({x:-0.7647,y:1.21229},{x:-0.3146,y:3.01545},{x:1.792,y:7.17914})
		.c({x:2.97559,y:5.881},{x:3.00609,y:6.61603},{x:1.0004,y:24.0957})
		.c({x:-0.4742,y:4.13311},{x:-0.2065,y:5.48139},{x:1.52529,y:7.68306})
		.c({x:3.9102,y:4.97099},{x:7.6014,y:4.61263},{x:21.5606,y:-2.09319})
		.Z()
		.drawAnimated({duration: 3000, easing: '<>', delay: 2000});
	}
	/*function animateBackgroundElt1(){
		var bck1 = SVG('single').size('100%', '100%');
		animateBackground(bck1);
	}*/
	this.animateBackgroundElt2 = function(obj){
		var bck2 = SVG('svg-container-mega').size('100%', '100%');
		var bck3 = SVG('svg-container').size('100%', '100%');
		obj.animateBackground(bck2);
		obj.oreille2(bck3);
	}
	this.animateBackground = function(bck){
		/*var Back = bck.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(0,0)
		.m(93.60119,46.071429)
		.m(510.50595,1.011904)
		.c({x:0,y:0}, {x:9.45937,y:-0.714173}, {x:9.45937,y:5.461366})
		.c({x:0,y:6.175539}, {x:0.15373,y:61.324351}, {x:0.15373,y:61.324351})
		.c({x:0,y:0}, {x:0.44303,y:7.02884}, {x:-12.17432,y:7.02884})
		.c({x:-12.61735,y:0}, {x:-556.010206,y:0.0545}, {x:-556.010206,y:0.0545})
		.c({x:0,y:0}, {x:-8.60119,y:0}, {x:-8.60119,y:-8.60119})
		.c({x:0,y:-8.60119}, {x:1.011905,y:-20.744047}, {x:1.011905,y:-20.744047})
		.c({x:0,y:0}, {x:-12.528823,y:-1.641079}, {x:-21.515087,y:-9.302165})
		.C({x:8.8021083,y:75.800816}, {x:2.3611913,y:66.715845}, {x:2.7827383,y:44.300605})
		.C({x:3.1707233,y:23.669985}, {x:15.109193,y:14.553114}, {x:27.877241,y:7.647835})
		.C({x:40.344056,y:0.9054695}, {x:53.013131,y:1.5496836}, {x:66.812556,y:7.0278755})
		.c({x:7.719313,y:3.0644665}, {x:18.726405,y:12.5426335}, {x:20.83438,y:18.4837205})
		.c({x:3.334421,y:9.397687}, {x:5.954254,y:20.559833}, {x:5.954254,y:20.559833})
		.Z()
		.drawAnimated({duration: 3000, easing: '<>', delay: 1500});*/
		
		var circle = bck.circle(0).attr({ 
			fill: '#eee', 
			stroke: '#eee',
			'stroke-width': 1,
			cx: 52,
			cy: 50
		}).animate(2000, '>', 2000).radius(50);
		
		var Back2 = bck.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(24.463295,63.429958)
		.M(43.511905,27.35119)
		.M(40.637697,23.699301)
		.M(44.362303,20.084918)
		.M(74.536507,50.530851)
		.M(70.499603,53.754863)
		.M(67.797619,50.625)
		.M(50.172718,59.820933)
		.c({x:0,y:0}, {x:0.701074,y:8.029916}, {x:-2.841359,y:10.459589})
		.c({x:-2.955603,y:2.02718}, {x:-8.383712,y:1.5605}, {x:-10.780514,y:-0.885662})
		.c({x:-2.019232,y:-2.060817}, {x:-2.630762,y:-2.781526}, {x:-4.779258,y:-0.994489})
		.c({x:-1.552741,y:1.291511}, {x:-0.402539,y:2.968677}, {x:-0.402539,y:2.968677})
		.l(1.35635,1.612006)
		.l(-3.296728,3.035714)
		.l(-10.708432,-10.719149)
		.l(3.541667,-3.557741)
		.Z()
		.drawAnimated({duration: 3000, easing: '<>', delay: 1500});
			
		var Back3 = bck.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(52.619048,22.291667)
		.M(58.690476,9.1369048)
		.drawAnimated({duration: 3000, easing: '<>', delay: 1500});
		
		var Back4 = bck.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(0,0)
		.m(64.255952,29.880952)
		.m(9.107143,-7.589285)
		.drawAnimated({duration: 3000, easing: '<>', delay: 1500});
			
		var Back5 = bck.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(73.869048,41.517857)
		.M(85,37.97619)
		.drawAnimated({duration: 3000, easing: '<>', delay: 1500});
		
		var Back6 = bck.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(0,0)
		.m(27.827381,64.285714)
		.m(19.22619,-31.369047)
		.m(5.565477,5.565476)
		.m(-23.779762,28.333333)
		.drawAnimated({duration: 3000, easing: '<>', delay: 1500});
		
		var Back7 = bck.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(0,0)
		.m(39.213223,65.512706)
		.m(6.173997,-3.086998)
		.c({x:0,y:0}, {x:1.229023,y:3.199765}, {x:-1.239212,y:4.624801})
		.c({x:-2.468234,y:1.425036}, {x:-4.934785,y:-1.537803}, {x:-4.934785,y:-1.537803})
		.drawAnimated({duration: 3000, easing: '<>', delay: 1500});
	},
	
	this.oreille2 = function(bck){
		var circle = bck.circle(0).attr({ 
			fill: '#eee', 
			stroke: '#eee',
			'stroke-width': 1,
			cx: 52,
			cy: 50
		}).animate(2000, '>', 2000).radius(50);
		
		var Back7 = bck.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(0,0)
		.m(27,32)
		.c({x:4.03494,y:-41.383172},{x:62.17898,y:-31.511745},{x:55.4098,y:5.555534})
		.c({x:-0.61876,y:4.76272},{x:-12.71357,y:31.22136},{x:-15.30162,y:38.74982})
		.c({x:-3.17741,y:7.88634},{x:-7.1863,y:10.75998},{x:-12.87998,y:13.40865})
		.c({x:-4.75772,y:2.21328},{x:-12.7429,y:3.49222},{x:-17.86235,y:-0.60187})
		.c({x:-3.19251,y:-2.22373},{x:-3.73241,y:-7.33036},{x:-6.37327,y:-16.47071})
		.drawAnimated({duration: 3000, easing: '<>', delay: 1500});
		
		var Back8 = bck.path().attr({ 
			fill: 'none',
			stroke: '#792221', 
			'stroke-width': 2				
		})
		.M(0,0)
		.m(47,75)
		.c({x:2.41746,y:-1.13644},{x:5.97775,y:-2.59872},{x:7.91172,y:-3.24948})
		.c({x:4.11617,y:-1.38505},{x:6.43118,y:-3.38219},{x:7.322,y:-6.31659})
		.c({x:0.33717,y:-1.11073},{x:0.55339,y:-3.91624},{x:0.52977,y:-6.87507})
		.c({x:-0.40025,y:-14.47033},{x:-7.81803,y:-19.32348},{x:-15.8171,y:-20.37031})
		.c({x:-4.5732,y:-0.30928},{x:-6.38545,y:-0.0233},{x:-9.38512,y:0.46555})
		.c({x:-0.77812,y:-3.319359},{x:-0.73174,y:-4.572323},{x:-0.5253,y:-6.129674})
		.c({x:0.87885,y:-6.436048},{x:4.65437,y:-11.521867},{x:10.62135,y:-14.307392})
		.c({x:3.02558,y:-1.412425},{x:3.62578,y:-1.53997},{x:7.25436,y:-1.541615})
		.c({x:4.86505,y:-0.0023},{x:7.59341,y:0.848591},{x:11.17848,y:3.485821})
		.c({x:1.42733,y:1.049961},{x:3.28082,y:2.920683},{x:4.11881,y:4.157163})
		.c({x:1.58128,y:2.333161},{x:3.38319,y:7.288781},{x:3.38319,y:9.304531})
		.c({x:0,y:2.24528},{x:2.32033,y:3.063057},{x:3.08759,y:1.088207})
		.c({x:0.30069,y:-0.773905},{x:0.23278,y:-2.025565},{x:-0.22742,y:-4.193741})
		.c({x:-2.20513,y:-10.389039},{x:-10.58458,y:-17.113442},{x:-21.3796,y:-17.156872})
		.c({x:-6.07142,y:-0.02439},{x:-10.07871,y:1.543668},{x:-14.65838,y:5.735968})
		.c({x:-2.20473,y:2.018246},{x:-3.31061,y:3.488635},{x:-4.72588,y:6.283622})
		.c({x:-1.71694,y:3.390701},{x:-1.85983,y:3.945492},{x:-2.01978,y:7.8428})
		.c({x:-0.26404,y:6.432792},{x:1.51984,y:11.396322},{x:5.57566,y:15.514052})
		.c({x:2.27651,y:2.31123},{x:2.71939,y:2.48235},{x:3.76835,y:1.45586})
		.c({x:0.99077,y:-0.96956},{x:0.907,y:-1.20769},{x:-1.26807,y:-3.60426})
		.c({x:-3.59505,y:-3.96112},{x:-3.58608,y:-4.63834},{x:0.0693,y:-5.21561})
		.c({x:2.49522,y:-0.39406},{x:4.67003,y:-0.18643},{x:8.26288,y:0.78886})
		.c({x:3.75213,y:1.01853},{x:6.84403,y:4.11521},{x:8.15888,y:8.17151})
		.c({x:1.80036,y:5.55408},{x:1.5558,y:14.2264},{x:-0.46095,y:16.34476})
		.c({x:-0.46046,y:0.48365},{x:-2.38086,y:1.38256},{x:-4.26759,y:1.99755})
		.c({x:-1.88668,y:0.61499},{x:-5.40828,y:2.08607},{x:-7.82574,y:3.26907})
		.c({x:-2.41748,y:1.18298},{x:-4.62617,y:2.15088},{x:-4.90822,y:2.15088})
		.c({x:-0.83751,y:0},{x:-0.93504,y:-0.95535},{x:-0.30747,y:-3.01089})
		.c({x:1.23112,y:-4.03211},{x:0.33876,y:-9.12492},{x:-2.03445,y:-11.61103})
		.c({x:-1.36112,y:-1.4259},{x:-2.04747,y:-1.50666},{x:-2.80581,y:-0.33018})
		.c({x:-0.33611,y:0.52143},{x:-0.13828,y:1.29703},{x:0.78767,y:3.08794})
		.c({x:1.30788,y:2.52958},{x:1.32129,y:2.84574},{x:0.43971,y:10.36422})
		.c({x:-0.20843,y:1.77776},{x:-0.0908,y:2.35769},{x:0.67043,y:3.30469})
		.c({x:1.71868,y:2.13816},{x:3.34112,y:1.98402},{x:9.47676,y:-0.90034})
		.drawAnimated({duration: 3000, easing: '<>', delay: 1500});
	}
};

var CheckWindowSize = function(){
	this.initialize = function(){
		this.updateContainer();
		this.checkSize();
	},
	this.checkSize = function(){
		var obj = this;
		$( window ).resize(function() {
			obj.updateContainer();
		});
	},
	this.updateContainer = function(){
	    $(".main-section-scroll").css("height", $( window ).height()-250);
		$( ".page-content1" ).css("height", $( window ).height()-150);
		if($( window ).height()<350) $( ".page-content2" ).css("height", $( window ).height()-150);
		else $( ".page-content2" ).css("height", 350);
		$( ".page-content3" ).css("height", $( window ).height()-150);
	}
};