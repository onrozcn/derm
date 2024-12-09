<?php
$parameters = array(
	// BEGIN KATEGORI
	'ana' => array(
		'categoryTitle'  => 'Ana Parametreler',
		'categoryFields' => array(
            // BEGIN FIELD
            'sirketler' => array(
                'permission' => array('superadmin', 'admin'),
                'title'      => 'Şirketler',
                'icon'       => 'fal fa-industry-alt',
                'orderby'    => 'sort_order',
                'isCommon'   => true,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'tag',
                        'label'    => 'Kısa İsim',
                        'length'   => 10,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'unvan',
                        'label'    => 'Ünvan',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'address',
                        'label'    => 'Adres',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'tel',
                        'label'    => 'Telefon',
                        'length'   => 18,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'fax',
                        'label'    => 'Fax',
                        'length'   => 18,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'mail_address',
                        'label'    => 'Mail',
                        'length'   => 100,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'mail_imap_address',
                        'label'    => 'IMAP Adres',
                        'length'   => 100,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'mail_imap_port',
                        'label'    => 'IMAP Port',
                        'length'   => 100,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'mail_smtp_address',
                        'label'    => 'SMTP Adres',
                        'length'   => 100,
                        'show'     => true,
                        'required' => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'mail_smtp_port',
                        'label'    => 'SMTP Port',
                        'length'   => 100,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'truefalse',
                        'name'     => 'mail_ssl',
                        'label'    => 'SSL',
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'mail_password',
                        'label'    => 'Mail Şifre',
                        'length'   => 100,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
            // BEGIN FIELD
            'parabirimleri' => array(
                'permission' => array('superadmin', 'admin'),
                'title'      => 'Para Birimleri',
                'icon'       => 'fal fa-coin',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'kod',
                        'label'    => 'Birim Kodu',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'sembol',
                        'label'    => 'Birim Sembolü',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
            // BEGIN FIELD
            'ibanbankakodlar' => array(
                'permission' => array('superadmin', 'admin'),
                'title'      => 'Iban Banka Kodlari',
                'icon'       => 'fal fa-university',
                'orderby'    => 'sort_order',
                'isCommon'   => true,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'kod',
                        'label'    => 'Kod',
                        'length'   => 4,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'tag',
                        'label'    => 'Kısa İsim',
                        'length'   => 9,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'unvan',
                        'label'    => 'Ünvan',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
		),
	),
	// END KATEGORI


	// BEGIN KATEGORI
	'odm' => array(
		'categoryTitle'  => 'Ödeme Parametreleri',
		'categoryFields' => array(
            // BEGIN FIELD
            'borclusirketler' => array(
                'permission' => array('superadmin', 'admin', 'odmParameterManage'),
                'title'      => 'Sirketler',
                'icon'       => 'fal fa-industry-alt',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'tag',
                        'label'    => 'Kısa İsim',
                        'length'   => 10,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'unvan',
                        'label'    => 'Ünvan',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'color',
                        'name'     => 'color',
                        'label'    => 'Renk',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
            // BEGIN FIELD
            'odemeyerleri' => array(
                'permission' => array('superadmin', 'admin', 'odmParameterManage'),
                'title'      => 'Ödeme Yeri',
                'icon'       => 'fal fa-address-card',
                'orderby'    => 'unvan',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'unvan',
                        'label'    => 'Ünvan',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => true
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'vergino',
                        'label'    => 'Vergi No',
                        'length'   => 11,
                        'show'     => true,
                        'required' => true,
                        'unique'   => true
                    ),
                    array(
                        'type'     => 'truefalse',
                        'name'     => 'default_duzenli_odeme',
                        'label'    => 'Düzenli Ödeme',
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'try_iban',
                        'label'    => 'Iban TL',
                        'length'   => 32,
                        'show'     => true,
                        'required' => false,
                        'unique'   => true,
                        'class'    => 'inputmaskIban text-monospace'
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'usd_iban',
                        'label'    => 'Iban USD',
                        'length'   => 32,
                        'show'     => true,
                        'required' => false,
                        'unique'   => true,
                        'class'    => 'inputmaskIban text-monospace'
                    ),
                ),
            ),
            // END FIELD

            // BEGIN FIELD
            'kategoriler' => array(
                'permission' => array('superadmin', 'admin', 'odmParameterManage'),
                'title'      => 'Ödeme Kategorisi',
                'icon'       => 'fal fa-comments-dollar',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'kategori',
                        'label'    => 'Ödeme Kategorisi',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'color',
                        'name'     => 'color',
                        'label'    => 'Renk',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
            // BEGIN FIELD
            'odemeyontemleri' => array(
                'permission' => array('superadmin', 'admin', 'odmParameterManage'),
                'title'      => 'Ödeme Yöntemi',
                'icon'       => 'fal fa-sack',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'yontem',
                        'label'    => 'Ödeme Yöntemi',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
		),
	),
	// END KATEGORI

    // BEGIN KATEGORI
    'ham' => array(
        'categoryTitle'  => 'Hammadde Parametreleri',
        'categoryFields' => array(
            // BEGIN FIELD
            'nakliyeciler' => array(
                'permission' => array('superadmin', 'admin', 'hamParameterManage'),
                'title'      => 'Nakliyeciler',
                'icon'       => 'fas fa-truck',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'tag',
                        'label'    => 'Kısa İsim',
                        'length'   => 10,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'unvan',
                        'label'    => 'Ünvan',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
            // BEGIN FIELD
            'nakliyetarifeleri' => array(
                'permission' => array('superadmin', 'admin', 'hamParameterManage'),
                'title'      => 'Nakliye Tarifeleri',
                'icon'       => 'fas fa-box-usd',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'parameter',
                        'parameter'=> 'param_ham_nakliyeciler',
                        'param_field' => 'tag',
                        'name'     => 'nakliyeciler_id',
                        'label'    => 'Nakliyeci',
                        'length'   => 11,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'parameter',
                        'parameter'=> 'param_ham_ocaklar',
                        'param_field' => 'tag',
                        'name'     => 'ocaklar_id',
                        'label'    => 'Ocak',
                        'length'   => 11,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'parameter',
                        'parameter'=> 'param_ana_sirketler',
                        'param_field' => 'tag',
                        'name'     => 'fabrikalar_id',
                        'label'    => 'Fabrika',
                        'length'   => 11,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'fiyat',
                        'label'    => 'Fiyat',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
            // BEGIN FIELD
            'sahalar' => array(
                'permission' => array('superadmin', 'admin', 'hamParameterManage'),
                'title'      => 'Sahalar',
                'icon'       => 'fas fa-hurricane',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'parameter',
                        'parameter'=> 'param_ana_sirketler',
                        'param_field' => 'tag',
                        'name'     => 'fabrika',
                        'label'    => 'Fabrika',
                        'length'   => 11,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'tag',
                        'label'    => 'Kısa İsim',
                        'length'   => 10,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
            // BEGIN FIELD
            'ocaklar' => array(
                'permission' => array('superadmin', 'admin', 'hamParameterManage'),
                'title'      => 'Ocaklar',
                'icon'       => 'fas fa-mountains',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'ocak_kodu',
                        'label'    => 'Ocak Kodu',
                        'length'   => 10,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'tag',
                        'label'    => 'Kısa İsim',
                        'length'   => 10,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'unvan',
                        'label'    => 'Ünvan',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // BEGIN FIELD
            'turler' => array(
                'permission' => array('superadmin', 'admin', 'hamParameterManage'),
                'title'      => 'Türler',
                'icon'       => 'fas fa-indent',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'tag',
                        'label'    => 'Kısa İsim',
                        'length'   => 10,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
            // BEGIN FIELD
            'kaliteler' => array(
                'permission' => array('superadmin', 'admin', 'hamParameterManage'),
                'title'      => 'Kaliteler',
                'icon'       => 'fas fa-sort-numeric-up',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'parameter',
                        'parameter'=> 'param_ham_ocaklar',
                        'param_field' => 'tag',
                        'name'     => 'ocaklar_id',
                        'label'    => 'Ocak',
                        'length'   => 10,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'parameter',
                        'parameter'=> 'param_ham_turler',
                        'param_field' => 'tag',
                        'name'     => 'turler_id',
                        'label'    => 'Tür',
                        'length'   => 11,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'isim',
                        'label'    => 'İsim',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'fiyat',
                        'label'    => 'Fiyat',
                        'length'   => 100,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'aciklama',
                        'label'    => 'Açıklama',
                        'length'   => 200,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
        ),
    ),
    // END KATEGORI


	// BEGIN KATEGORI
	'dep' => array(
		'categoryTitle'  => 'Yakıt Modülü Parametreleri',
		'categoryFields' => array(
            // BEGIN FIELD
            'araclar' => array(
                'permission' => array('superadmin', 'admin', 'depParameterManage'),
                'title'      => 'Araçlar',
                'icon'       => 'fas fa-car-side',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'plaka',
                        'label'    => 'Plaka',
                        'length'   => 20,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'marka',
                        'label'    => 'Marka',
                        'length'   => 20,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'model',
                        'label'    => 'Model',
                        'length'   => 20,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'truefalse',
                        'name'     => 'calctuketim',
                        'label'    => 'Tüketimi Hesapla',
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'truefalse',
                        'name'     => 'calctuketimperiod',
                        'label'    => 'Ortalama Aylık Hesapla',
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'truefalse',
                        'name'     => 'muhtelif',
                        'label'    => 'Muhtelif',
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'aciklama',
                        'label'    => 'Açıklama',
                        'length'   => 20,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
            // BEGIN FIELD
            'tanklar' => array(
                'permission' => array('superadmin', 'admin', 'depParameterManage'),
                'title'      => 'Yakıt Tankları',
                'icon'       => 'fas fa-gas-pump',
                'orderby'    => 'sort_order',
                'isCommon'   => false,
                'fields'     => array(
                    array(
                        'type'     => 'int',
                        'name'     => 'id',
                        'label'    => '',
                        'length'   => 11,
                        'show'     => false,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'kisa_isim',
                        'label'    => 'Kısa İsim',
                        'length'   => 10,
                        'show'     => true,
                        'required' => true,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'isim',
                        'label'    => 'İsim',
                        'length'   => 20,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'truefalse',
                        'name'     => 'tank_hesapla',
                        'label'    => 'Tank Hesapla ',
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'kapasite',
                        'label'    => 'Kapasite',
                        'length'   => 5,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                    array(
                        'type'     => 'varchar',
                        'name'     => 'aciklama',
                        'label'    => 'Açıklama',
                        'length'   => 100,
                        'show'     => true,
                        'required' => false,
                        'unique'   => false
                    ),
                ),
            ),
            // END FIELD
		),
	),
	// END KATEGORI

);