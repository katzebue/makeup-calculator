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

		$(this).parents('.control-group').find('.control-price').text($(this).val());

		if (fieldName == 'html[layouts][type][value]') {
			layoutType = fieldValue;
		} else if (fieldName == 'html[layouts][type][coefficient]') {
			layoutCoefficient = fieldValue;
		}
		updateHeadings();
	});

	function updateHeadings() {
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
		var layoutQualityTitle = '';

		if (layoutCoefficient != 1) {
			layoutTypeTitle += " (x" + layoutCoefficient + " за сложность)";
		}

		if (layoutQualityPrice > 0) {
			layoutQualityTitle = " +" + layoutQualityPrice + "руб./макет (за качество)";
		} else if (layoutQualityPrice < 0) {
			layoutQualityTitle = " " + layoutQualityPrice + "руб./макет (за качество)";
		}

		$('.accordion-heading a[href="#collapse_layouts"] .agenda').text(layoutTypeTitle + " " + layoutQualityTitle);

		// unique layouts heading---------------------------------------------------------------------------------------
		var uniqueLayoutSectionPrice = 0;
		var uniqueLayoutTitle = uniqueLayoutPrice + "руб./макет";
		var uniqueLayoutTotalPrice = parseInt(uniqueLayoutPrice * uniqueLayoutCount);
		var uniqueLayoutComplexBackground = 0;
		var uniqueLayoutComplexPositioning = 0;

		if (uniqueLayoutCount > 0) {
			uniqueLayoutTitle += " * " + uniqueLayoutCount + "шт. = " + uniqueLayoutTotalPrice + "руб.";
			uniqueLayoutSectionPrice += uniqueLayoutTotalPrice;
		}

		if ($('input[name="html[unique_layouts][complex_background][value]"]').is(":checked")) {
			uniqueLayoutComplexBackground = parseInt($('input[name="html[unique_layouts][complex_background][price]"]').val());
			uniqueLayoutSectionPrice += uniqueLayoutComplexBackground;
		}

		if ($('input[name="html[unique_layouts][complex_positioning][value]"]').is(":checked")) {
			uniqueLayoutComplexPositioning = parseInt($('input[name="html[unique_layouts][complex_positioning][price]"]').val());
			uniqueLayoutSectionPrice += uniqueLayoutComplexPositioning;
		}

		$('.accordion-heading a[href="#collapse_unique_layouts"] .agenda').text(uniqueLayoutTitle);

		if (uniqueLayoutSectionPrice > 0) {
			$('.accordion-heading a[href="#collapse_unique_layouts"] .price').text(uniqueLayoutSectionPrice + "руб.");
		} else {
			$('.accordion-heading a[href="#collapse_unique_layouts"] .price').text("");
		}

		// inner layouts heading----------------------------------------------------------------------------------------
		var innerLayoutSectionPrice = 0;
		var innerLayoutTitle = innerLayoutPrice + "руб./макет";
		var innerLayoutTotalPrice = parseInt(innerLayoutPrice * innerLayoutCount);
		var innerLayoutTabsCount = parseInt($('input[name="html[inner_layouts][inner_tabs][value]"]').val());
		var innerLayoutTabsCoefficient = parseFloat($('input[name="html[inner_layouts][inner_tabs][coefficient]"]').val());
		var innerLayoutTabsPrice = parseInt(innerLayoutTabsCoefficient * innerLayoutPrice);
		var innerLayoutTabsTotalPrice = parseInt(innerLayoutTabsCount * innerLayoutTabsPrice);
		var innerLayoutChangeGrid = 0;

		if (innerLayoutCount > 0) {
			innerLayoutTitle += " * " + innerLayoutCount + "шт. = " + innerLayoutTotalPrice + "руб.";
			innerLayoutSectionPrice += innerLayoutTotalPrice;
		}

		if ($('input[name="html[inner_layouts][change_grid][value]"]').is(":checked")) {
			innerLayoutChangeGrid = parseInt($('input[name="html[inner_layouts][change_grid][price]"]').val());
			innerLayoutSectionPrice += innerLayoutChangeGrid;
		}

		if (innerLayoutTabsCount > 0) {
			innerLayoutTitle += " " + innerLayoutTabsPrice + "руб./таб * " + innerLayoutTabsCount + "шт. = " + innerLayoutTabsTotalPrice + "руб.";
			innerLayoutSectionPrice += innerLayoutTabsTotalPrice;
		}

		$('.accordion-heading a[href="#collapse_inner_layouts"] .agenda').text(innerLayoutTitle);

		if (innerLayoutSectionPrice > 0) {
			$('.accordion-heading a[href="#collapse_inner_layouts"] .price').text(innerLayoutSectionPrice + "руб.");
		} else {
			$('.accordion-heading a[href="#collapse_inner_layouts"] .price').text("");
		}

		// compatibility heading----------------------------------------------------------------------------------------
		var compatibilitySectionPrice = 0;

		$('#collapse_compatibility .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			if ($(element).is(".per_layout")) {
				compatibilitySectionPrice += parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val()) * (innerLayoutCount + uniqueLayoutCount);
			} else {
				compatibilitySectionPrice += parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
			}
		});

		if (compatibilitySectionPrice > 0) {
			$('.accordion-heading a[href="#collapse_compatibility"] .price').text(compatibilitySectionPrice + "руб.");
		} else {
			$('.accordion-heading a[href="#collapse_compatibility"] .price').text("");
		}

		// other params heading-----------------------------------------------------------------------------------------
		var otherParamsSectionPrice = 0;

		$('#collapse_other_params .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			if ($(element).is(".per_element")) {
				otherParamsSectionPrice += parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val()) * parseInt($('input[name="' + $(element).attr('id') + '[count]"]').val());
			} else {
				otherParamsSectionPrice += parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
			}
		});

		if (otherParamsSectionPrice > 0) {
			$('.accordion-heading a[href="#collapse_other_params"] .price').text(otherParamsSectionPrice + "руб.");
		} else {
			$('.accordion-heading a[href="#collapse_other_params"] .price').text("");
		}

		// speed optimization heading-----------------------------------------------------------------------------------
		var speedOptimizationSectionPrice = 0;

		$('#collapse_speed_optimization .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			speedOptimizationSectionPrice += parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
		});

		if (speedOptimizationSectionPrice > 0) {
			$('.accordion-heading a[href="#collapse_speed_optimization"] .price').text(speedOptimizationSectionPrice + "руб.");
		} else {
			$('.accordion-heading a[href="#collapse_speed_optimization"] .price').text("");
		}

		// total js heading---------------------------------------------------------------------------------------------
		var totalJsSectionPrice = 0;

		$('#collapse_total_js .control-group .controls .checkbox.inline input:checked').each(function(indx, element){
			if ($(element).is(".per_element")) {
				totalJsSectionPrice += parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val()) * parseInt($('input[name="' + $(element).attr('id') + '[count]"]').val());
			} else {
				totalJsSectionPrice += parseInt($('input[name="' + $(element).attr('id') + '[price]"]').val());
			}
		});

		if (totalJsSectionPrice > 0) {
			$('.accordion-heading a[href="#collapse_total_js"] .price').text(totalJsSectionPrice + "руб.");
		} else {
			$('.accordion-heading a[href="#collapse_total_js"] .price').text("");
		}

		totalSum = uniqueLayoutSectionPrice + innerLayoutTotalPrice + compatibilitySectionPrice + otherParamsSectionPrice + speedOptimizationSectionPrice + totalJsSectionPrice;
		if (totalSum > 0) {
			$('.total_sum').text('Итого: ' + totalSum + 'руб.');
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