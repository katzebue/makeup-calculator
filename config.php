<?php

$calculatorParams = array(
	'html'  => array(
		'layouts' => array(
			'title' =>'Макеты',
			'params' => array(
				'type' => array(
					'title' => 'Тип',
					'type' => 'radio',
					'values' => array(
						'static' => array (
							'title' => 'Статический'
						),
						'rubber' => array (
							'title' => 'Резиновый'
						),
						'adaptive' => array (
							'title' => 'Адаптивный'
						)
					),
					'coefficient' => 'float'
				),
				'quality' => array(
					'title' => 'Качество макетов',
					'type' => 'radio',
					'values' => array(
						'one_star' => array (
							'title' => 'Низкое',
							'price' => 300,
						),
						'two_stars' => array (
							'title' => 'Среднее',
							'price' => 200
						),
						'three_stars' => array (
							'title' => 'Высокое',
							'price' => 100
						),
					),
					'per_layout' => true,
					'decrement' => true
				)
			)
		),
		'unique_layouts' => array(
			'title' => 'Уникальные макеты',
			'params' => array(
				'number' => array(
					'title' => 'Количество',
					'type' => 'integer',
					'price' => array(
						'static' => 1500,
						'rubber' => 1700,
						'adaptive' => 1800
					),
					'per_unique_layout' => true
				),
				'complex_background' => array(
					'title' => 'Сложный фон',
					'type' => 'checkbox',
					'price' => 1000,
					'editable' => true
				),
				'complex_positioning' => array(
					'title' => 'Сложное позиционирование',
					'type' => 'checkbox',
					'price' => 1000,
					'editable' => true
				)
			)
		),
		'inner_layouts' => array(
			'title' => 'Макеты внутренних страниц',
			'params' => array(
				'number' => array(
					'title' => 'Количество',
					'type' => 'integer',
					'price' => array(
						'static' => 500,
						'rubber' => 700,
						'adaptive' => 800
					),
					'per_inner_layout' => true
				),
				'inner_tabs' => array(
					'title' => 'Верстка внутренних табов',
					'type' => 'integer',
					'coefficient' => 'float',
					'coefficient_value' => 0.6,
					'price' => 'inner_layout_price',
					'editable_coefficient' => true
				),
				'change_grid' => array(
					'title' => 'Смена сетки',
					'type' => 'checkbox',
					'price' => 2000,
					'editable' => true
				)
			)
		),
		'compatibility' => array(
			'title' => 'Совместимость',
			'params' => array(
				'ie7' => array(
					'title' => 'Internet Explorer 7',
					'type' => 'checkbox',
					'price' => 200,
					'per_layout' => true
				),
				'ie8' => array(
					'title' => 'Internet Explorer 8',
					'type' => 'checkbox',
					'price' => 100,
					'per_layout' => true
				),
				'ff_old' => array(
					'title' => 'Mozilla Firefox < v14',
					'type' => 'checkbox',
					'price' => 50,
					'per_layout' => true
				),
				'opera' => array(
					'title' => 'Opera',
					'type' => 'checkbox',
					'price' => 50,
					'per_layout' => true
				),
				'no_graceful_degradation' => array(
					'title' => 'Не использовать graceful degradation',
					'type' => 'checkbox',
					'price' => 2000,
					'editable' => true
				),
				'ipad3_iphone4' => array(
					'title' => 'iPad 3 / iPhone 4',
					'type' => 'checkbox',
					'price' => 2000,
					'editable' => true
				),
				'microformats' => array(
					'title' => 'Микроформаты',
					'type' => 'checkbox',
					'price' => 500
				)
			)
		),
		'main_params' => array(
			'title' => 'Основные характеристки',
			'params' => array(
				'horizontal_alignment' => array(
					'title' => 'Выравнивание по горизонтали',
					'type' => 'radio',
					'values' => array(
						'left' => array (
							'title' => 'По левому краю'
						),
						'center' => array (
							'title' => 'По центру'
						),
						'right' => array (
							'title' => 'По правому краю'
						)
					)
				),
				'vertical_alignment' => array(
					'title' => 'Выравнивание по вертикали',
					'type' => 'radio',
					'values' => array(
						'top' => array (
							'title' => 'По вехнему краю'
						),
						'middle' => array (
							'title' => 'По середине'
						),
						'bottom' => array (
							'title' => 'По нижнему краю'
						)
					)
				),
				'pinned_footer' => array(
					'title' => 'Прижатый футер',
					'type' => 'checkbox'
				)
			)
		),
		'other_params' => array(
			'title' => 'Дополнительные характеристики',
			'params' => array(
				'print_css' => array(
					'title' => 'Версия для печати',
					'type' => 'checkbox',
					'price' => 2000,
					'editable' => true
				),
				'wai_2.0' => array(
					'title' => 'WAI v2.0',
					'type' => 'checkbox',
					'price' => 2000
				),
				'non_web_fonts' => array(
					'title' => 'Кастомные шрифты',
					'type' => 'checkbox',
					'values' => array(
						'add_font_face' => array (
							'title' => '@font-face',
						),
						'cufon' => array (
							'title' => 'Cufon',
						),
						'cifr' => array (
							'title' => 'cIFR',
						)
					),
					'price' => 500,
					'element' => 'text',
					'element_ajax_add' => true,
					'element_count' => true,
					'element_count_editable' => true,
					'per_element' => true
				),
				'commented_html' => array(
					'title' => 'Комментарии в HTML',
					'type' => 'checkbox',
					'price' => 200
				),
				'commented_css' => array(
					'title' => 'Комментарии в CSS',
					'type' => 'checkbox',
					'price' => 200
				),
				'css_reset' => array(
					'title' => 'CSS Reset',
					'type' => 'radio',
					'values' => array(
						'our' => array (
							'title' => 'Parametrika.custom'
						),
						'eric_meyer' => array (
							'title' => 'Eric Meyer'
						),
						'yui' => array (
							'title' => 'YUI'
						)
					)
				),
				'custom_video_player' => array(
					'title' => 'Кастомный проигрыватель видео',
					'type' => 'checkbox',
					'price' => 200
				)
			)
		),
		'speed_optimization' => array(
			'title' => 'Оптимизация по скорости',
			'params' => array(
				'sprites' => array(
					'title' => 'Склейка в спрайты',
					'type' => 'checkbox',
					'price' => 2000
				),
				'image_optimazation' => array(
					'title' => 'Оптимизация изображений',
					'type' => 'checkbox',
					'price' => 500
				),
				'css_gzip' => array(
					'title' => 'CSS gzip',
					'type' => 'checkbox',
					'price' => 200
				)
			)
		)
	)
);

?>