'use strict';
var threeSelectData = null;
/*var threeSelectData={
	
	"a":{
		name:"江苏省高级人民法院",
		items:{
			"a":{
				name:"南京市中级人民法院",
				items: {
				"a":"玄武区人民法院",
				"b":"白下区人民法院",
				"c":"秦淮区人民法院",
				"d":"建邺区人民法院",
				"e":"六合区人民法院",
				"f":"浦口区人民法院",
				"g":"雨花台区人民法院",
				"h":"高淳人民法院",
				}
			},
			"b":{
				name:"徐州市中级人民法院",
				items: {
				"a":"徐州xx区人民法院1",
				"b":"徐州xx区人民法院2",
				"c":"徐州xx区人民法院3",
				}
			}
		}
	},
	
};*/

/*全局变量*/
/*当前选择高院、中院的索引和当前法院名称*/
var cur_gy, cur_zy, selected_fy = "";

/*初始化中院*/
function show_zy(json_ele,court_id) {
	if(court_id){
          $.each(json_ele, function (key, value) {
			//if(key== cur_zy){
			if (value.id == court_id) {
				$('#xzfy_court_id').val(value.id);
				$('.zy').append("<li class='selected zy_li' data-id='"+value.id+"' onclick='choose_zy()'>" + value.name + "</li>");
			}
			else {
				$('.zy').append("<li class='zy_li'  data-id='"+value.id+"' onclick='choose_zy()'>" + value.name + "</li>");
			}

		});
       }else{
         $.each(json_ele, function (key, value) {
			if (value.name == selected_fy) {
				$('#xzfy_court_id').val(value.id);
				$('.zy').append("<li class='selected zy_li' data-id='"+value.id+"' onclick='choose_zy()'>" + value.name + "</li>");
			}
			else {
				$('.zy').append("<li class='zy_li'  data-id='"+value.id+"' onclick='choose_zy()'>" + value.name + "</li>");
			}

		});
       }
    
}

/*初始化中院*/
function show_zylian(json_ele,xzfy_court_id,court_id) {
	if(court_id && ! xzfy_court_id){
        $.each(json_ele, function (key, value) {
        //if(key== cur_zy){
        if (value.id == court_id) {
			$('#xzfy_court_id').val(value.id);
            $('.zy').append("<li class='selected zy_li' data-id='"+value.id+"' onclick='choose_zy()'>" + value.name + "</li>");
        }
        else {
            $('.zy').append("<li class='zy_li'  data-id='"+value.id+"' onclick='choose_zy()'>" + value.name + "</li>");
        }

    });
    }else{

        $.each(json_ele, function (key, value) {
        //if(key== cur_zy){
        if (value.id == xzfy_court_id) {

			$('#xzfy_court_id').val(value.id);
            $('.zy').append("<li class='selected zy_li' data-id='"+value.id+"' onclick='choose_zy()'>" + value.name + "</li>");
        }
        else {
            $('.zy').append("<li class='zy_li'  data-id='"+value.id+"' onclick='choose_zy()'>" + value.name + "</li>");
        }

    });
    }
    
}

/*初始化基院*/
function show_jy(json_ele,court_id) {
	if(court_id){
         $.each(json_ele, function (n, value) {
			if (value.id == court_id) {
				$('#xzfy_court_id').val(value.id);
				$('.jy').append("<li class='selected jy_li'  data-id='"+value.id+"' onclick='choose_jy()'>" + value.name + "</li>");
			}
			else {
				$('.jy').append("<li class='jy_li'  data-id='"+value.id+"' onclick='choose_jy()'>" + value.name + "</li>");
			}
		});
       }else{
         $.each(json_ele, function (n, value) {
			if (value.name == selected_fy) {
				$('#xzfy_court_id').val(value.id);
				$('.jy').append("<li class='selected jy_li'  data-id='"+value.id+"' onclick='choose_jy()'>" + value.name + "</li>");
			}
			else {
				$('.jy').append("<li class='jy_li'  data-id='"+value.id+"' onclick='choose_jy()'>" + value.name + "</li>");
			}
		});
       }
    
}

/*初始化基院*/
function show_jylian(json_ele,xzfy_court_id,court_id) {
    if(court_id && ! xzfy_court_id){
         $.each(json_ele, function (n, value) {
        if (value.id == court_id) {
			$('#xzfy_court_id').val(value.id);
            $('.jy').append("<li class='selected jy_li'  data-id='"+value.id+"' onclick='choose_jy()'>" + value.name + "</li>");
        }
        else {
            $('.jy').append("<li class='jy_li'  data-id='"+value.id+"' onclick='choose_jy()'>" + value.name + "</li>");
        }
    });
    }else{
         $.each(json_ele, function (n, value) {
        if (value.id == xzfy_court_id) {
			$('#xzfy_court_id').val(value.id);
            $('.jy').append("<li class='selected jy_li'  data-id='"+value.id+"' onclick='choose_jy()'>" + value.name + "</li>");
        }
        else {
            $('.jy').append("<li class='jy_li'  data-id='"+value.id+"' onclick='choose_jy()'>" + value.name + "</li>");
        }
    });
    }
   
}


