<?php
$settings_model = array(
/*
	'99'    => array(
		'title'  => 'Ayar Demo Model',
		'hidden' => false,
		'icon'   => 'fal fa-cog',
		'fields' => array(
			array(
				'type'       => 'int',
                'empty'      => false,
				'name'       => 'dbNameColumn',
				'label'      => 'int',
				'desc'       => 'aciklama',
				'length'     => 11,
				'show'       => true,
				'required'   => false
			),
			array(
				'type'       => 'varchar',
                'empty'      => false,
				'name'       => 'dbNameColumn',
				'label'      => 'varchar',
                'desc'       => 'aciklama',
				'length'     => 1000,
				'show'       => true,
				'required'   => false
			),
			array(
				'type'       => 'combobox',
                'empty'      => false,
				'name'       => 'dbNameColumn',
				'label'      => 'combobox',
                'desc'       => 'aciklama',
				'length'     => 1000,
				'show'       => true,
				'required'   => false,
				'values'     => array(
					array(0, 'Disabled'),
					array(10, '10'),
					array(20, '20'),
					array(30, '30'),
					array(40, '40'),
					array(50, '50'),
					array(60, '60')
				),
			),
			array(
				'type'       => 'dbcombobox',
                'empty'      => false,
				'name'       => 'dbNameColumn',
				'label'      => 'dbcombobox',
                'desc'       => 'aciklama',
				'length'     => 10,
				'show'       => true,
				'required'   => false,
				'table'      => 'param_ana_sirketler',
				'valuefield' => 'id',
				'textfield'  => 'tag',
			),
            array(
                'type'       => 'switch',
                'empty'      => false,
                'name'       => 'dbNameColumn',
                'label'      => 'switch',
                'desc'       => 'aciklama',
                'length'     => 11,
                'show'       => true,
                'required'   => false
            ),
            array(
                'type'       => 'bit',
                'empty'      => false,
                'name'       => 'dbNameColumn',
                'label'      => 'bit',
                'desc'       => 'aciklama',
                'length'     => 11,
                'show'       => true,
                'required'   => false
            ),
		)
	),
*/

    /* GENEL AYARLAR */
    '1'    => array(
        'title'  => 'Genel Ayarlar',
        'hidden' => false,
        'icon'   => 'fal fa-cog',
        'fields' => array(
            array(
                'type'       => 'switch',
                'empty'      => false,
                'name'       => 'super-maintinance',
                'label'      => 'Super Bakım Modu',
                'desc'       => 'Sadece superadmin yetkisine sahip kullanıcılar giriş yapabilir.',
                'length'     => 11,
                'show'       => true,
                'required'   => false
            ),
            array(
                'type'       => 'switch',
                'empty'      => false,
                'name'       => 'maintinance',
                'label'      => 'Bakım Modu',
                'desc'       => 'Sadece admin yetkisine sahip kullanıcılar giriş yapabilir.',
                'length'     => 11,
                'show'       => true,
                'required'   => false
            ),
            array(
                'type'       => 'switch',
                'empty'      => false,
                'name'       => 'telegram_send_notification',
                'label'      => 'Telegram Mesaj Gönderme',
                'desc'       => 'Telegram mesaj gönderme aktif olsun mu?',
                'length'     => 11,
                'show'       => true,
                'required'   => false
            ),
            array(
                'type'       => 'varchar',
                'empty'      => false,
                'name'       => 'telegram_token',
                'label'      => 'Telegram Token',
                'desc'       => 'https://api.telegram.org/bot{API}/getUpdates',
                'length'     => 1000,
                'show'       => true,
                'required'   => false
            ),

        )
    ),

    /* Bilgilendirme Ayarlari */
    '2'    => array(
        'title'  => 'Bilgilendirme Ayarları',
        'hidden' => false,
        'icon'   => 'fal fa-bell',
        'fields' => array(
            array(
                'type'       => 'dbmultibox',
                'empty'      => false,
                'name'       => 'gvn_aracgiriscikis_telegram_list',
                'label'      => 'Guvenlik Giris Cikis Telegram List',
                'desc'       => 'Secili kullanicilara telegram uzerinden bilgilendirme yapilacak',
                'length'     => 10,
                'show'       => true,
                'required'   => false,
                'table'      => 'users',
                'valuefield' => 'telegram_chatid',
                'textfield'  => 'username',
            ),
        )
    ),

    /* AYAR MODEL */
    '3'    => array(
        'title'  => '-Ayar Model-',
        'hidden' => false,
        'icon'   => 'fal fa-clone',
        'fields' => array(
            array(
                'type'       => 'int',
                'empty'      => false,
                'name'       => 'dbNameColumn',
                'label'      => 'int',
                'desc'       => 'aciklama',
                'length'     => 11,
                'show'       => true,
                'required'   => false
            ),
            array(
                'type'       => 'varchar',
                'empty'      => false,
                'name'       => 'dbNameColumn',
                'label'      => 'varchar',
                'desc'       => 'aciklama',
                'length'     => 1000,
                'show'       => true,
                'required'   => false
            ),
            array(
                'type'       => 'combobox',
                'empty'      => false,
                'name'       => 'dbNameColumn',
                'label'      => 'combobox',
                'desc'       => 'aciklama',
                'length'     => 1000,
                'show'       => true,
                'required'   => false,
                'values'     => array(
                    array(0, 'Disabled'),
                    array(10, '10'),
                    array(20, '20'),
                    array(30, '30'),
                    array(40, '40'),
                    array(50, '50'),
                    array(60, '60')
                ),
            ),
            array(
                'type'       => 'dbcombobox',
                'empty'      => false,
                'name'       => 'dbNameColumn',
                'label'      => 'dbcombobox',
                'desc'       => 'aciklama',
                'length'     => 10,
                'show'       => true,
                'required'   => false,
                'table'      => 'param_ana_sirketler',
                'valuefield' => 'id',
                'textfield'  => 'tag',
            ),
            array(
                'type'       => 'dbmultibox',
                'empty'      => false,
                'name'       => 'name',
                'label'      => 'dbmultibox',
                'desc'       => 'aciklama',
                'length'     => 10,
                'show'       => true,
                'required'   => false,
                'table'      => 'users',
                'valuefield' => 'telegram_chatid',
                'textfield'  => 'username',
            ),
            array(
                'type'       => 'switch',
                'empty'      => false,
                'name'       => 'dbNameColumn',
                'label'      => 'switch',
                'desc'       => 'aciklama',
                'length'     => 11,
                'show'       => true,
                'required'   => false
            ),
            array(
                'type'       => 'bit',
                'empty'      => false,
                'name'       => 'dbNameColumn',
                'label'      => 'bit',
                'desc'       => 'aciklama',
                'length'     => 11,
                'show'       => true,
                'required'   => false
            ),
        )
    ),





);