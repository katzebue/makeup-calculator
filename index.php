<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Параметрика</title>

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
		<? include_once 'config.php' ?>
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="/">Параметрика</a>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="page-header">
				<h1>Калькулятор
					<small>расчет стоимости верстки</small>
				</h1>
			</div>

			<? foreach ($calculatorParams as $calculatorTypeKey => $calculatorType) :?>
			<div class="<?=$calculatorTypeKey?>">
				<? foreach ($calculatorType as $calculatorSectionKey => $calculatorSection) :?>
				<div class="<?=$calculatorSectionKey?>">
					<h2><?=$calculatorSection['title']?></h2>

					<div>
						<? foreach ($calculatorSection['params'] as $paramKey => $param) :?>
							<h3><?=$param['title']?></h3>
							<?
							$fieldName = $calculatorTypeKey.'__'.$calculatorSectionKey.'__'.$paramKey;
							switch ($param['type']) :
								case 'radio' :?>
									<? foreach ($param['values'] as $valueKey => $value) :?>
										<label>
											<input type="radio" name="<?=$paramKey?>" value="<?=$valueKey?>" />
											<?=$value['title']?>
										</label>
									<? endforeach;

									if (!empty($param['coefficient'])) :
										switch ($param['coefficient']) :
											case 'float' :?>
												<div class="input-prepend">
													<span class="add-on">x</span
													><input class="span1" type="text" name="<?=$paramKey?>_coefficient" value="<?=empty($param['coefficient_value']) ? '0' : $param['coefficient_value']?>" />
												</div>
												<? break;
										endswitch;
									endif;

									break;
								case 'integer' :?>
									<div class="input-append">
										<input class="span1" type="text" name="<?=$paramKey?>" value="<?=empty($param['value']) ? '0' : $param['value']?>"
										/><span class="add-on">шт.</span>
									</div>
									<? break;
								case 'checkbox' :?>
									<label>
										<input type="checkbox" name="<?=$paramKey?>" />
										<?=$param['title']?>
									</label>
									<? if (!empty($param['price'])) :?>

									<? endif;
									break;
								default: ?>
									<pre><?=print_r($param)?></pre>
									<? break;
							endswitch ?>
						<? endforeach ?>
					</div>
				</div>
				<? endforeach ?>
			</div>
			<? endforeach ?>
		</div>

	</body>
</html>