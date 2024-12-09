<?php
$pages = array(
    'odmOdemeTakip' => array(
        'title' => 'Genel Sayfa Bilgisi',
        'description' => 'Odeme Bilgileri sayfasi',
        'hotkeys' => array(
            'f1' => array(
                'event' => '$("#ipucuModal").modal("toggle")',
                'description' => 'Yardım',
                'display' => array('F1')
            ),
            'f2' => array(
                'event' => 'odemeFormEkle()',
                'description' => 'Yeni ekle',
                'display' => array('F2')
            ),
            'f3' => array(
                'event' => 'odemeDuzenleHeader()',
                'description' => 'Düzenle',
                'display' => array('F3')
            ),
            'f4' => array(
                'event' => 'odemeSilHeader()',
                'description' => 'Sil',
                'display' => array('F4')
            ),
            'f6' => array(
                'event' => 'odemeOnayHeader()',
                'description' => 'Ödeme Onayla',
                'display' => array('F6')
            ),
            'f7' => array(
                'event' => 'odemeDuzenleKopyalaHeader()',
                'description' => 'Kopyala',
                'display' => array('F7')
            ),
            'f8' => array(
                'event' => 'filtreleGetir()',
                'description' => 'Filtre',
                'display' => array('F8')
            ),
            'f9' => array(
                'event' => 'searchToFullScreen()',
                'description' => 'Şirkete Göre Arama',
                'display' => array('F9')
            ),




        ),
    ),
);