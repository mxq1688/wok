'use strict';
var ftLocationData = null;
/*var ftLocationData = [
			{
				name:"一层",
				items:[
				"第一审判庭",
				"第二审判庭",
				"第三审判庭",
				"第四审判庭",
				"第五审判庭",
				"第六审判庭",
				],
				num:"1"
			}
];*/

//当前选择的楼层 法庭
var cur_floor;
var cur_fating;
var map_img; //待展示的地图图片

//选择楼层
function choose_floor(n){
	$('.floor_li').removeClass('floor_active');
	if($(event.target).hasClass("floor_li")){
		$(event.target).addClass('floor_active');
	}
	else{
		$(event.target).parent().addClass('floor_active');
	}
	//遍历所有的json,拿到当前楼层名对应的法庭列表；
	$.each(ftLocationData, function(key, value){
		if(value.num == n){
			$('.fating').empty();
			cur_fating = value.items;
			/* 选择楼层，默认展示第一个审判庭,默认第一个审判庭选中,默认展示第一个审判庭的map图片 */	
			$.each(cur_fating, function(n, value){
				if(n===0){
					$('.fating').append("<li class='fating_li fating_active' data-img='"+value.address_pic+"' onclick='choose_fating()'>"+value.name+"</li>");
					map_img = value.address_pic;
					if(map_img!==null && map_img!==""){
						$(".image").css("background","url("+map_img+") center no-repeat");
					}
				}else{
					$('.fating').append("<li class='fating_li' data-img='"+value.address_pic+"' onclick='choose_fating()'>"+value.name+"</li>");
				}
			});
		}
	});
}

	//初始化审判庭方法；
	function showFating(json_ele,spt_name){
		$.each(json_ele, function(n, value){
			if(value.name==spt_name){
				$('.fating').append("<li class='fating_li fating_active' data-img='"+value.address_pic+"' onclick='choose_fating()'>"+value.name+"</li>");
				map_img = value.address_pic; //记录当前审判庭对应的图片
			}else{
				$('.fating').append("<li class='fating_li' data-img='"+value.address_pic+"' onclick='choose_fating()'>"+value.name+"</li>");
			}
		});
	}

//选择审判庭
function choose_fating() {
    
	$('.fating_li').removeClass('fating_active');
	$(event.target).addClass('fating_active');
    $(".image").css("background","url("+$(event.target).data('img')+") center no-repeat");
    
	//选择审判庭，对应的map相应：
	//$.each(cur_fating, function(n, value){
//		if($(event.target).html() == value.name){
//			map_img = value.address_pic;
//			if(map_img!==null && map_img!==""){
//				$(".image").css("background","url("+map_img+") center no-repeat");
//			}
//			//console.log(map_img);
//		}
//
//	});
}