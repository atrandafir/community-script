<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use common\components\MultiLingualController as Controller;

class TranslationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionLanguages() {
        return $this->render('languages');
    }
    
    public function actionCategories($language) {
        
        $languageName=Yii::$app->params['languages'][$language];
        
        $rows=Yii::$app->db->createCommand("
            SELECT source_message.category, count(source_message.message) AS msgCount, 
                count(message.translation) AS transCount 
                FROM source_message
                    LEFT JOIN message
                        ON message.id=source_message.id AND message.`language`=:language
            GROUP BY category
        ", [
            'language'=>$language,
        ])->queryAll();
        
        return $this->render('categories', compact('language','languageName', 'rows'));
    }
    
    public function actionMessages($language, $category) {
        $languageName=Yii::$app->params['languages'][$language];
        $errors=[];
        
        $rows=Yii::$app->db->createCommand("
            SELECT source_message.id, source_message.category, source_message.message, 
                message.translation
                FROM source_message
                    LEFT JOIN message
                        ON message.id=source_message.id AND message.`language`=:language
            WHERE source_message.category=:category
        ", [
            'language'=>$language,
            'category'=>$category,
        ])->queryAll();
        
        $messages=[];
        foreach ($rows as $row) {
            $messages[$row['id']]=$row['message'];
        }
        
        //\yii\helpers\VarDumper::dump($rows, 10, true);
//        \yii\helpers\VarDumper::dump($messages, 10, true); 
//        die();

        if (isset($_POST['translation'])) {
            foreach ($_POST['translation'] as $id => $translation) {
                $translation=trim($translation);
                if (empty($translation)) {
                    $translation=NULL;
                } else {
                    $original_placeholders=$this->extractPlaceholders($messages[$id]);
                    $translation_placeholders=$this->extractPlaceholders($translation);
                    if (array_diff($original_placeholders, $translation_placeholders)) {
                        $errors[$id]=Yii::t('back.translation', 'Please make sure the following placeholders are still in the string:')." ". implode(", ", $original_placeholders);
                    }
                }
                
                if (!isset($errors[$id])) {
                    Yii::$app->db->createCommand("
                    UPDATE message
                        SET translation=:translation
                    WHERE id=:id AND language=:language
                    ", [
                        'id'=>$id,
                        'language'=>$language,
                        'translation'=>$translation,
                    ])->execute();
                }
            }
            if (!$errors) {
                $this->refresh();
            }
        }
        
        return $this->render('messages', compact('language','languageName', 'rows', 'category', 'errors'));
    }
    
    private function extractPlaceholders($str) {
        preg_match_all('~\{(.+?)\}~', $str, $matches);
        return $matches[0];
    }
}
