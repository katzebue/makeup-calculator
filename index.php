<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Калькулятор верстки</title>

		<link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="/css/styles.css" rel="stylesheet">
		<!--link href="/bootstrap/css/bootstrap-responsive.css" rel="stylesheet"-->

		<link rel="shortcut icon" href="/favicon.ico">

		<!--[if lt IE 9]>
		<script type="text/javascript" src="/js/html5.js"></script>
		<![endif]-->
		<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/bootstrap/js/bootstrap.js"></script>

		<script type="text/javascript" src="/js/script.js"></script>
	</head>

	<body>
		<? include_once 'config.php';
		if (!empty($_POST)) :
			?><pre><?=print_r($_POST)?><!--div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="/">Параметрика</a>
				</div>
			</div>
		</div--></pre>
		<? endif ?>

		<div class="container">
			<div class="page-header">
				<h1>Калькулятор
					<small>расчет стоимости верстки</small>
				</h1>
			</div>

			<form class="form-horizontal calculator" method="get">
			<? foreach ($calculatorParams as $calculatorTypeKey => $calculatorType) :?>
				<div class="accordion" id="accordion_<?=$calculatorTypeKey?>">
					<? foreach ($calculatorType as $calculatorSectionKey => $calculatorSection) :?>
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_<?=$calculatorTypeKey?>" href="#collapse_<?=$calculatorSectionKey?>">
									<?=$calculatorSection['title']?>
									<span class="agenda"></span>
									<span class="price"></span>
								</a>
							</div>


							<div id="collapse_<?=$calculatorSectionKey?>" class="accordion-body collapse<?if (reset($calculatorType) == $calculatorSection) :?> in<? endif ?>">
								<div class="accordion-inner">
									<fieldset>

									<? foreach ($calculatorSection['params'] as $paramKey => $param) :
										$fieldName = $calculatorTypeKey.'['.$calculatorSectionKey.']['.$paramKey.']';
										?>

										<div class="control-group">
											<label class="control-label" for="<?=$fieldName?>"><strong><?=$param['title']?></strong></label>
											<div class="control-price"></div>

											<div class="controls">
												<? switch ($param['type']) :
													case 'radio' :?>
														<? foreach ($param['values'] as $valueKey => $value) :?>
															<label class="radio inline">
																<input type="radio" name="<?=$fieldName?>[value]" id="<?=$fieldName?>" value="<?=$valueKey?>"
																	<? if (reset($param['values']) == $value) :?>checked<? endif ?>
																	<? if (isset($value['price'])) :?>data-price="<?=$value['price']?>"<? endif ?>
																	/>
																<?=$value['title']?>
															</label>
														<? endforeach;
														break;

													case 'integer' :?>
														<div class="input-append">
															<input class="input-mini" type="text" name="<?=$fieldName?>[value]" id="<?=$fieldName?>" value="<?=empty($param['value']) ? '0' : $param['value']?>"
															/><span class="add-on">шт.</span>
														</div><?
														break;

													case 'checkbox' :?>
														<label class="checkbox inline">
															<input type="checkbox" name="<?=$fieldName?>[value]" id="<?=$fieldName?>" value="1"
																<? if (!empty($param['per_element'])) :?> class="per_element"<? endif; ?>
																<? if (!empty($param['per_layout'])) :?> class="per_layout"<? endif; ?>
															/>
															Да
														</label>

														<?
														break;

													default:
														?><pre><?=print_r($param)?></pre><?
														break;

												endswitch;

												if (!empty($param['coefficient'])) :
													switch ($param['coefficient']) :
														case 'float' :?>
															<div class="input-prepend">
																<span class="add-on" rel="tooltip" title="Коэффициент">X</span
																><input class="input-mini" type="text" name="<?=$fieldName?>[coefficient]" value="<?=empty($param['coefficient_value']) ? '1' : $param['coefficient_value']?>" />
															</div>
															<? break;
													endswitch;
												endif;

												if (!empty($param['price'])) :
													if (is_array($param['price'])) :?>
														<input type="hidden" name="<?=$fieldName?>[price]"<?
															foreach ($param['price'] as $key => $value) : ?>
																data-<?=$key?>="<?=$value?>"<?
															endforeach; ?>/><?
													elseif (is_integer($param['price'])) :?>
														<div class="input-append">
															<input class="input-mini" type="text" name="<?=$fieldName?>[price]" value="<?=$param['price']?>"
																<?if (empty($param['editable'])) :?>disabled<? endif;?>
																/><span class="add-on">руб.<? if (!empty($param['per_element'])) : ?>/шт.<? endif; ?><? if (!empty($param['per_layout'])) :?>/макет<? endif; ?></span>
														</div><?
													endif;
												endif;
												?>

												<? if (isset($param['element_count'])) : ?>
													<div class="input-append">
														<input class="input-mini" type="text" name="<?=$fieldName?>[count]" value="<?=$param['element_count']?>"
															<?if (empty($param['element_count_editable'])) :?>disabled<? endif;?>
														/><span class="add-on">шт.</span>
													</div>
												<? endif;

												if ($param['type'] == "checkbox" && !empty($param['values']) && is_array($param['values'])) :?>
												<p class="help-block">
													<select name="<?=$fieldName?>[select]">
														<? foreach ($param['values'] as $key => $element) :?>
														<option value="<?=$key?>"><?=$element['title']?></option>
														<? endforeach;?>
													</select>
												</p>
												<? endif;

												if (!empty($param['element'])) : ?>
													<p class="help-block">Названия шрифтов:</p>
													<div class="help-block">
														<div class="input-append">
															<input class="input-large" type="text" name="<?=$fieldName?>[element][]"
															/><button type="button" name="add_element" class="btn"><i class="icon-plus"></i> Добавить</button
															><button type="button" name="remove_element" class="btn" disabled><i class="icon-remove"></i></button>
														</div>
													</div>
												<? endif; ?>
											</div>
										</div>

									<? endforeach ?>
									</fieldset>
								</div>
							</div>
						</div>
					<? endforeach ?>
				</div>
			<? endforeach ?>

			<h2 class="total_sum"></h2>

			<!--button type="button" name="send_makeup" class="btn btn-primary btn-large">Отправить</button-->

			</form>
		</div>

	</body>
</html>