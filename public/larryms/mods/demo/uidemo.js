layui.define(['larryms', 'code'], function(exports) {
	var $ = layui.$,
		larryms = layui.larryms,
		layer = layui.layer,
		code = layui.code;
	if (layui.cache.identified == 'color') {
		layui.use('colorpicker', function() {
			var colorpicker = layui.colorpicker;
			colorpicker.render({
				elem: '#inputColor',
				color: '#1c97f5',
				done: function(color) {
					$('#test-form-input').val(color);
				},
				change: function(color) {
					$('#colorTest').css('color', color);
				}
			});
			//rgba
			colorpicker.render({
				elem: '#rgba1',
				color: 'rgba(68,66,66,0.5)',
				format: 'rgb',
				alpha: true, //开启透明度滑块
				done: function(color) {
					$('#test-form-input2').val(color);
				},
				change: function(color) {
					$('#colorTest').css('color', color);
				}
			});

			colorpicker.render({
				elem: '#test',
				color: 'rgba(2,206,209,1)',
				format: 'rgb',
				alpha: true,
				predefine: true, // 开启预定义颜色
				done: function(color) {
					$('#test-form-input3').val(color);
					larryms.tips('您设置的颜色值为：' + color, this.elem + '此处至作为演示，您动态改变的主题色重置为当前主题');
					$('#larry_left .layui-side-scroll', window.parent.document).removeAttr("style");
					$('#larry_head', window.parent.document).removeAttr("style");
					$('#larry_head .larryms-this', window.parent.document).removeAttr("style");
				},
				change: function(color) {
					$('#colorTest').css('color', color);
					//设置顶部导航
					$('#larry_head', window.parent.document).css('background-color', color);
					$('#larry_head .larryms-this', window.parent.document).css('background-color', color);
					$('#larry_left .layui-side-scroll', window.parent.document).css('background-color', color);
				}
			});
			$('#resetTheme').on('click', function() {
				$('#larry_left .layui-side-scroll', window.parent.document).removeAttr("style");
				$('#larry_head', window.parent.document).removeAttr("style");
				$('#larry_head .larryms-this', window.parent.document).removeAttr("style");
			});
		});
	} else if (layui.cache.identified == 'hover') {
		layui.use('clipboard', function() {
			var clipboard = layui.clipboard;
			$('.hover').find('a').each(function(k, v) {
				$(v).attr('data-clipboard-text', $(v).attr('class'));
			});

			var btns = document.querySelectorAll('a');
			var clipboard = new clipboard(btns);
			clipboard.on('success', function(e) {
				larryms.msg('已成功复制 ' + e.text + ' 到剪贴板可直接使用');
			});
		});
	} else if (layui.cache.identified == 'animate') {
		larryms.plugin('jquery-migrate.min', function() {
			if ($.browser.msie && $.browser.version < 10) {
				$(".no-show").show();
			}
			var animObj = $("#animate");
			var $li = $(".tabCnt").find("li");
			$li.click(function() {
				$(this).addClass("active").siblings().removeClass("active");
				animObj.removeClass().addClass($(this).text() + " animated infinite");
				setTimeout(removeStyle, 1e3)
			});

			function removeStyle() {
				animObj.removeClass()
			}

			var $a = $(".tabNav").find("a");
			var $tab = $(".tabPane");
			$a.each(function(i) {
				$(this).click(function() {
					$(this).parent().addClass("active").siblings().removeClass("active");
					$tab.eq(i).addClass("active").siblings().removeClass("active");
					return false
				})
			});
		});
		layui.use('clipboard', function() {
			var clipboard = layui.clipboard;
			$('.tabCnt ul').find('li').each(function(k, v) {
				$(v).attr('data-clipboard-text', $(v).text());
			});
			var btns = document.querySelectorAll('li');
			var clipboard = new clipboard(btns);
			clipboard.on('success', function(e) {
				setTimeout(function() {
					larryms.msg('已成功复制动画class名称 ' + e.text + ' 到剪贴板可直接使用', {
						offset: 'b'
					});
				}, 800);
			});
		});
	}  else if (layui.cache.identified == 'select') {
		layui.use(['form', 'selectN', 'selectM'], function() {
			var $ = layui.$,
				form = layui.form,
				selectN = layui.selectN,
				selectM = layui.selectM;
			var tagData = [{
					"id": 12,
					"name": "长者",
					"status": 0
				}, {
					"id": 13,
					"name": "工厂"
				}, {
					"id": 14,
					"name": "小学生"
				}, {
					"id": 15,
					"name": "大学生"
				}, {
					"id": 16,
					"name": "研究生"
				}, {
					"id": 17,
					"name": "教师"
				}, {
					"id": 18,
					"name": "记者"
				}],
				catData = [{
					"id": 1,
					"name": "周边旅游",
					"children": [{
						"id": 24,
						"name": "广东",
						"status": 0,
						"children": [{
							"id": 7,
							"name": "广州"
						}, {
							"id": 23,
							"name": "潮州"
						}]
					}]
				}, {
					"id": 5,
					"name": "国内旅游",
					"children": [{
						"id": 8,
						"name": "华北地区",
						"children": [{
							"id": 9,
							"name": "北京"
						}]
					}]
				}, {
					"id": 6,
					"name": "出境旅游",
					"children": [{
						"id": 10,
						"name": "东南亚",
						"children": [{
							"id": 11,
							"name": "马来西亚",
							"children": [{
								"id": 20,
								"name": "沙巴",
								"children": [{
									"id": 21,
									"name": "美人鱼岛",
									"children": [{
										"id": 22,
										"name": "潜水"
									}]
								}]
							}]
						}]
					}]
				}];
			//无限级分类-基本配置
			var catIns1 = selectN({
				//元素容器【必填】
				elem: '#cat_ids1',
				search: [false, true]
					//候选数据【必填】
					,
				data: catData
			});


			//无限级分类-所有配置
			var catIns2 = selectN({
				//元素容器【必填】
				elem: '#cat_ids2'
					//候选数据【必填】
					,
				data: catData
					//设置了长度
					,
				width: null
					//默认值
					,
				selected: [6, 10, 11]

					//为真只取最后一个值
					,
				last: true

					//空值项提示，可设置为数组['请选择省','请选择市','请选择县']
					,
				tips: '请选择'

					//事件过滤器，lay-filter名 不设置与选择器相同(去#.)
					,
				filter: ''

					//input的name 不设置与选择器相同(去#.)
					,
				name: 'cat2'

					//数据分隔符
					,
				delimiter: ','

					//数据的键名
					,
				field: {
					idName: 'id',
					titleName: 'name',
					childName: 'children'
				}

				//表单区分 form.render(type, filter); 为class="layui-form" 所在元素的 lay-filter="" 的值 
				,
				formFilter: null

			});


			//多选标签-基本配置
			var tagIns1 = selectM({
				//元素容器【必填】
				elem: '#tag_ids1'
					//候选数据【必填】
					,
				data: tagData,
				max: 2,
				width: 400
					//添加验证
					,
				verify: 'required'
			});


			//多选标签-所有配置
			var tagIns2 = selectM({
				//元素容器【必填】
				elem: '#tag_ids2'

					//候选数据【必填】
					,
				data: tagData

					//默认值
					,
				selected: [12, 17]

					//最多选中个数，默认5
					,
				max: 1000

					//input的name 不设置与选择器相同(去#.)
					,
				name: 'tag2'

					//值的分隔符
					,
				delimiter: ','

					//候选项数据的键名
					,
				field: {
					idName: 'id',
					titleName: 'name'
				}


			});
			form.on('submit(demo)', function(data) {
				larryms.msg("您提交的表单数据为：" + JSON.stringify(data.field));
				return false;
			});
			layui.code({
				skin: 'notepad',
				about: false,
				elem: ".layui-code",
				encode: true
			});

		});


	} else if (layui.cache.identified == 'dtree') {
		layui.use(['table', 'dtree'], function() {
			var table = layui.table,
				dtree = layui.dtree;
			var dataUrl = $('#adminuser').data('url'),
				userList = table.render({
					elem: '#adminuser',
					id: "adminuser",
					cellMinWidth: 95,
					url: dataUrl,
					method: 'post',
					page: true,
					limits: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
					limit: 10,
					cols: [
						[{
							type: "checkbox",
							fixed: 'left',
							width: 50
						}, {
							field: 'uname',
							title: '用户名',
							minWidth: 80,
							align: 'center'
						}, {
							field: 'title',
							title: '所属组别',
							align: 'center',
							minWidth: 80
						}, {
							field: 'status',
							title: '用户状态',
							align: 'center',
							minWidth: 60,
							templet: function(d) {
								return d.status == "1" ? "正常" : "禁止登录";
							}
						}, {
							field: 'login_num',
							title: '登录次数',
							align: 'center',
							minWidth: 60
						}, {
							field: 'last_login_time',
							title: '最近登录时间',
							align: 'center',
							minWidth: 100,
							templet: function(d) {
								return d.last_login_time !== "undefined" ? d.last_login_time : "<span class='except-text'>从未登录过</span>";
							}
						}, {
							field: 'last_login_ip',
							title: '最后登录IP',
							align: 'center',
							minWidth: 80
						}, {
							field: 'create_time',
							title: '创建时间',
							align: 'center',
							minWidth: 100
						}, {
							title: '操作',
							minWidth: 115,
							templet: '#userListBar',
							fixed: "right",
							align: "center"
						}]
					]
				});

			// 监听工具条
			table.on('tool(adminuser)', function(obj) {
				var data = obj.data;

				if (obj.event == 'edit') {
					var url = $(this).data('url') + '?id=' + data.id;
					larryms.alert("您正在编辑的用户信息是：" + JSON.stringify(data));
				} else if (obj.event == 'del') {
					var url = $(this).data('url');
					larryms.confirm('你确定要删除该条数据吗？', {
						icon: 3,
						title: '删除提示'
					}, function() {
						// var ids = {"id":data.id};
						// $.post(url,ids,function(res){
						//     if(res.code==200){
						//         larryms.msg(res.msg);
						//         table.reload(pageTableID,{});
						//     }else{
						//        larryms.msg(res.msg);
						//     }
						// });
						larryms.msg("您删除了：" + JSON.stringify(data));
					});
				}
			});
			var dtreeUrl = $('#dtree').data('url');
			dtree.render({
				elem: "#dtree",
				url: dtreeUrl,
				icon: "1"
			});

			dtree.on("node('dtree')" ,function(param){
	  			larryms.msg(JSON.stringify(param));
			});

		});
	}

	exports('uidemo', {});
});