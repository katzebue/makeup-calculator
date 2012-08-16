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

			<div class="row">
				<div class="span3 well">
					<ul class="nav nav-list">
						<? foreach ($calculatorParams as $calculatorTypeKey => $calculatorType) :?>
							<li class="nav-header"><?=$calculatorTypeKey?></li>

							<? foreach ($calculatorType as $calculatorSectionKey => $calculatorSection) :?>
								<li<?if (reset($calculatorType) == $calculatorSection && reset($calculatorParams) == $calculatorType) :?> class="active"<? endif; ?>>
									<a data-toggle="tab" href="#tab_<?=$calculatorTypeKey?>_<?=$calculatorSectionKey?>">
										<?=$calculatorSection['title']?>
									</a>
								</li>

								<?if (end($calculatorParams) != $calculatorType && end($calculatorType) == $calculatorSection) :?>
									<li class="divider"></li>
								<? endif; ?>
							<? endforeach; ?>

						<? endforeach; ?>
					</ul>
				</div>

				<div class="span6">

					<form class="form-horizontal calculator">
						<div class="tab-content">
						<? foreach ($calculatorParams as $calculatorTypeKey => $calculatorType) :?>
							<? foreach ($calculatorType as $calculatorSectionKey => $calculatorSection) :?>
								<div class="tab-pane<?if (reset($calculatorType) == $calculatorSection && reset($calculatorParams) == $calculatorType) :?> active<? endif ?>"
								     id="tab_<?=$calculatorTypeKey?>_<?=$calculatorSectionKey?>">

									<h2><?=$calculatorSection['title']?></h2>

									<fieldset>

										<? foreach ($calculatorSection['params'] as $paramKey => $param) :
										$fieldName = $calculatorTypeKey.'['.$calculatorSectionKey.']['.$paramKey.']';
										?>

										<div class="control-group">
											<label class="control-label" for="<?=$fieldName?>"><strong><?=$param['title']?></strong></label>

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
														<input class="input-micro" type="text" name="<?=$fieldName?>[value]" id="<?=$fieldName?>" value="<?=empty($param['value']) ? '0' : $param['value']?>"
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
																><input class="input-micro" type="text" name="<?=$fieldName?>[coefficient]" value="<?=empty($param['coefficient_value']) ? '1' : $param['coefficient_value']?>" />
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
															<input class="input-micro" type="text" name="<?=$fieldName?>[price]" value="<?=$param['price']?>"
																<?if (empty($param['editable'])) :?>disabled<? endif;?>
																/><span class="add-on">руб.<? if (!empty($param['per_element'])) : ?>/шт.<? endif; ?><? if (!empty($param['per_layout'])) :?>/макет<? endif; ?></span>
														</div><?
													endif;
												endif;
												?>

												<? if (isset($param['element_count'])) : ?>
												<div class="input-append">
													<input class="input-micro" type="text" name="<?=$fieldName?>[count]" value="<?=$param['element_count']?>"
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
																/><button type="button" name="add_element" class="btn"><i class="icon-plus"></i></button
															><button type="button" name="remove_element" class="btn" disabled><i class="icon-remove"></i></button>
														</div>
													</div>
													<? endif; ?>
											</div>
										</div>

										<? endforeach ?>
									</fieldset>
								</div>
							<? endforeach ?>

						<? endforeach ?>
						</div>


						<!--button type="button" name="send_makeup" class="btn btn-primary btn-large">Отправить</button-->

					</form>
				</div>
				<div class="span3 well">
					<div class="total_sum"></div><i class="change-size icon-resize-small"></i>

					<ul class="nav nav-list summary">
						<li class="nav-header">Расчет</li>
					</ul>

					<table class="table table-condensed"></table>
				</div>
			</div>


		</div>

	</body>
</html>