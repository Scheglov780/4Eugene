/*
 Highstock JS v9.0.0 (2021-02-02)

 Indicator series type for Highstock

 (c) 2010-2019 Pawel Fus, Sebastian Bochan

 License: www.highcharts.com/license
*/
(function(a){"object"===typeof module&&module.exports?(a["default"]=a,module.exports=a):"function"===typeof define&&define.amd?define("highcharts/indicators/indicators",["highcharts","highcharts/modules/stock"],function(g){a(g);a.Highcharts=g;return a}):a("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(a){function g(a,c,e,h){a.hasOwnProperty(c)||(a[c]=h.apply(null,e))}a=a?a._modules:{};g(a,"Mixins/IndicatorRequired.js",[a["Core/Utilities.js"]],function(a){var c=a.error;return{isParentLoaded:function(a,
h,l,m,g){if(a)return m?m(a):!0;c(g||this.generateMessage(l,h));return!1},generateMessage:function(a,l){return'Error: "'+a+'" indicator type requires "'+l+'" indicator loaded before. Please read docs: https://api.highcharts.com/highstock/plotOptions.'+a}}});g(a,"Stock/Indicators/SMA/SMAComposition.js",[a["Core/Series/SeriesRegistry.js"],a["Core/Utilities.js"]],function(a,c){var e=a.series,h=a.seriesTypes.ohlc.prototype;a=c.addEvent;var g=c.extend;a(e,"init",function(a){a=a.options;a.useOhlcData&&"highcharts-navigator-series"!==
a.id&&g(this,{pointValKey:h.pointValKey,keys:h.keys,pointArrayMap:h.pointArrayMap,toYData:h.toYData})});a(e,"afterSetOptions",function(a){a=a.options;var c=a.dataGrouping;c&&a.useOhlcData&&"highcharts-navigator-series"!==a.id&&(c.approximation="ohlc")})});g(a,"Stock/Indicators/SMA/SMAIndicator.js",[a["Mixins/IndicatorRequired.js"],a["Core/Series/SeriesRegistry.js"],a["Core/Utilities.js"]],function(a,c,e){var g=this&&this.__extends||function(){var a=function(c,d){a=Object.setPrototypeOf||{__proto__:[]}instanceof
Array&&function(a,d){a.__proto__=d}||function(a,d){for(var b in d)d.hasOwnProperty(b)&&(a[b]=d[b])};return a(c,d)};return function(c,d){function f(){this.constructor=c}a(c,d);c.prototype=null===d?Object.create(d):(f.prototype=d.prototype,new f)}}(),l=c.seriesTypes.line,m=e.addEvent,p=e.error,t=e.extend,u=e.isArray,v=e.merge,w=e.pick,x=e.splat,y=a.generateMessage;a=function(a){function e(){var d=null!==a&&a.apply(this,arguments)||this;d.data=void 0;d.dataEventsToUnbind=void 0;d.linkedParent=void 0;
d.options=void 0;d.points=void 0;return d}g(e,a);e.prototype.destroy=function(){this.dataEventsToUnbind.forEach(function(a){a()});a.prototype.destroy.apply(this,arguments)};e.prototype.getName=function(){var a=this.name,f=[];a||((this.nameComponents||[]).forEach(function(a,b){f.push(this.options.params[a]+w(this.nameSuffixes[b],""))},this),a=(this.nameBase||this.type.toUpperCase())+(this.nameComponents?" ("+f.join(", ")+")":""));return a};e.prototype.getValues=function(a,f){var d=f.period,b=a.xData;
a=a.yData;var e=a.length,c=0,g=0,q=[],r=[],h=[],k=-1;if(!(b.length<d)){for(u(a[0])&&(k=f.index?f.index:0);c<d-1;)g+=0>k?a[c]:a[c][k],c++;for(f=c;f<e;f++){g+=0>k?a[f]:a[f][k];var n=[b[f],g/d];q.push(n);r.push(n[0]);h.push(n[1]);g-=0>k?a[f-c]:a[f-c][k]}return{values:q,xData:r,yData:h}}};e.prototype.init=function(d,c){function f(){var a=b.points||[],d=(b.xData||[]).length,c=b.getValues(b.linkedParent,b.options.params)||{values:[],xData:[],yData:[]},f=[],e=!0;if(d&&!b.hasGroupedData&&b.visible&&b.points)if(b.cropped){if(b.xAxis){var g=
b.xAxis.min;var h=b.xAxis.max}d=b.cropData(c.xData,c.yData,g,h);for(g=0;g<d.xData.length;g++)f.push([d.xData[g]].concat(x(d.yData[g])));d=c.xData.indexOf(b.xData[0]);g=c.xData.indexOf(b.xData[b.xData.length-1]);-1===d&&g===c.xData.length-2&&f[0][0]===a[0].x&&f.shift();b.updateData(f)}else c.xData.length!==d-1&&c.xData.length!==d+1&&(e=!1,b.updateData(c.values));e&&(b.xData=c.xData,b.yData=c.yData,b.options.data=c.values);!1===b.bindTo.series&&(delete b.processedXData,b.isDirty=!0,b.redraw());b.isDirtyData=
!1}var b=this,e=b.requireIndicators();if(!e.allLoaded)return p(y(b.type,e.needed));a.prototype.init.call(b,d,c);d.linkSeries();b.dataEventsToUnbind=[];if(!b.linkedParent)return p("Series "+b.options.linkedTo+" not found! Check `linkedTo`.",!1,d);b.dataEventsToUnbind.push(m(b.bindTo.series?b.linkedParent:b.linkedParent.xAxis,b.bindTo.eventName,f));if("init"===b.calculateOn)f();else var g=m(b.chart,b.calculateOn,function(){f();g()})};e.prototype.processData=function(){var c=this.options.compareToMain,
f=this.linkedParent;a.prototype.processData.apply(this,arguments);f&&f.compareValue&&c&&(this.compareValue=f.compareValue)};e.prototype.requireIndicators=function(){var a={allLoaded:!0};this.requiredIndicators.forEach(function(d){c.seriesTypes[d]?c.seriesTypes[d].prototype.requireIndicators():(a.allLoaded=!1,a.needed=d)});return a};e.defaultOptions=v(l.defaultOptions,{name:void 0,tooltip:{valueDecimals:4},linkedTo:void 0,compareToMain:!1,params:{index:0,period:14}});return e}(l);t(a.prototype,{bindTo:{series:!0,
eventName:"updatedData"},calculateOn:"init",hasDerivedData:!0,nameComponents:["period"],nameSuffixes:[],requiredIndicators:[],useCommonDataGrouping:!0});c.registerSeriesType("sma",a);"";return a});g(a,"masters/indicators/indicators.src.js",[],function(){})});
//# sourceMappingURL=indicators.js.map