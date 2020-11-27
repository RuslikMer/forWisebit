<?php
$I = new AcceptanceTester($scenario);
$I->amOnUrl('https://yandex.ru/video/');
$I->search('ураган');
$I->checkVideoPreview();