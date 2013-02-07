var API=
{
	template:
	{
		APIExample:		null,
		APIDetails:		null,
		APIDescription:	null
	},
	init: function()
	{
		this.template.APIExample	=$('#APIExample');
		this.template.APIDetails	=$('#APIDetails');
		this.template.APIDescription=$('#APIDescription');
		
		$(window).resize(this.resizeNav);
		$(window).bind('hashchange',this.onHashChangeTest);
		$('body').on('click','[data-action="run"]',this.onClickRunExample);
		$('body').on('click','[data-action="reset"]',this.onClickResetExample);
		var ref=window.location.hash;
		this.loadPage(ref);
		this.getBreadcrumbs(ref);
		this.selectActiveNavItem(ref);
		this.resizeNav();
	},
	getTemplate: function(ref)
	{
		var template=this.template[ref].clone();
		template.attr('id',null);
		template.removeClass('template');
		return template[0].outerHTML;
	},
	loadPage: function(ref)
	{
		ref=ref.replace('#','');
		$.get
		(
			'content/'+ref,
			null,
			function(response)
			{
				$('#content').html(response);
				API.doMarkdown();
			}
		);
	},
	initEditors: function()
	{
		var exampleEditor=ace.edit($('.exampleBox .editor')[0]);
		exampleEditor.setTheme('ace/theme/tomorrow_night');
		exampleEditor.getSession().setMode('ace/mode/json');
		exampleEditor.setShowPrintMargin(false);
		exampleEditor.originalValue=exampleEditor.getValue();
		
		var resultEditor=ace.edit($('.exampleBox .result')[0]);
		resultEditor.setTheme('ace/theme/tomorrow_night');
		resultEditor.getSession().setMode('ace/mode/json');
		resultEditor.setShowPrintMargin(false);
		resultEditor.setReadOnly(true);
		resultEditor.originalValue=resultEditor.getValue();
	},
	getBreadcrumbs: function(ref)
	{
		ref=ref.replace('#','');
		$.get
		(
			'getBreadcrumbs/'+ref,
			null,
			function(response)
			{
				$('#breadcrumbs').html(response);
			}
		);
	},
	onHashChangeTest: function()
	{
		var ref=window.location.hash;
		API.loadPage(ref);
		API.getBreadcrumbs(ref);
		API.selectActiveNavItem(ref);
	},
	selectActiveNavItem: function(ref)
	{
		$('#apiNav li').removeClass('active');
		$('#apiNav li a[href="'+ref+'"]').parent('li').addClass('active');
	},
	resizeNav: function()
	{
		$('#apiNav').height($(window).innerHeight()-135)
	},
	doMarkdown: function()
	{
		var converter=new Markdown.Converter();
		converter.hooks.chain
		(
			'postConversion',
			function (text)
			{
				var keyVals			={},
					params			=[],
					details			=$(API.getTemplate('APIDetails')),
					description		=$(API.getTemplate('APIDescription')),
					foundDescription=null,
					parts			=[],
					HTML			=[];
				keyVals.call		=text.match(/\[call=([\w\.]*)\]/)[1];
				keyVals.type		=text.match(/\[type=([\w\.]*)\]/)[1];
				keyVals.parameters	=[];
				params				=text.match(/\[Parameters\]([\s\S]*)\[\/Parameters\]/);
				if (params[1]!=null)
				{
					params=params[1].split(/\n/);
					for (var i=0,j=params.length; i<j; i++)
					{
						if (params[i]!='')
						{
							parts=params[i].split('=');
							keyVals.parameters.push
							(
								[
									'<tr>',
										'<th>'+parts[0]+'</th>',
										'<td>'+parts[1]+'</td>',
									'</tr>'
								].join('')
							);
						}
					}
				}
				
				keyVals.parameters=keyVals.parameters.join('');
				
				details.find('[data-key="call"]').html(keyVals.call);
				details.find('[data-key="type"]').html(keyVals.type);
				details.find('[data-key="parameters"] tr:first').after(keyVals.parameters);
				
				foundDescription=text.match(/\[Description\]([\s\S]*)\[\/Description\]/);
				if (foundDescription)
				{
					description.find('p').html(foundDescription[1]);
				}
				
				console.debug(details.html());
				
				
				text=text	.replace(/\[call=([\w\.]*)\]/,details.html())
							.replace(/\[type=([\w\.]*)\]/,'')
							.replace(/\[Parameters\]([\s\S]*)\[\/Parameters\]/,'')
							.replace(/\[Description\]([\s\S]*)\[\/Description\]/,description.html())
							.replace
							(
								/\[APIExample\]([\s\S]*)\[\/APIExample\]/g,
								API.getTemplate('APIExample')
							);
				
				return text;
			}
		);
		$('#content').html(converter.makeHtml($('#content').html()));
		API.initEditors();
	},
	onClickRunExample: function(event)
	{
		var	exampleBox		=$(event.currentTarget).parents('.exampleBox-actionBar').siblings('.exampleBox'),
			exampleEditor	=exampleBox.find('.editor')[0].env.editor,
			resultEditor	=exampleBox.find('.result')[0].env.editor;
		$.post
		(
			'/api/',
			exampleEditor.getValue(),
			function(response)
			{
				resultEditor.setValue(JSON.stringify(response,null,2));
			}
		);
	},
	onClickResetExample: function(event)
	{
		var	exampleBox		=$(event.currentTarget).parents('.exampleBox-actionBar').siblings('.exampleBox'),
			exampleEditor	=exampleBox.find('.editor')[0].env.editor,
			resultEditor	=exampleBox.find('.result')[0].env.editor;
		exampleEditor.setValue(exampleEditor.originalValue);
		resultEditor.setValue(resultEditor.originalValue);
		exampleEditor.clearSelection();
		resultEditor.clearSelection();
	}
}

$(document).ready
(
	function()
	{
		API.init();
	}
);