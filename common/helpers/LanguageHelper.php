<?php

namespace common\helpers;

use Yii;
use yii\helpers\Url;

class LanguageHelper {

    static public function languageLinksForNav() {
        $result = [];

        foreach (Yii::$app->params['languages'] as $code => $label) {
            $url = Url::current(['lang' => $code]);
            $result[] = ['label' => $label, 'url' => $url];
        }

        return $result;
    }

    static public function percentageTranslationForLang($code) {
        $source_messages_count = Yii::$app->db->createCommand("
            SELECT COUNT(*) 
                FROM source_message", [])->queryScalar();
        $trans_messages_count = Yii::$app->db->createCommand("
            SELECT COUNT(*) 
                FROM message
                    WHERE language=:language AND translation IS NOT NULL", [
                    'language' => $code,
                ])->queryScalar();
        return self::cal_percentage($trans_messages_count, $source_messages_count);
    }

    static public function cal_percentage($num_amount, $num_total) {
        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);
        return $count;
    }

}
