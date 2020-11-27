<?php
/**
 * Created by PhpStorm.
 * User: rusli
 * Date: 27.11.2020
 * Time: 16:28
 */
use Codeception\Util\Locator;

class AcceptanceTester  extends \Codeception\Actor
{
    //поиск
    public function search($text)
    {
        $I = $this;

        $I->waitForElementVisible(['class' => 'search2__input']);
        $I->fillField(['name' => 'text'], $text);
        $I->click(['class' => 'websearch-button__text']);
        $I->waitForElementVisible('//div[@class="serp-list__items"][contains(.,"ураган")]');
    }

    //проверка превью у видео при наведении мышки
    public function checkVideoPreview()
    {
        $I = $this;

        $elements = count($I->grabMultiple('//div[@class="thumb-image__preview thumb-preview__target"]'));
        $elNum = mt_rand(1, $elements);
        $I->moveMouseOver('(//div[@class="thumb-image__preview thumb-preview__target"])['.$elNum.']');
        $I->waitForElementVisible('//div[@class="thumb-image__preview thumb-preview__target thumb-preview__target_playing"]');
    }
}