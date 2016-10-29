var Player = function() {
	this.current_sound = 0;
	this.playlist = Array();
	this.status = 'playin';
	this.volume = 100;
	this.mySound;
	this.initialize = function(path) {
		this.current_sound = 0;
		this.playlist = [path + "/mp3/Ifaman.mp3",
						 path + "/mp3/Serenade.mp3"];
		this.PlaySound();
	},
	this.PlaySound = function() {
		var obj = this;
		this.getCurrentSound();
		this.mySound.play();
		this.mySound.setVolume(this.volume);
		this.mySound.bind("ended", function(e) {
			obj.playNextSound();
		});
	},
	this.playOrStop = function(){
		if(this.status == 'playin')
			this.pauseCurrentSound();
		else
			this.playCurrentSound();
	},
	this.getCurrentSound = function() {
		var mySound = new buzz.sound(this.playlist[this.current_sound]);
		mySound.load();
		this.mySound = mySound;
	},
	this.pauseCurrentSound = function(){
		this.mySound.pause();
		this.status = 'stopped';
	},
	this.stopCurrentSound = function () {
		this.mySound.stop();
		this.status = 'stopped';
	},
	this.playCurrentSound = function() {
		this.mySound.play();
		this.status = 'playin';
	},
	this.setVolumeTo = function(volume){
		this.mySound.setVolume(volume);
		this.volume = this.mySound.getVolume();
	},
	this.playNextSound = function() {
		this.stopCurrentSound();
		if(this.current_sound == this.playlist.length-1)
			this.current_sound = 0;
		else
			this.current_sound++;
		this.PlaySound();
	},
	this.playPreviousSound = function() {
		this.stopCurrentSound();
		if(this.current_sound == 0)
			this.current_sound = this.playlist.length-1;
		else
			this.current_sound--;
		this.PlaySound();
	},
	this.playSelectedSound = function(i) {
		this.stopCurrentSound();
		this.current_sound = i;
		this.PlaySound();
	}
};
