<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\helpers;

// Unit??

/**
 * Description of Tools
 *
 * @author atran
 */
class Tools {

  static public function force_download($filePath, $fileName = null) {
    if (file_exists($filePath)) {
      if ($fileName == null) {
        $fileName = basename($filePath);
      }
      $fileSize = filesize($filePath);

      // Output headers.
      header("Cache-Control: private");
      header("Content-Type: application/stream");
      header("Content-Length: " . $fileSize);
      header('Content-Disposition: attachment; filename="' . $fileName . '"');

      // Output file.
      readfile($filePath);
      \Yii::$app->end();
    } else {
      die('The provided file path is not valid.');
    }
  }

  static public function formatBytes($bytes, $precision = 2) {
    if ($bytes > pow(1024, 3))
      return round($bytes / pow(1024, 3), $precision) . "GB";
    else if ($bytes > pow(1024, 2))
      return round($bytes / pow(1024, 2), $precision) . "MB";
    else if ($bytes > 1024)
      return round($bytes / 1024, $precision) . "KB";
    else
      return ($bytes) . "B";
  }

  public static function array_pk_index($models) {
    if (!is_array($models)) {
      $models = array();
    }
    $result = array();
    foreach ($models as $model) {
      $result[$model->getPrimaryKey()] = $model;
    }
    return $result;
  }

  public static function errors_array($model) {
    $result = array();
    foreach ($model->getErrors() as $errors) {
      foreach ($errors as $error) {
        if ($error != '')
          $result[] = $error;
      }
    }
    return $result;
  }

  public static function copyErrors(\yii\base\Model &$from, \yii\base\Model &$to) {
    foreach ($from->getErrors() as $attribute => $errors) {
      if ($to->hasProperty($attribute)) {
        foreach ($errors as $error) {
          $to->addError($attribute, $error);
        }
      }
    }
  }

}
