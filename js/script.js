$(document).ready(function(){
	$('body').tooltip({
		selector: '[rel=tooltip]',
		placement : 'bottom'
	});

	// layouts
	var layoutType, layoutCoefficient, layoutQuality, layoutQualityPrice;
	// uniqueLayouts
	var uniqueLayoutCount, uniqueLayoutPrice;
	// innerLayouts
	var innerLayoutCount, innerLayoutPrice;
	var totalSum = 0;
	updateHeadings();

	$('.control-group .controls input').change(function(){
		var fieldName = $(this).attr('name');
		var fieldValue = $(this).val();

		if (fieldName == 'html[layouts][type][value]') {
			layoutType = fieldValue;
		} else if (fieldName == 'html[layouts][type][coefficient]') {
			layoutCoefficient = fieldValue;
		}
		updateHeadings();
	});

	function updateHeadings() {
		$('.span3 .table').empty();
		$('.span3 .summary li:not(.nav-header)').remove();
		layoutType = $('input[name="html[layouts][type][value]"]:checked').val();
		layoutCoefficient = parseFloat($('input[name="html[layouts][type][coefficient]"]').val());
		layoutQuality = parseFloat($('input[name="html[layouts][quality][value]"]').val());
		layoutQualityPrice = parseInt($('input[name="html[layouts][quality][value]"]:checked').attr('data-price'));

		uniqueLayoutCount = parseInt($('input[name="html[unique_layouts][number][value]"]').val());
		uniqueLayoutPrice = parseInt(layoutCoefficient * $('input[name="html[unique_layouts][number][price]"]').attr('data-'+layoutType)) + layoutQualityPrice;

		innerLayoutCount = parseInt($('input[name="html[inner_layouts][number][value]"]').val());
		innerLayoutPrice = parseInt(layoutCoefficient * $('input[name="html[inner_layouts][number][price]"]').attr('data-'+layoutType)) + layoutQualityPrice;

		// layouts heading----------------------------------------------------------------------------------------------
		var layoutTypeTitle = $.trim($('input[name="html[layouts][type][value]"]:checked').parent().text()) + " тип";

		$('ul.summary').append('<li>' + layoutTypeTitle + '</li>');

		if (layoutCoefficient != 1) {
			$('ul.summary').append('<li>x' + layoutCoefficient + ' за сложность </li>');
		}

		if (layoutQualityPrice > 0) {
			$('ul.summary').append('<li>+' +layoutQualityPrice + 'руб./макет (за качество)</li>');
		} else if (layoutQualityPrice < 0) {
			$('ul.summary').append('<li>' + layoutQualityPrice + 'руб./макет (за качество)</li>');
		}

		// unique layouts heading---------------------------------------------------------------------------------------
		var uniqueLayoutSectionPrice = 0;
		var uniqueLayoutTotalPrice = parseInt(uniqueLayoutPrice * uniqueLayoutCount);

		$('ul.summary').append('<li>' + uniqueLayoutPrice + 'руб./уникальный макет</li>');

		if (uniqueLayoutCount > 0) {
			addTableCell('Уникальные макеты', uniqueLayoutCount + '*' + uniqueLayoutPrice + '=' + uniqueLayoutTotalPrice);
			uniqueLayoutSectionPrice += uniqueLayoutTotalPrice;
		}

		$('#tab_html_unique_layouts .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			var title = $('.control-label[for="' + $(element).attr('id') + '"]').text();
			var price = parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
			if ($(element).is(".per_element")) {
				price *= parseInt($('input[name="' + $(element).attr('id') + '[count]"]').val());
			}
			uniqueLayoutSectionPrice += price;
			addTableCell(title, price);
		});

		// inner layouts heading----------------------------------------------------------------------------------------
		var innerLayoutSectionPrice = 0;
		var innerLayoutTotalPrice = parseInt(innerLayoutPrice * innerLayoutCount);
		var innerLayoutTabsCount = parseInt($('input[name="html[inner_layouts][inner_tabs][value]"]').val());
		var innerLayoutTabsCoefficient = parseFloat($('input[name="html[inner_layouts][inner_tabs][coefficient]"]').val());
		var innerLayoutTabsPrice = parseInt(innerLayoutTabsCoefficient * innerLayoutPrice);
		var innerLayoutTabsTotalPrice = parseInt(innerLayoutTabsCount * innerLayoutTabsPrice);

		$('ul.summary').append('<li>' + innerLayoutPrice + 'руб./внутренний макет</li>')

		if (innerLayoutCount > 0) {
			addTableCell('Внутренние макеты', innerLayoutCount + '*' + innerLayoutPrice + '=' + innerLayoutTotalPrice);
			innerLayoutSectionPrice += innerLayoutTotalPrice;
		}

		$('#tab_html_inner_layouts .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			var title = $('.control-label[for="' + $(element).attr('id') + '"]').text();
			var price = parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
			if ($(element).is(".per_element")) {
				price *= parseInt($('input[name="' + $(element).attr('id') + '[count]"]').val());
			}
			innerLayoutSectionPrice += price;
			addTableCell(title, price);
		});

		if (innerLayoutTabsCount > 0) {
			addTableCell('Внутренние табы', innerLayoutTabsCount + '*' + innerLayoutTabsPrice + '=' + innerLayoutTabsTotalPrice);
			innerLayoutSectionPrice += innerLayoutTabsTotalPrice;
		}

		// compatibility heading----------------------------------------------------------------------------------------
		var compatibilitySectionPrice = 0;

		$('#tab_html_compatibility .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			var title = $('.control-label[for="' + $(element).attr('id') + '"]').text();
			var price = parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
			if ($(element).is(".per_element")) {
				price *= parseInt($('input[name="' + $(element).attr('id') + '[count]"]').val());
			} else if ($(element).is(".per_layout")) {
				price *= innerLayoutCount + uniqueLayoutCount;
			}
			compatibilitySectionPrice += price;
			addTableCell(title, price);
		});

		// other params heading-----------------------------------------------------------------------------------------
		var otherParamsSectionPrice = 0;

		$('#tab_html_other_params .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			var title = $('.control-label[for="' + $(element).attr('id') + '"]').text();
			var price = parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
			if ($(element).is(".per_element")) {
				price *= parseInt($('input[name="' + $(element).attr('id') + '[count]"]').val());
			}
			otherParamsSectionPrice += price;
			addTableCell(title, price);
		});

		// speed optimization heading-----------------------------------------------------------------------------------
		var speedOptimizationSectionPrice = 0;

		$('#tab_html_speed_optimization .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			var title = $('.control-label[for="' + $(element).attr('id') + '"]').text();
			var price = parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
			if ($(element).is(".per_element")) {
				price *= parseInt($('input[name="' + $(element).attr('id') + '[count]"]').val());
			}
			speedOptimizationSectionPrice += price;
			addTableCell(title, price);
		});

		// total js heading---------------------------------------------------------------------------------------------
		var totalJsSectionPrice = 0;

		$('#tab_javascript_total_js .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			var title = $('.control-label[for="' + $(element).attr('id') + '"]').text();
			var price = parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
			if ($(element).is(".per_element")) {
				price *= parseInt($('input[name="' + $(element).attr('id') + '[count]"]').val());
			}
			totalJsSectionPrice += price;
			addTableCell(title, price);
		});

		totalSum = uniqueLayoutSectionPrice + innerLayoutSectionPrice + compatibilitySectionPrice + otherParamsSectionPrice + speedOptimizationSectionPrice + totalJsSectionPrice;
		if (totalSum > 0) {
			$('.span3 .total_sum').text(totalSum + 'руб.');
			$('.span3 .table').append('<tr class="total_sum"><td>Итого</td><td class="price">' + totalSum + '</td></tr>');
		} else {
			$('.span3 .total_sum').text('');
		}

		if (totalSum > 0 && $('.span3.small').length == 1) {
			$('div.total_sum').css('display', 'block');
		} else {
			$('div.total_sum').css('display', 'none');
		}
	}

	function addTableCell(title, price) {
		if (price !== 0 ) {
			$('.span3 .table').append('<tr><td>' + title + '</td><td class="price">' + price + '</td></tr>');
		}
	}

	// TODO: use jQuery.on
	$('.btn[name="add_element"]').live('click', function(){
		var currentElement = $(this).parents('.help-block');
		if ($(this).parents('.controls').find('.btn[name="add_element"]').length == 1) {
			currentElement.find('.btn[name="remove_element"]').removeAttr('disabled');
		}
		currentElement.after('<div class="help-block">' + currentElement.html() + '</div>');
	});

	$('.btn[name="remove_element"]').live('click', function(){
		var currentElement = $(this).parents('.help-block');
		if ($(this).parents('.controls').find('.btn[name="add_element"]').length == 2) {
			$(this).parents('.controls').find('.btn[name="remove_element"]').attr('disabled', 'disabled');
		}
		currentElement.remove();
	});

	$('.change-size').click(function(){
		$(this).toggleClass("icon-resize-small icon-resize-full");
		$(this).parents('.span3').toggleClass("small");
		$(this).parents('.span3').prev().toggleClass("span6 span9");
		if (totalSum > 0 && $('.span3.small').length == 1) {
			$('div.total_sum').css('display', 'block');
		} else {
			$('div.total_sum').css('display', 'none');
		}
	});

	// Сохранение товара
	/*
	$('.btn[name="send_makeup"]').live('click', function(e){
		e.preventDefault();
		var form = $(this).parents('form');
		$.post(
			"/",
			{
				fields: form.serializeArray()
			},
			function(dataFinal) {
				console.log(dataFinal);
			}
		);
	});
*/
	// TODO: подсвечивать поля, когда они не заполнены / некорректно заполнены
	// Error hightlight
	/*
	$('.control-group .controls input').change(function(){
		console.log(this.name + ' = ' + $(this).val());

		if ($(this).is('[name$="[value]"]') && $(this).val() == '') {
			$(this).parents('.control-group').addClass('error');
		}
	});

	$('.control-group .controls input[name$="[value]"]').each(function(indx, element){
		if ($(element).val() == '') {
			$(element).parents('.control-group').addClass('error');
		}
	});*/
});