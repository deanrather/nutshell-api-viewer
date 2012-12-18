var API=
{
	init: function()
	{
		$(window).resize(this.resizeNav);
		$(window).bind('hashchange',this.onHashChangeTest);
		$('#content').mutationSummary('connect',this.onDOMChange,[{ all: true }]);
		var ref=window.location.hash;
		this.loadPage(ref);
		this.getBreadcrumbs(ref);
		this.selectActiveNavItem(ref);
		this.resizeNav();
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
				var editor=ace.edit($('.exampleBox .editor')[0]);
				editor.setTheme('ace/theme/monokai');
				editor.getSession().setMode('ace/mode/json');
				
				editor.setShowPrintMargin(false);
			}
		);
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
				return text.replace(/\[Example\]([\s\S]*)\[\/Example\]/g,'<pre><code>$1</code></pre>');
			}
		);
		$('#content').html(converter.makeHtml($('#content').html()));
	},
	onDOMChange: function(result)
	{
		// var changeset=result[0];
		// console.debug(changeset);
		
	}
}

$(document).ready
(
	function()
	{
		API.init();
	}
);