/*选择高院*/
function choose_gy() {
	$('#xzfy_court_id').val($(event.target).data('id'));
	
    $(".selected").removeClass('selected');
    $(event.target).addClass("selected");
    selected_fy = $(event.target).html();

    $.each(threeSelectData, function (key, value) {
        if (value.name == selected_fy) {
            
            cur_gy = key;
            cur_zy = 0;
            $(".zy").empty();
            $(".jy").empty();
            show_zy(value.items);
            show_jy(value.items[0].items);
            return;
        }
    });
}

/*选择中院*/
function choose_zy() {
	$('#xzfy_court_id').val($(event.target).data('id'));
    $(".selected").removeClass('selected');
    $(event.target).addClass("selected");
    selected_fy = $(event.target).html();
    $.each(threeSelectData[cur_gy].items, function (key, value) {
        if (value.name == selected_fy) {
            cur_zy = key;
            $(".jy").empty();
            show_jy(value.items);
            return;
        }
    });
}

/*选择基院*/
function choose_jy() {
	$('#xzfy_court_id').val($(event.target).data('id'));
    $(".selected").removeClass('selected');
    $(event.target).addClass("selected");

    selected_fy = $(event.target).text();
}

//如果当前选择的法院不再可视区，滚动滚动条使其可见
function show_scrollTop(){
    var li_height = $(".gy_li").outerHeight();                  //li的高度，包括border;
    var ul = $(".selected").parent();                           
    var index = 0;                                              //记录第几个li被选中
    for(var i=1; i <= ul.children().length; i++){
        if($(ul.children()[i-1]).hasClass("selected")){
            index = i;
            break;
        }
    }

    if(index>7){                                                //不在可视区
        var top = (index - 7)*li_height*2;
        ul.parent().scrollTop(top);                             //滚动条下移
    }
}


//民商事一审流程选择法院、保存法院数据方法
function save_lasq_xzfy(val) {
    console.log(val);
    setCookie("yylasq_xzfy", JSON.stringify(val));

    var form_data = get_lasq_form_base();
    form_data.fymc = val.selected_fy;
	form_data.court_id = val.court_id;
    save_lasq_form_base(form_data);
}
function get_lasq_xzfy() {
    var form_data = getCookie("yylasq_xzfy");
    if (form_data === null) {
        form_data = {};
    } else {
        form_data = JSON.parse(form_data);
    }
    return form_data;
}

//执行案件流程选择法院、保存法院数据方法
function save_lasq_xzfy_zxaj(val) {
    console.log(val);
    setCookie("yylasq_xzfy_zxaj", JSON.stringify(val));

    var form_data = get_lasq_form_base_zxaj();
    form_data.fymc = val.selected_fy;
    form_data.court_id = val.court_id;
    save_lasq_form_base_zxaj(form_data);
}
function get_lasq_xzfy_zxaj() {
    var form_data = getCookie("yylasq_xzfy_zxaj");
    if (form_data === null) {
        form_data = {};
    } else {
        form_data = JSON.parse(form_data);
    }
    return form_data;
}

// ======================================================================
//行政案件流程选择法院、保存法院数据方法
function save_lasq_xzfy_xzaj(val) {
    console.log(val);
    setCookie("yylasq_xzfy_xzaj", JSON.stringify(val));

    var form_data_xzaj = get_lasq_form_base_xzaj();
    form_data_xzaj.fymc = val.selected_fy;
    form_data_xzaj.court_id = val.court_id;
    save_lasq_form_base_xzaj(form_data_xzaj);
}
function get_lasq_xzfy_xzaj() {
    var form_data_xzaj= getCookie("yylasq_xzfy_xzaj");
    if (form_data_xzaj === null) {
        form_data_xzaj = {};
    } else {
        form_data_xzaj = JSON.parse(form_data_xzaj);
    }
    return form_data_xzaj;
}
// ===================================================================

function save_ggxx_xzfy(val) {
    console.log(val);
    setCookie("ggxx_xzfy", JSON.stringify(val));
}
function get_ggxx_xzfy() {
    var form_data = getCookie("ggxx_xzfy");
    if (form_data === null) {
        form_data = {};
    } else {
        form_data = JSON.parse(form_data);
    }
    return form_data;
}

function  get_court_id(){
     var court_id = getCookie("court_id");
     if(court_id){
     court_id = court_id;
     }else{
     court_id = global_data.court_id;
     }
    return court_id;
}







































