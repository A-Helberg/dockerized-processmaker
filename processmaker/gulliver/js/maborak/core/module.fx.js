leimnud.Package.Public({
	info	:{
		Class	:"maborak",
		File	:"module.fx.js",
		Name	:"fx",
		Type	:"module",
		Version	:"0.1"
	},
	content	:{
		algorithm:function()
		{
			this.make=function(options)
			{
				this.options = {
					transition	: "sineInOut",
					duration	: 2000,
					fps			: 70,
					onTransition: function(){},
					onFinish	: function(){},
					begin		: 0,
					end			: 100,
					timeBegin	: new Date().getTime()
				}.concatMaborak(options || {});
				this.timer	= setInterval(function(){
					var time = new Date().getTime();
					if (time < this.options.timeBegin + this.options.duration)
					{
						this.cTime	= time - this.options.timeBegin;
						if(this.options.begin.isArray)
						{
							this.result		= [];
							for(var i=0;i<this.options.begin.length;i++)
							{
								this.result.push(this.transitions[this.options.transition](this.cTime, this.options.begin[i], (this.options.end[i] - this.options.begin[i]), this.options.duration,0,0));
							}
						}
						else
						{
							this.result	= this.transitions[this.options.transition](this.cTime, this.options.begin, (this.options.end - this.options.begin), this.options.duration,0,0);
						}
						return this.options.onTransition(this);
					}
					else
					{
						this.timer = clearInterval(this.timer);
						return this.options.onFinish(this);
					}
				}.extend(this),Math.round(1000/this.options.fps));
			};
			this.transitions = {

				/* Property: linear */
				/* cTime, from, (to - from),duration */
				linear: function(t, b, c, d){
					return c*t/d + b;
				},

				/* Property: quadIn */
				quadIn: function(t, b, c, d){
					return c*(t/=d)*t + b;
				},

				/* Property: quatOut */
				quadOut: function(t, b, c, d){
					return -c *(t/=d)*(t-2) + b;
				},

				/* Property: quadInOut */
				quadInOut: function(t, b, c, d){
					if ((t/=d/2) < 1) return c/2*t*t + b;
					return -c/2 * ((--t)*(t-2) - 1) + b;
				},

				/* Property: cubicIn */
				cubicIn: function(t, b, c, d){
					return c*(t/=d)*t*t + b;
				},

				/* Property: cubicOut */
				cubicOut: function(t, b, c, d){
					return c*((t=t/d-1)*t*t + 1) + b;
				},

				/* Property: cubicInOut */
				cubicInOut: function(t, b, c, d){
					if ((t/=d/2) < 1) return c/2*t*t*t + b;
					return c/2*((t-=2)*t*t + 2) + b;
				},

				/* Property: quartIn */
				quartIn: function(t, b, c, d){
					return c*(t/=d)*t*t*t + b;
				},

				/* Property: quartOut */
				quartOut: function(t, b, c, d){
					return -c * ((t=t/d-1)*t*t*t - 1) + b;
				},

				/* Property: quartInOut */
				quartInOut: function(t, b, c, d){
					if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
					return -c/2 * ((t-=2)*t*t*t - 2) + b;
				},

				/* Property: quintIn */
				quintIn: function(t, b, c, d){
					return c*(t/=d)*t*t*t*t + b;
				},

				/* Property: quintOut */
				quintOut: function(t, b, c, d){
					return c*((t=t/d-1)*t*t*t*t + 1) + b;
				},

				/* Property: quintInOut */
				quintInOut: function(t, b, c, d){
					if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
					return c/2*((t-=2)*t*t*t*t + 2) + b;
				},

				/* Property: sineIn */
				sineIn: function(t, b, c, d){
					return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
				},

				/* Property: sineOut */
				sineOut: function(t, b, c, d){
					return c * Math.sin(t/d * (Math.PI/2)) + b;
				},

				/* Property: sineInOut */
				sineInOut: function(t, b, c, d){
					return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
				},

				/* Property: expoIn */
				expoIn: function(t, b, c, d){
					return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
				},

				/* Property: expoOut */
				expoOut: function(t, b, c, d){
					return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
				},

				/* Property: expoInOut */
				expoInOut: function(t, b, c, d){
					if (t==0) return b;
					if (t==d) return b+c;
					if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
					return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
				},

				/* Property: circIn */
				circIn: function(t, b, c, d){
					return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
				},

				/* Property: circOut */
				circOut: function(t, b, c, d){
					return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
				},

				/* Property: circInOut */
				circInOut: function(t, b, c, d){
					if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
					return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
				},

				/* Property: elasticIn */
				elasticIn: function(t, b, c, d, a, p){
					if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3; if (!a) a = 1;
					if (a < Math.abs(c)){ a=c; var s=p/4; }
					else var s = p/(2*Math.PI) * Math.asin(c/a);
					return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
				},

				/* Property: elasticOut */
				elasticOut: function(t, b, c, d, a, p){
					if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3; if (!a) a = 1;
					if (a < Math.abs(c)){ a=c; var s=p/4; }
					else var s = p/(2*Math.PI) * Math.asin(c/a);
					return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
				},

				/* Property: elasticInOut */
				elasticInOut: function(t, b, c, d, a, p){
					if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5); if (!a) a = 1;
					if (a < Math.abs(c)){ a=c; var s=p/4; }
					else var s = p/(2*Math.PI) * Math.asin(c/a);
					if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
					return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
				},

				/* Property: backIn */
				backIn: function(t, b, c, d, s){
					if (!s) s = 1.70158;
					return c*(t/=d)*t*((s+1)*t - s) + b;
				},

				/* Property: backOut */
				backOut: function(t, b, c, d, s){
					if (!s) s = 1.70158;
					return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
				},

				/* Property: backInOut */
				backInOut: function(t, b, c, d, s){
					if (!s) s = 1.70158;
					if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
					return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
				},

				/* Property: bounceIn */
				bounceIn: function(t, b, c, d){
					return c - this.transitions.bounceOut (d-t, 0, c, d) + b;
				},

				/* Property: bounceOut */
				bounceOut: function(t, b, c, d){
					if ((t/=d) < (1/2.75)){
						return c*(7.5625*t*t) + b;
					} else if (t < (2/2.75)){
						return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
					} else if (t < (2.5/2.75)){
						return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
					} else {
						return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
					}
				},

				/* Property: bounceInOut */
				bounceInOut: function(t, b, c, d){
					if (t < d/2) return this.transitions.bounceIn(t*2, 0, c, d) * .5 + b;
					return this.transitions.bounceOut(t*2-d, 0, c, d) * .5 + c*.5 + b;
				}

			}.expand(this);
			this.expand(this);
		},
		fade:function()
		{
			this.make=function(options)
			{
				this.options = {
					duration: 1000,
					transition:"sineInOut",
					end	: 0,
					onFinish:function(){}
				}.concatMaborak(options);
				this.dom = ((this.options.dom || []).isArray)?this.options.dom:[this.options.dom];
				for(var i=0;i<this.dom.length;i++)
				{
					of	 = (i==(this.dom.length-1))?this.options.onFinish:function(){};
					new this.parent.module.fx.algorithm().make({
						duration 	: this.options.duration,
						end			: this.options.end,
						transition	: this.options.transition,
						begin	 	: this.parent.dom.getOpacity(this.dom[i]),
						onTransition	: function(fx,dom){
							this.parent.dom.opacity(dom,fx.result*100);
						}.extend(this,this.dom[i]),
						onFinish:function(fx,dom,finish)
						{
							this.parent.dom.opacity(dom,this.options.end*100);
							return finish();
						}.extend(this,this.dom[i],of)
					});
				}
				this.expand(this);
			};
		},
		move:function()
		{
			this.make=function(options)
			{
				this.options = {
					duration: 1000,
					transition:"sineInOut",
					end	: 0,
					onFinish:function(){}
				}.concatMaborak(options);
				this.dom = this.options.dom;
				new this.parent.module.fx.algorithm().make({
					duration 	: this.options.duration,
					end		: [this.options.end.x,this.options.end.y],
					transition	: this.options.transition,
					begin	 	: [parseInt(this.dom.style.left),parseInt(this.dom.style.top)],
					onTransition	: function(fx,dom){
						this.dom.style.left=fx.result[0];
						this.dom.style.top=fx.result[1];
					}.extend(this,this.dom),
					onFinish:function(fx,dom,finish)
					{
						//alert(this.options.end[0])
						this.dom.style.left	= this.options.end.x;
						this.dom.style.top	= this.options.end.y;
						return this.options.onFinish();
					}.extend(this,this.dom)
				});
				this.expand(this);
			};
		}
	}
});
